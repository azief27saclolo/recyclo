<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Admin;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

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
        
        if ($validated['status'] == 'rejected' && isset($validated['remarks'])) {
            $shop->remarks = $validated['remarks'];
        }
        
        $shop->save();
        
        return redirect()->route('admin.shops')
            ->with('success', "Shop '{$shop->shop_name}' status updated to {$validated['status']}");
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
                $query->where('status', 'completed');
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
                $query->where('status', 'completed');
            }], 'total_amount')
            ->findOrFail($id);
        
        // Prevent null total_sales
        $seller->total_sales = $seller->total_sales ?? 0;
        
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
        $products = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.products', compact('products'));
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
            $product = Post::with('user')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
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
}
