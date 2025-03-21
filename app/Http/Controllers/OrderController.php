<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
                'receipt_image' => ['required', 'image', 'max:5120'], // Max 5MB
            ]);
            
            // Find the post and make sure it exists
            $post = Post::findOrFail($request->post_id);
            
            // Additional check to make sure the post is valid and has a price
            if (!$post || !isset($post->price) || $post->price === null) {
                Log::error('Post exists but price is null', ['post_id' => $request->post_id]);
                return response()->json([
                    'success' => false,
                    'message' => 'The selected product is not available for purchase.'
                ], 422);
            }
            
            // Calculate total amount including delivery fee
            $totalAmount = ($post->price * $request->quantity) + 35;
            
            // Store receipt image
            $receiptPath = null;
            if ($request->hasFile('receipt_image')) {
                $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
                Log::info('Receipt image saved', ['path' => $receiptPath]);
            }

            $order = Order::create([
                'seller_id' => $post->user_id,
                'buyer_id' => Auth::id(),
                'post_id' => $request->post_id,
                'quantity' => $request->quantity,
                'status' => 'pending', 
                'total_amount' => $totalAmount,
                'receipt_image' => $receiptPath,
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
        // Find post and validate it exists
        $post = Post::find($request->post_id);
        
        // If post doesn't exist or has no price, redirect to posts with error
        if (!$post || !isset($post->price) || $post->price === null) {
            return redirect()->route('posts')->with('error', 'The selected product is no longer available.');
        }
        
        $quantity = $request->quantity;
        $totalPrice = ($post->price * $quantity) + 35; // Add delivery fee
        return view('orders.checkout', ['post' => $post, 'quantity' => $quantity, 'totalPrice' => $totalPrice]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Validate seller owns this order
        if ($order->seller_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        // Validate the status
        $validStatus = $request->validate([
            'status' => 'required|in:processing,delivering,for_pickup,cancelled,completed'
        ]);

        $newStatus = $validStatus['status'];
        $orderAmount = null;
        
        // If status is being changed to completed, update product quantity
        if ($newStatus === 'completed') {
            // Get the post (product) associated with the order
            $post = Post::find($order->post_id);
            
            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.'
                ], 404);
            }
            
            // Check if there's enough quantity to fulfill the order
            if ($post->quantity < $order->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough product quantity available to complete this order.'
                ], 400);
            }
            
            // Decrease the product quantity
            $post->quantity -= $order->quantity;
            $post->save();
            
            // Store the order amount for the earnings update
            $orderAmount = $order->total_amount;
            
            Log::info('Product quantity updated after order completion', [
                'order_id' => $order->id,
                'post_id' => $post->id,
                'old_quantity' => $post->quantity + $order->quantity,
                'new_quantity' => $post->quantity,
                'order_amount' => $orderAmount
            ]);
        }

        // Update order status
        $order->status = $newStatus;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'status' => $order->status,
            'orderAmount' => $orderAmount
        ]);
    }
}