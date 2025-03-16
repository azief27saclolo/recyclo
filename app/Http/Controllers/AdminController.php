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
        $orders = Order::with(['user', 'items.post'])->orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
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
