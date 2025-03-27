<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
}
