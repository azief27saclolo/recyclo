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
use App\Models\UserReport;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Get counts for dashboard stats
        $orders_count = Order::count();
        $users_count = User::count();
        $shops_count = Shop::count();
        $products_count = Post::count();

        // Get recent activities
        $recent_activities = collect();

        // Get recent orders
        $recent_orders = Order::with(['buyer', 'post'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return [
                    'type' => 'order',
                    'icon' => 'bi-cart',
                    'title' => "New order from {$order->buyer->firstname} {$order->buyer->lastname}",
                    'description' => "Ordered {$order->post->title}",
                    'time' => $order->created_at,
                    'link' => route('admin.orders')
                ];
            });

        // Get recent shop registrations
        $recent_shops = Shop::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($shop) {
                return [
                    'type' => 'shop',
                    'icon' => 'bi-shop',
                    'title' => "New shop registered",
                    'description' => "{$shop->user->firstname} {$shop->user->lastname} registered {$shop->shop_name}",
                    'time' => $shop->created_at,
                    'link' => route('admin.shops')
                ];
            });

        // Get recent product posts
        $recent_posts = Post::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($post) {
                return [
                    'type' => 'product',
                    'icon' => 'bi-box-seam',
                    'title' => "New product listed",
                    'description' => "{$post->user->firstname} {$post->user->lastname} listed {$post->title}",
                    'time' => $post->created_at,
                    'link' => route('admin.products')
                ];
            });

        // Get recent user registrations
        $recent_users = User::latest()
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user',
                    'icon' => 'bi-person-plus',
                    'title' => "New user registered",
                    'description' => "{$user->firstname} {$user->lastname} joined Recyclo",
                    'time' => $user->created_at,
                    'link' => route('admin.users')
                ];
            });

        // Combine all activities and sort by time
        $recent_activities = $recent_activities
            ->concat($recent_orders)
            ->concat($recent_shops)
            ->concat($recent_posts)
            ->concat($recent_users)
            ->sortByDesc('time')
            ->take(10);

        // Get user registration data for the chart
        $period = $request->input('period', 'monthly'); // Default to monthly
        $userData = $this->getUserRegistrationData($period);
        
        // Get order data for the chart with separate period filter
        $orders_period = $request->input('orders_period', $period); // Default to same as user period
        $orderData = $this->getOrderData($orders_period);
        
        // Get product listing data for the chart with separate period filter
        $products_period = $request->input('products_period', $period); // Default to same as user period
        $productData = $this->getProductListingData($products_period);
        
        // Get shop registration data for the chart with separate period filter
        $shops_period = $request->input('shops_period', $period); // Default to same as user period
        $shopData = $this->getShopRegistrationData($shops_period);

        return view('admin.dashboard', compact(
            'orders_count',
            'users_count',
            'shops_count',
            'products_count',
            'recent_activities',
            'userData',
            'orderData',
            'productData',
            'shopData',
            'period',
            'orders_period',
            'products_period',
            'shops_period'
        ));
    }

    /**
     * Get user registration data for charting
     *
     * @param string $period
     * @return array
     */
    private function getUserRegistrationData($period)
    {
        $today = Carbon::today();
        $labels = [];
        $data = [];

        switch ($period) {
            case 'daily':
                // Last 14 days data
                $startDate = $today->copy()->subDays(13);
                $endDate = $today;
                
                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    $labels[] = $date->format('M d');
                    $count = User::whereDate('created_at', $date->format('Y-m-d'))->count();
                    $data[] = $count;
                }
                break;

            case 'weekly':
                // Last 12 weeks data
                $startDate = $today->copy()->startOfWeek()->subWeeks(11);
                
                for ($i = 0; $i < 12; $i++) {
                    $weekStart = $startDate->copy()->addWeeks($i);
                    $weekEnd = $weekStart->copy()->endOfWeek();
                    
                    $labels[] = "Week " . ($i + 1);
                    $count = User::whereBetween('created_at', [$weekStart, $weekEnd])->count();
                    $data[] = $count;
                }
                break;

            case 'yearly':
                // Last 5 years data
                $startYear = $today->copy()->subYears(4)->year;
                
                for ($year = $startYear; $year <= $today->year; $year++) {
                    $labels[] = (string)$year;
                    $count = User::whereYear('created_at', $year)->count();
                    $data[] = $count;
                }
                break;

            case 'monthly':
            default:
                // Last 12 months data
                $startDate = $today->copy()->subMonths(11)->startOfMonth();
                
                for ($i = 0; $i < 12; $i++) {
                    $monthStart = $startDate->copy()->addMonths($i);
                    $monthName = $monthStart->format('M Y');
                    
                    $labels[] = $monthName;
                    $count = User::whereYear('created_at', $monthStart->year)
                        ->whereMonth('created_at', $monthStart->month)
                        ->count();
                    $data[] = $count;
                }
                break;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get order data for charting
     *
     * @param string $period
     * @return array
     */
    private function getOrderData($period)
    {
        $today = Carbon::today();
        $labels = [];
        $data = [];

        switch ($period) {
            case 'daily':
                // Last 14 days data
                $startDate = $today->copy()->subDays(13);
                $endDate = $today;
                
                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    $labels[] = $date->format('M d');
                    $count = Order::whereDate('created_at', $date->format('Y-m-d'))->count();
                    $data[] = $count;
                }
                break;

            case 'weekly':
                // Last 12 weeks data
                $startDate = $today->copy()->startOfWeek()->subWeeks(11);
                
                for ($i = 0; $i < 12; $i++) {
                    $weekStart = $startDate->copy()->addWeeks($i);
                    $weekEnd = $weekStart->copy()->endOfWeek();
                    
                    $labels[] = "Week " . ($i + 1);
                    $count = Order::whereBetween('created_at', [$weekStart, $weekEnd])->count();
                    $data[] = $count;
                }
                break;

            case 'yearly':
                // Last 5 years data
                $startYear = $today->copy()->subYears(4)->year;
                
                for ($year = $startYear; $year <= $today->year; $year++) {
                    $labels[] = (string)$year;
                    $count = Order::whereYear('created_at', $year)->count();
                    $data[] = $count;
                }
                break;

            case 'monthly':
            default:
                // Last 12 months data
                $startDate = $today->copy()->subMonths(11)->startOfMonth();
                
                for ($i = 0; $i < 12; $i++) {
                    $monthStart = $startDate->copy()->addMonths($i);
                    $monthName = $monthStart->format('M Y');
                    
                    $labels[] = $monthName;
                    $count = Order::whereYear('created_at', $monthStart->year)
                        ->whereMonth('created_at', $monthStart->month)
                        ->count();
                    $data[] = $count;
                }
                break;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get product listing data for charting
     *
     * @param string $period
     * @return array
     */
    private function getProductListingData($period)
    {
        $today = Carbon::today();
        $labels = [];
        $data = [];

        switch ($period) {
            case 'daily':
                // Last 14 days data
                $startDate = $today->copy()->subDays(13);
                $endDate = $today;
                
                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    $labels[] = $date->format('M d');
                    $count = Post::whereDate('created_at', $date->format('Y-m-d'))->count();
                    $data[] = $count;
                }
                break;

            case 'weekly':
                // Last 12 weeks data
                $startDate = $today->copy()->startOfWeek()->subWeeks(11);
                
                for ($i = 0; $i < 12; $i++) {
                    $weekStart = $startDate->copy()->addWeeks($i);
                    $weekEnd = $weekStart->copy()->endOfWeek();
                    
                    $labels[] = "Week " . ($i + 1);
                    $count = Post::whereBetween('created_at', [$weekStart, $weekEnd])->count();
                    $data[] = $count;
                }
                break;

            case 'yearly':
                // Last 5 years data
                $startYear = $today->copy()->subYears(4)->year;
                
                for ($year = $startYear; $year <= $today->year; $year++) {
                    $labels[] = (string)$year;
                    $count = Post::whereYear('created_at', $year)->count();
                    $data[] = $count;
                }
                break;

            case 'monthly':
            default:
                // Last 12 months data
                $startDate = $today->copy()->subMonths(11)->startOfMonth();
                
                for ($i = 0; $i < 12; $i++) {
                    $monthStart = $startDate->copy()->addMonths($i);
                    $monthName = $monthStart->format('M Y');
                    
                    $labels[] = $monthName;
                    $count = Post::whereYear('created_at', $monthStart->year)
                        ->whereMonth('created_at', $monthStart->month)
                        ->count();
                    $data[] = $count;
                }
                break;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get shop registration data for charting
     *
     * @param string $period
     * @return array
     */
    private function getShopRegistrationData($period)
    {
        $today = Carbon::today();
        $labels = [];
        $data = [];

        switch ($period) {
            case 'daily':
                // Last 14 days data
                $startDate = $today->copy()->subDays(13);
                $endDate = $today;
                
                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    $labels[] = $date->format('M d');
                    $count = Shop::whereDate('created_at', $date->format('Y-m-d'))->count();
                    $data[] = $count;
                }
                break;

            case 'weekly':
                // Last 12 weeks data
                $startDate = $today->copy()->startOfWeek()->subWeeks(11);
                
                for ($i = 0; $i < 12; $i++) {
                    $weekStart = $startDate->copy()->addWeeks($i);
                    $weekEnd = $weekStart->copy()->endOfWeek();
                    
                    $labels[] = "Week " . ($i + 1);
                    $count = Shop::whereBetween('created_at', [$weekStart, $weekEnd])->count();
                    $data[] = $count;
                }
                break;

            case 'yearly':
                // Last 5 years data
                $startYear = $today->copy()->subYears(4)->year;
                
                for ($year = $startYear; $year <= $today->year; $year++) {
                    $labels[] = (string)$year;
                    $count = Shop::whereYear('created_at', $year)->count();
                    $data[] = $count;
                }
                break;

            case 'monthly':
            default:
                // Last 12 months data
                $startDate = $today->copy()->subMonths(11)->startOfMonth();
                
                for ($i = 0; $i < 12; $i++) {
                    $monthStart = $startDate->copy()->addMonths($i);
                    $monthName = $monthStart->format('M Y');
                    
                    $labels[] = $monthName;
                    $count = Shop::whereYear('created_at', $monthStart->year)
                        ->whereMonth('created_at', $monthStart->month)
                        ->count();
                    $data[] = $count;
                }
                break;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get price guides for a specific category
     *
     * @param string $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPriceGuides($category)
    {
        try {
            \Log::info('Fetching price guides', ['category' => $category]);
            
            $priceGuides = \App\Models\PriceGuide::where('category', $category)
                ->orderBy('type')
                ->get(['id', 'category', 'type', 'description', 'price']); // Explicitly select all needed fields
            
            \Log::info('Found price guides', [
                'category' => $category, 
                'count' => $priceGuides->count(),
                'sample' => $priceGuides->take(1)
            ]);

            return response()->json([
                'success' => true,
                'priceGuides' => $priceGuides
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching price guides', [
                'category' => $category,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load price guides: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific price guide item
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPriceGuideItem($id)
    {
        try {
            $priceGuide = \App\Models\PriceGuide::findOrFail($id);

            return response()->json([
                'success' => true,
                'priceGuide' => $priceGuide
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching price guide item', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load price guide: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Save a price guide (create or update)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePriceGuide(Request $request)
    {
        try {
            \Log::info('Saving price guide', ['data' => $request->all()]);
            
            $validatedData = $request->validate([
                'id' => 'nullable|numeric',
                'category' => 'required|string',
                'type' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|string|max:50',
            ]);

            if (empty($validatedData['id'])) {
                // Create new price guide
                $priceGuide = \App\Models\PriceGuide::create([
                    'category' => $validatedData['category'],
                    'type' => $validatedData['type'],
                    'description' => $validatedData['description'],
                    'price' => $validatedData['price'],
                ]);

                \Log::info('Price guide created', ['id' => $priceGuide->id]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Price guide added successfully',
                    'priceGuide' => $priceGuide
                ]);
            } else {
                // Update existing price guide
                $priceGuide = \App\Models\PriceGuide::find($validatedData['id']);
                
                if (!$priceGuide) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Price guide not found'
                    ], 404);
                }
                
                $priceGuide->update([
                    'category' => $validatedData['category'],
                    'type' => $validatedData['type'],
                    'description' => $validatedData['description'],
                    'price' => $validatedData['price'],
                ]);

                \Log::info('Price guide updated', ['id' => $priceGuide->id]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Price guide updated successfully',
                    'priceGuide' => $priceGuide
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error saving price guide', [
                'data' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save price guide: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a price guide
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePriceGuide($id)
    {
        try {
            $priceGuide = \App\Models\PriceGuide::findOrFail($id);
            $priceGuide->delete();

            return response()->json([
                'success' => true,
                'message' => 'Price guide deleted successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting price guide', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete price guide: ' . $e->getMessage()
            ], 500);
        }
    }

    public function orders()
    {
        $orders = Order::with(['buyer', 'seller', 'post', 'user'])->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load(['buyer', 'seller', 'post', 'user']);
        return view('admin.order_details', compact('order'));
    }
    
    public function updateOrderStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Use 'processing' status instead of 'approved' for consistency with UI
        if ($request->status === 'approved') {
            $order->status = 'processing';
        } else {
            $order->status = $request->status;
        }
        
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
            
            // Update to 'processing' status for consistency with UI
            DB::table('orders')
                ->where('id', $orderId)
                ->update(['status' => 'processing']);
            
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

    public function rejectOrder($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            // Begin transaction for atomicity
            DB::beginTransaction();
            
            try {
                // Update order status
                $order->status = 'cancelled';
                
                // Restore product quantity if the post exists
                if ($order->post) {
                    $post = $order->post;
                    $post->quantity += $order->quantity;
                    $post->save();
                }
                
                $order->save();
                
                // Commit the transaction
                DB::commit();
                
                \Log::info('Order rejected successfully', ['order_id' => $orderId]);
                
                return redirect()->back()->with('success', 'Order #' . $orderId . ' has been rejected successfully.');
            } catch (\Exception $e) {
                // Rollback the transaction in case of error
                DB::rollBack();
                
                \Log::error('Failed to reject order', [
                    'order_id' => $orderId,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return redirect()->back()->with('error', 'Failed to reject order: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reject order: ' . $e->getMessage());
        }
    }

    /**
     * Cancel an order by the user
     *
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelUserOrder($orderId)
    {
        try {
            // Find the order
            $order = Order::findOrFail($orderId);
            
            // Verify the order belongs to the authenticated user
            // Check both buyer_id and user_id for backward compatibility
            if ($order->buyer_id != auth()->id() && $order->user_id != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to cancel this order'
                ], 403);
            }
            
            // Only allow cancellation of pending or processing orders
            if (!in_array($order->status, ['pending', 'processing', 'approved'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'This order cannot be cancelled in its current status: ' . ucfirst($order->status)
                ], 400);
            }
            
            // Begin transaction for atomicity
            DB::beginTransaction();
            
            try {
                // Update order status
                $order->status = 'cancelled';
                
                // Restore product quantity if the post exists
                if ($order->post) {
                    $post = $order->post;
                    $post->quantity += $order->quantity;
                    $post->save();
                }
                
                $order->save();
                
                // Commit the transaction
                DB::commit();
                
                \Log::info('Order cancelled by user', [
                    'order_id' => $orderId,
                    'user_id' => auth()->id()
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Order #' . $orderId . ' has been cancelled successfully'
                ]);
            } catch (\Exception $e) {
                // Rollback the transaction in case of error
                DB::rollBack();
                
                \Log::error('Failed to cancel order', [
                    'order_id' => $orderId,
                    'user_id' => auth()->id(),
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to cancel order: ' . $e->getMessage()
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to find order for cancellation', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Order not found: ' . $e->getMessage()
            ], 404);
        }
    }

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
                            // Restore the quantity back to the post (legacy behavior)
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
        $users = User::orderBy('created_at', 'desc')->get();
        $reportedUsers = User::whereHas('reports')
            ->with(['reports' => function($query) {
                $query->with('reporter')->orderBy('created_at', 'desc');
            }])
            ->get();
        $reportedUsersCount = $reportedUsers->count();
        
        return view('admin.users', compact('users', 'reportedUsers', 'reportedUsersCount'));
    }

    public function getReportDetails($id)
    {
        try {
            $report = UserReport::with(['reporter', 'reported'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'report' => $report
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Report not found'
            ], 404);
        }
    }

    public function updateUserStatus(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:active,suspended,inactive'
            ]);
            // Update user status
            $user->status = $validated['status'];
            $user->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "User {$user->username}'s status updated to {$validated['status']}",
                    'user' => $user
                ]);
            }

            return redirect()->route('admin.users')
                ->with('success', "User {$user->username}'s status updated to {$validated['status']}");
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update user status: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.users')
                ->with('error', 'Failed to update user status: ' . $e->getMessage());
        }
    }

    public function getUser(User $user)
    {
        try {
            // Return the user with shop relationship
            $user->load('shop');
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showUser(User $user)
    {
        try {
            // Load user relationships
            $user->load(['shop', 'posts' => function($query) {
                $query->latest();
            }]);
            
            // Check if user has a shop or posts
            if ($user->shop || $user->posts->count() > 0) {
                // If user has a shop or posts, set them as seller
                if ($user->role !== 'seller') {
                    $user->update(['role' => 'seller']);
                }
                
                // If user has a shop, ensure it's active
                if ($user->shop && !$user->shop->is_active) {
                    $user->shop->update(['is_active' => true]);
                }
            }
            
            // Get user's order history - using buyer_id instead of user_id
            $orders = Order::where('buyer_id', $user->id)
                ->with(['post', 'seller'])
                ->latest()
                ->get();
            
            return view('admin.user_details', compact('user', 'orders'));
        } catch (\Exception $e) {
            \Log::error('Failed to load user details', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('admin.users')
                ->with('error', 'Failed to load user details: ' . $e->getMessage());
        }
    }

    public function updateUser(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    \Illuminate\Validation\Rule::unique('users')->ignore($user->id)
                ],
                'username' => [
                    'required',
                    'string',
                    'max:255',
                    \Illuminate\Validation\Rule::unique('users')->ignore($user->id)
                ],
                'birthday' => 'required|date',
                'number' => 'nullable|string|max:20',
                'location' => 'nullable|string|max:255',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle profile picture upload if provided
            if ($request->hasFile('profile_picture')) {
                // Delete old profile picture if it exists
                if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
                $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
            }

            // Update user information
            $user->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "User {$user->username}'s information has been updated successfully",
                    'user' => $user
                ]);
            }

            return redirect()->route('admin.users')
                ->with('success', "User {$user->username}'s information has been updated successfully");
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update user: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.users')
                ->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function deleteUser(User $user)
    {
        try {
            // Store user information for the success message
            $username = $user->username;

            // Delete user's profile picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Delete the user
            $user->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "User {$username} has been deleted successfully"
                ]);
            }

            return redirect()->route('admin.users')
                ->with('success', "User {$username} has been deleted successfully");
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete user: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.users')
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
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

        // Handle remarks field
        if ($validated['status'] == 'rejected') {
            $shop->remarks = $validated['remarks'] ?? 'Application rejected by admin';
        } else if ($validated['status'] == 'approved') {
            // Clear remarks when approving
            $shop->remarks = null;
        } else {
            // For pending, keep existing remarks or use new ones if provided
            $shop->remarks = $validated['remarks'] ?? $shop->remarks;
        };
        
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

    public function products()
    {
        // Get all approved products with their user information
        $products = Post::with(['user', 'category'])
            ->where('status', Post::STATUS_APPROVED) // Show only approved posts
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get pending post requests with user information
        $pendingPosts = Post::where('status', Post::STATUS_PENDING)
            ->with('user', 'category')
            ->latest()
            ->paginate(10);
        
        // Get pending post requests count for notification badge
        $pendingPostsCount = Post::where('status', Post::STATUS_PENDING)->count();
        
        // Get categories for the filter dropdown
        $categories = Category::where('is_active', true)->orderBy('name')->get();
            
        return view('admin.products', compact('products', 'pendingPosts', 'pendingPostsCount', 'categories'));
    }

    // We'll keep this method for backward compatibility or direct access
    public function postRequests()
    {
        return redirect()->route('admin.products');
    }

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

    public function getProductDetails($id)
    {
        try {
            \Log::info('Fetching product details', ['id' => $id]);
            
            // Explicitly find the post without using with() first to ensure it exists
            $product = Post::findOrFail($id);
            // Now load the relationships
            $product->load(['user', 'category']);
            
            // Ensure images have the correct path
            if ($product->image && !str_contains($product->image, '://')) {
                // Keep the image path as is, we'll prepend storage/ in the view
            }
            
            // Get stored request information if available
            $requestInfo = [
                'id' => $id,
                'user_agent' => request()->header('User-Agent'),
                'ip_address' => request()->ip(),
            ];
            
            \Log::info('Product details found', [
                'id' => $id, 
                'title' => $product->title
            ]);
            
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
                'message' => 'Product not found: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 404);
        }
    }

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

            // If it's an AJAX request, return JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product updated successfully',
                    'product' => $product
                ]);
            }

            return redirect()->route('admin.products')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to update product', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // If it's an AJAX request, return JSON error
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update product: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->route('admin.products')
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = Post::findOrFail($id);
            $productTitle = $product->title; // Store this for the success message

            // If product has an image, delete it from storage
            if ($product->image && \Storage::exists('public/' . $product->image)) {
                \Storage::delete('public/' . $product->image);
            }
            
            $product->delete();

            // Check if request is AJAX
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Product '{$productTitle}' deleted successfully"
                ]);
            }

            return redirect()->route('admin.products')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to delete product', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete product: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.products')
                ->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

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

    public function updateUserRole(User $user)
    {
        try {
            $user->update([
                'role' => 'seller'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User role updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user role: ' . $e->getMessage()
            ], 500);
        }
    }

    public function activateShop(Shop $shop)
    {
        try {
            $shop->update([
                'is_active' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Shop activated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to activate shop: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getTransactionChartData(Request $request)
    {
        $period = $request->input('period', 'monthly');
        $today = Carbon::today();
        $labels = [];
        $transactions = [];
        $revenue = [];

        switch ($period) {
            case 'daily':
                // Last 14 days data
                $startDate = $today->copy()->subDays(13);
                $endDate = $today;
                
                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    $labels[] = $date->format('M d');
                    $dayData = Order::whereDate('created_at', $date->format('Y-m-d'))
                        ->selectRaw('COUNT(*) as count, SUM(total_amount) as total')
                        ->first();
                    $transactions[] = $dayData->count ?? 0;
                    $revenue[] = $dayData->total ?? 0;
                }
                break;

            case 'weekly':
                // Last 12 weeks data
                $startDate = $today->copy()->startOfWeek()->subWeeks(11);
                
                for ($i = 0; $i < 12; $i++) {
                    $weekStart = $startDate->copy()->addWeeks($i);
                    $weekEnd = $weekStart->copy()->endOfWeek();
                    
                    $labels[] = "Week " . ($i + 1);
                    $weekData = Order::whereBetween('created_at', [$weekStart, $weekEnd])
                        ->selectRaw('COUNT(*) as count, SUM(total_amount) as total')
                        ->first();
                    $transactions[] = $weekData->count ?? 0;
                    $revenue[] = $weekData->total ?? 0;
                }
                break;

            case 'yearly':
                // Last 5 years data
                $startYear = $today->copy()->subYears(4)->year;
                
                for ($year = $startYear; $year <= $today->year; $year++) {
                    $labels[] = (string)$year;
                    $yearData = Order::whereYear('created_at', $year)
                        ->selectRaw('COUNT(*) as count, SUM(total_amount) as total')
                        ->first();
                    $transactions[] = $yearData->count ?? 0;
                    $revenue[] = $yearData->total ?? 0;
                }
                break;

            case 'monthly':
            default:
                // Last 12 months data
                $startDate = $today->copy()->subMonths(11)->startOfMonth();
                
                for ($i = 0; $i < 12; $i++) {
                    $monthStart = $startDate->copy()->addMonths($i);
                    $monthName = $monthStart->format('M Y');
                    
                    $labels[] = $monthName;
                    $monthData = Order::whereYear('created_at', $monthStart->year)
                        ->whereMonth('created_at', $monthStart->month)
                        ->selectRaw('COUNT(*) as count, SUM(total_amount) as total')
                        ->first();
                    $transactions[] = $monthData->count ?? 0;
                    $revenue[] = $monthData->total ?? 0;
                }
                break;
        }

        return response()->json([
            'success' => true,
            'chartData' => [
                'labels' => $labels,
                'transactions' => $transactions,
                'revenue' => $revenue
            ]
        ]);
    }

    public function restrictUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = 'restricted';
            $user->save();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User has been restricted successfully.'
                ]);
            }

            return back()->with('success', 'User has been restricted successfully.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while restricting the user.'
                ], 500);
            }

            return back()->with('error', 'An error occurred while restricting the user.');
        }
    }

    public function unrestrictUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = 'active';
            $user->save();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User has been unrestricted successfully.'
                ]);
            }

            return back()->with('success', 'User has been unrestricted successfully.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while unrestricting the user.'
                ], 500);
            }

            return back()->with('error', 'An error occurred while unrestricting the user.');
        }
    }
}