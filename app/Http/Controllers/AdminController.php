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
        // Get all orders with related information
        $orders = Order::with(['user', 'buyer', 'seller', 'post'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.orders', compact('orders'));
    }
    
    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled'
        ]);
        
        $order->status = $validated['status'];
        $order->save();
        
        return redirect()->route('admin.orders')
            ->with('success', "Order #{$order->id} status updated to {$validated['status']}");
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
        $shops = Shop::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.shops', compact('shops'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
