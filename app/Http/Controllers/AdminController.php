<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get counts for dashboard stats
        $orders_count = Order::count();
        $users_count = User::count();
        $shops_count = Shop::count();

        // Check if order_items table exists before using the relationship
        if (Schema::hasTable('order_items')) {
            // Get recent orders with their relationships
            $recent_orders = Order::with(['user'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } else {
            // Get only orders without items relationship
            $recent_orders = Order::orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('admin.dashboard', compact('orders_count', 'users_count', 'shops_count', 'recent_orders'));
    }

    public function orders()
    {
        $orders = Order::with(['buyer', 'seller', 'post', 'user'])->latest()->get();
        return view('admin.orders', compact('orders'));
    }
    
    public function updateOrderStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $request->status;
        $order->save();
        
        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    /**
     * Approve an order
     *
     * @param int $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveOrder($orderId)
    {
        try {
            // Add logging
            \Log::info('Approving order', ['order_id' => $orderId]);
            
            $order = Order::findOrFail($orderId);
            
            // Force update of status attribute directly in database
            DB::table('orders')
                ->where('id', $orderId)
                ->update(['status' => 'approved']);
            
            \Log::info('Order approved successfully', ['order_id' => $orderId]);
            
            return redirect()->back()->with('success', 'Order #' . $orderId . ' has been approved successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to approve order', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Failed to approve order: ' . $e->getMessage());
        }
    }

    /**
     * Reject an order
     *
     * @param int $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectOrder($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            $order->status = 'cancelled';
            $order->save();
            
            return redirect()->back()->with('success', 'Order #' . $orderId . ' has been rejected successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reject order: ' . $e->getMessage());
        }
    }

    /**
     * Delete an order
     *
     * @param int $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteOrder($orderId)
    {
        try {
            // Find the order
            $order = Order::findOrFail($orderId);
            
            // Store the order ID for the success message
            $orderIdForMessage = $order->id;
            
            // Begin transaction
            DB::beginTransaction();
            
            // If order has receipt image, delete it from storage
            if ($order->receipt_image && Storage::disk('public')->exists($order->receipt_image)) {
                Storage::disk('public')->delete($order->receipt_image);
            }
            
            // If order has items (order_items relationship), delete them first
            if (Schema::hasTable('order_items')) {
                $order->items()->delete();
            }
            
            // If the order status was not 'completed' or 'cancelled', restore product quantities
            if (!in_array($order->status, ['completed', 'cancelled'])) {
                // If using order_items
                if (Schema::hasTable('order_items') && $order->items()->exists()) {
                    foreach ($order->items as $item) {
                        $post = Post::find($item->post_id);
                        if ($post) {
                            // Restore the quantity back to the post
                            $post->quantity += $item->quantity;
                            $post->save();
                        }
                    }
                } else {
                    // If using direct post_id on orders (legacy behavior)
                    $post = Post::find($order->post_id);
                    if ($post) {
                        // Restore quantity
                        $post->quantity += $order->quantity;
                        $post->save();
                    }
                }
            }
            
            // Delete the order
            $order->delete();
            
            // Commit the transaction
            DB::commit();
            
            return redirect()->route('admin.orders')
                ->with('success', "Order #$orderIdForMessage has been deleted successfully.");
                
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            
            \Log::error('Failed to delete order', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('admin.orders')
                ->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }

    public function users()
    {
        // Get users with their shop information
        $users = User::with('shop')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.users', compact('users'));
    }
    
    public function updateUserStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,suspended,inactive'
        ]);
        
        // Update user status
        $user->status = $validated['status'];
        $user->save();
        
        return redirect()->route('admin.users')
            ->with('success', "User {$user->username}'s status updated to {$validated['status']}");
    }

    public function shops()
    {
        // Get all shops including pending registration requests
        $shops = Shop::with('user')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get counts for each status
        $pendingCount = $shops->where('status', 'pending')->count();
        $approvedCount = $shops->where('status', 'approved')->count();
        $rejectedCount = $shops->where('status', 'rejected')->count();
        
        return view('admin.shops', compact('shops', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    public function updateShopStatus(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'remarks' => 'nullable|string|max:255',
        ]);
        
        $shop->status = $validated['status'];
        $originalStatus = $shop->getOriginal('status');
        
        // Handle remarks field
        if ($validated['status'] == 'rejected') {
            $shop->remarks = $validated['remarks'] ?? 'Application rejected by admin';
        } else if ($validated['status'] == 'approved') {
            // Clear remarks when approving
            $shop->remarks = null;
        } else {
            // For pending, keep existing remarks or use new ones if provided
            $shop->remarks = $validated['remarks'] ?? $shop->remarks;
        }
        
        // Save the changes
        $shop->save();
        
        // Prepare SweetAlert2 message
        $title = '';
        $text = '';
        $icon = 'success';
        
        switch($validated['status']) {
            case 'approved':
                $title = 'Shop Approved';
                $text = "Shop '{$shop->shop_name}' has been approved successfully.";
                break;
            case 'rejected':
                $title = 'Shop Rejected';
                $text = "Shop '{$shop->shop_name}' has been rejected with provided reason.";
                break;
            case 'pending':
                $title = 'Status Updated';
                $text = "Shop '{$shop->shop_name}' has been set to pending status.";
                break;
        }
        
        // Flash SweetAlert2 message to session
        session()->flash('swalSuccess', [
            'title' => $title,
            'text' => $text,
            'icon' => $icon
        ]);
        
        return redirect()->route('admin.shops');
    }

    /**
     * Get shop details for editing
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShopDetails($id)
    {
        try {
            $shop = Shop::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'shop' => $shop
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load shop details: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update shop details
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editShop(Request $request, $id)
    {
        try {
            $shop = Shop::findOrFail($id);
            
            // Validate the request
            $validated = $request->validate([
                'shop_name' => 'required|string|max:255',
                'shop_address' => 'required|string',
                'status' => 'required|in:pending,approved,rejected',
                'remarks' => 'nullable|string|max:255',
                'valid_id' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ]);
            
            // Update shop details
            $shop->shop_name = $validated['shop_name'];
            $shop->shop_address = $validated['shop_address'];
            $shop->status = $validated['status'];
            
            // Handle remarks
            if ($validated['status'] == 'rejected') {
                $shop->remarks = $validated['remarks'] ?? 'Application rejected by admin';
            } else {
                $shop->remarks = $validated['remarks'];
            }
            
            // Handle new valid ID if uploaded
            if ($request->hasFile('valid_id')) {
                // Delete old ID file if exists
                if ($shop->valid_id_path && \Storage::disk('public')->exists($shop->valid_id_path)) {
                    \Storage::disk('public')->delete($shop->valid_id_path);
                }
                
                // Store the new ID
                $validIdPath = $request->file('valid_id')->store('shop_documents', 'public');
                $shop->valid_id_path = $validIdPath;
            }
            
            // Save changes
            $shop->save();
            
            return redirect()->route('admin.shops')
                ->with('success', "Shop '{$shop->shop_name}' updated successfully");
        } catch (\Exception $e) {
            return redirect()->route('admin.shops')
                ->with('error', 'Failed to update shop: ' . $e->getMessage());
        }
    }

    /**
     * Delete a shop
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function deleteShop($id)
    {
        try {
            $shop = Shop::findOrFail($id);
            
            // Store shop information for message
            $shopName = $shop->shop_name;
            
            // Delete valid ID file from storage if it exists
            if ($shop->valid_id_path && \Storage::disk('public')->exists($shop->valid_id_path)) {
                \Storage::disk('public')->delete($shop->valid_id_path);
            }
            
            // Delete the shop record
            $shop->delete();
            
            // Check if the request is Ajax
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Shop '{$shopName}' has been deleted successfully. The owner can now register a new shop."
                ]);
            }
            
            // Flash a message to the session for SweetAlert2
            session()->flash('swalSuccess', [
                'title' => 'Shop Deleted',
                'text' => "Shop '{$shopName}' has been deleted successfully. The owner can now register a new shop.",
                'icon' => 'success'
            ]);
            
            return redirect()->route('admin.shops');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete shop: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.shops')
                ->with('error', 'Failed to delete shop: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Display transaction reports and analytics
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function reports(Request $request)
    {
        // Get filters from request
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $status = $request->input('status', 'all');
        $search = $request->input('search');
        
        // Build transaction query
        $query = Order::with(['buyer', 'seller', 'post', 'user']);
        
        // Apply date filters if provided
        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }
        
        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }
        
        // Apply status filter if not 'all'
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        // Apply search if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('buyer', function($q) use ($search) {
                    $q->where('firstname', 'like', "%{$search}%")
                      ->orWhere('lastname', 'like', "%{$search}%");
                })
                ->orWhereHas('seller', function($q) use ($search) {
                    $q->where('firstname', 'like', "%{$search}%")
                      ->orWhere('lastname', 'like', "%{$search}%");
                })
                ->orWhereHas('post', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            });
        }
        
        // Execute the query with pagination
        $transactions = $query->latest()->paginate(10);
        
        // Calculate summary statistics
        $totalTransactions = $query->count();
        $totalRevenue = $query->sum('total_amount');
        $averageOrderValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;
        
        // Get sellers with their stats
        $sellers = User::whereHas('posts')
            ->withCount('posts')
            ->withSum(['soldOrders as total_sales' => function($query) {
                $query->where('orders.status', 'completed');  // Specify the table name for status column
            }], 'total_amount')
            ->paginate(10);
            
        // Convert null values to 0 for total_sales
        $sellers->transform(function($seller) {
            $seller->total_sales = $seller->total_sales ?? 0;
            return $seller;
        });

        return view('admin.reports', compact(
            'transactions',
            'totalTransactions',
            'totalRevenue',
            'averageOrderValue',
            'sellers'
        ));
    }

    /**
     * Get detailed seller information for modal
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSellerDetails($id)
    {
        $seller = User::with(['shop', 'posts.orders'])
            ->withCount('posts')
            ->withSum(['soldOrders as total_sales' => function($query) {
                $query->where('orders.status', 'completed');  // Also fix this query for consistency
            }], 'total_amount')
            ->findOrFail($id);
        
        // Get seller transactions
        $transactions = Order::where('seller_id', $id)
            ->with(['buyer', 'post'])
            ->latest()
            ->take(10)
            ->get();
            
        // Get seller products
        $products = Post::where('user_id', $id)
            ->withCount('orders')
            ->latest()
            ->take(6)
            ->get();
            
        // Render the seller details HTML
        $html = View::make('admin.partials.seller_details', [
            'seller' => $seller,
            'transactions' => $transactions,
            'products' => $products
        ])->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    /**
     * Get detailed transaction information for modal
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTransactionDetails($id)
    {
        $transaction = Order::with(['buyer', 'seller', 'post'])
            ->findOrFail($id);
            
        // Render the transaction details HTML
        $html = View::make('admin.partials.transaction_details', [
            'transaction' => $transaction
        ])->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
    
    /**
     * Export reports to CSV
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportReports(Request $request)
    {
        // Get filters from request
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $status = $request->input('status', 'all');
        $search = $request->input('search');
        
        // Build transaction query with the same filters as the report page
        $query = Order::with(['buyer', 'seller', 'post']);
        
        // Apply date filters if provided
        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }
        
        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }
        
        // Apply status filter if not 'all'
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        // Apply search if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('buyer', function($q) use ($search) {
                    $q->where('firstname', 'like', "%{$search}%")
                      ->orWhere('lastname', 'like', "%{$search}%");
                })
                ->orWhereHas('seller', function($q) use ($search) {
                    $q->where('firstname', 'like', "%{$search}%")
                      ->orWhere('lastname', 'like', "%{$search}%");
                })
                ->orWhereHas('post', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            });
        }
        
        // Get all records for export
        $transactions = $query->latest()->get();
        
        // Create a filename
        $filename = 'recyclo_transactions_report_' . Carbon::now()->format('Y-m-d') . '.csv';
        
        // Create a temporary file
        $handle = fopen('php://temp', 'w+');
        
        // Add CSV header
        fputcsv($handle, [
            'Transaction ID',
            'Date',
            'Buyer',
            'Seller',
            'Product',
            'Quantity',
            'Unit',
            'Amount',
            'Status'
        ]);
        
        // Add each transaction as a CSV row
        foreach ($transactions as $transaction) {
            fputcsv($handle, [
                $transaction->id,
                $transaction->created_at->format('Y-m-d H:i:s'),
                $transaction->buyer ? $transaction->buyer->firstname . ' ' . $transaction->buyer->lastname : 'N/A',
                $transaction->seller ? $transaction->seller->firstname . ' ' . $transaction->seller->lastname : 'N/A',
                $transaction->post ? $transaction->post->title : 'N/A',
                $transaction->quantity,
                $transaction->post ? $transaction->post->unit : 'N/A',
                $transaction->total_amount,
                ucfirst($transaction->status)
            ]);
        }
        
        // Reset file pointer to the beginning
        rewind($handle);
        
        // Get all content from the file
        $content = stream_get_contents($handle);
        fclose($handle);
        
        // Create response with CSV content
        $response = response($content)
            ->withHeaders([
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
            
        return $response;
    }

    /**
     * Display all products
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        // Get all products with their user information
        $products = Post::with(['user', 'category'])
            ->where('status', Post::STATUS_APPROVED) // Show only approved posts
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get pending post requests count for notification badge
        $pendingPostsCount = Post::where('status', Post::STATUS_PENDING)->count();
            
        return view('admin.products', compact('products', 'pendingPostsCount'));
    }
    
    /**
     * Display pending post requests
     *
     * @return \Illuminate\Http\Response
     */
    public function postRequests()
    {
        $pendingPosts = Post::where('status', Post::STATUS_PENDING)
            ->with('user', 'category')
            ->latest()
            ->paginate(15);
            
        return view('admin.post_requests', compact('pendingPosts'));
    }
    
    /**
     * Approve a post request
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approvePost($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->status = Post::STATUS_APPROVED;
            $post->admin_remarks = null; // Clear any previous remarks
            $post->save();
            
            return redirect()->back()->with('success', "Post '{$post->title}' has been approved successfully.");
        } catch (\Exception $e) {
            \Log::error('Failed to approve post', [
                'post_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Failed to approve post: ' . $e->getMessage());
        }
    }
    
    /**
     * Reject a post request
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectPost(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->status = Post::STATUS_REJECTED;
            $post->admin_remarks = $request->input('remarks', 'Post rejected by admin');
            $post->save();
            
            return redirect()->back()->with('success', "Post '{$post->title}' has been rejected.");
        } catch (\Exception $e) {
            \Log::error('Failed to reject post', [
                'post_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Failed to reject post: ' . $e->getMessage());
        }
    }
    
    /**
     * Get product details for the modal
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductDetails($id)
    {
        try {
            $product = Post::with(['user', 'category'])->findOrFail($id);
            
            // Get stored request information if available
            $requestInfo = [
                'id' => $id,
                'user_agent' => request()->header('User-Agent'),
                'ip_address' => request()->ip(),
            ];
            
            return response()->json([
                'success' => true,
                'product' => $product,
                'request_info' => $requestInfo
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching product details', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get post request details for the modal (specifically for pending posts)
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPostRequestDetails($id)
    {
        try {
            \Log::info('Fetching post request details', ['post_id' => $id]);
            
            // Explicitly find the post without using with() first to ensure it exists
            $post = Post::findOrFail($id);
            
            // Now load the relationships
            $post->load(['user', 'category']);
            
            // Ensure category is properly handled
            $category = $post->category;
            $categoryName = is_object($category) ? $category->name : $post->category;
            
            // Get request information
            $requestInfo = [
                'id' => $id,
                'user_agent' => request()->header('User-Agent'),
                'ip_address' => request()->ip(),
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ];
            
            \Log::info('Post request details found', [
                'post_id' => $id, 
                'title' => $post->title,
                'category' => $categoryName
            ]);
            
            return response()->json([
                'success' => true,
                'product' => $post, // Use 'product' key for consistency with frontend
                'request_info' => $requestInfo
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching post request details', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Post request not found: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 404);
        }
    }
    
    /**
     * Update a product
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Post::findOrFail($id);
            
            // Validate the request
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string',
                'price' => 'required|numeric|min:0',
                'unit' => 'required|string|max:50',
                'quantity' => 'required|numeric|min:0',
                'location' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3000',
            ]);
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($product->image && \Storage::disk('public')->exists($product->image)) {
                    \Storage::disk('public')->delete($product->image);
                }
                
                // Store the new image
                $path = \Storage::disk('public')->put('posts_images', $request->file('image'));
                $validatedData['image'] = $path;
            }
            
            // Update the product
            $product->update($validatedData);
            
            return redirect()->route('admin.products')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.products')
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete a product
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProduct($id)
    {
        try {
            $product = Post::findOrFail($id);
            
            // If product has an image, delete it from storage
            if ($product->image && \Storage::exists('public/' . $product->image)) {
                \Storage::delete('public/' . $product->image);
            }
            
            $product->delete();
            
            return redirect()->route('admin.products')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.products')
                ->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    /**
     * Get all categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories()
    {
        try {
            $categories = Category::orderBy('name')->get();
            
            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load categories: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add a new category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCategory(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:50',
                'description' => 'nullable|string',
                'color' => 'nullable|string',
            ]);
            
            // Check if a category with this name already exists but is inactive
            $existingCategory = Category::where('name', $validatedData['name'])->first();
            
            if ($existingCategory) {
                // If it exists but is inactive, reactivate it
                if (!$existingCategory->is_active) {
                    $existingCategory->is_active = true;
                    $existingCategory->description = $validatedData['description'] ?? $existingCategory->description;
                    $existingCategory->color = $validatedData['color'] ?? $existingCategory->color;
                    $existingCategory->save();
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Category reactivated successfully',
                        'category' => $existingCategory
                    ]);
                } else {
                    // If it's already active, return an error
                    return response()->json([
                        'success' => false,
                        'message' => 'A category with this name already exists'
                    ], 422);
                }
            }
            
            // Create a new category if it doesn't exist
            $category = Category::create([
                'name' => $validatedData['name'],
                'slug' => \Illuminate\Support\Str::slug($validatedData['name']),
                'description' => $validatedData['description'] ?? null,
                'color' => $validatedData['color'] ?? '#517A5B',
                'is_active' => true
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Category added successfully',
                'category' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a category (Migration of products to replacement category)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCategory(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'replacement_category_id' => 'required|exists:categories,id|different:category_id'
            ]);
            
            $category = Category::findOrFail($validatedData['category_id']);
            $replacementCategory = Category::findOrFail($validatedData['replacement_category_id']);
            
            // Count products in this category
            $productCount = Post::where('category_id', $category->id)->count();
            
            // Update all products in this category to the replacement category
            Post::where('category_id', $category->id)
                ->update([
                    'category_id' => $replacementCategory->id,
                    'category' => $replacementCategory->name // Update text field for backward compatibility
                ]);
            
            // Mark the category as inactive
            $category->is_active = false;
            $category->save();
            
            return response()->json([
                'success' => true,
                'message' => "Category \"{$category->name}\" removed successfully. {$productCount} products moved to \"{$replacementCategory->name}\" category.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove category: ' . $e->getMessage()
            ], 500);
        }
    }
}
