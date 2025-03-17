<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Order request received', $request->all());
            
            // Validate the request
            $validated = $request->validate([
                'post_id' => ['required', 'exists:posts,id'],
                'quantity' => ['required', 'integer', 'min:1'],
            ]);
            
            $post = Post::findOrFail($request->post_id);
            
            // Calculate total amount including delivery fee
            $totalAmount = ($post->price * $request->quantity) + 35;

            $order = Order::create([
                'seller_id' => $post->user_id,
                'buyer_id' => Auth::id(),
                'post_id' => $request->post_id,
                'quantity' => $request->quantity,
                'status' => 'pending', // Ensure status is a string
                'total_amount' => $totalAmount, 
            ]);

            Log::info('Order created successfully', ['order_id' => $order->id]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Order request submitted successfully',
                'order_id' => $order->id
            ]);
            
        } catch (Exception $e) {
            // Log the error with detailed information
            Log::error('Order creation error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
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