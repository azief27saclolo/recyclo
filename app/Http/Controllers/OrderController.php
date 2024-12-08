<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => ['required', 'exists:posts,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $post = Post::find($request->post_id);

        $order = Order::create([
            'seller_id' => $post->user_id,
            'buyer_id' => Auth::id(),
            'post_id' => $request->post_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['success' => true]);
    }

    public function index()
    {
        $orders = Auth::user()->boughtOrders()->with('post')->get();

        return view('orders.index', ['orders' => $orders]);
    }

    public function checkout(Request $request)
    {
        $post = Post::find($request->post_id);
        $quantity = $request->quantity;
        $totalPrice = ($post->price * $quantity) + 35; // Add delivery fee
        return view('orders.checkout', ['post' => $post, 'quantity' => $quantity, 'totalPrice' => $totalPrice]);
    }
}