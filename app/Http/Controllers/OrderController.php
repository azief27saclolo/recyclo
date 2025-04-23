<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Order request received', $request->all());
            
            // Validate the request
            $validated = $request->validate([
                'receipt_image' => ['required', 'image', 'max:5120'], // Max 5MB
            ]);
            
            // Get the user's active cart
            $cart = Cart::where('user_id', Auth::id())->where('status', 'active')->first();
            
            if (!$cart || $cart->items->count() === 0) {
                Log::error('Empty cart during checkout');
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.'
                ], 422);
            }
            
            // Store receipt image
            $receiptPath = null;
            if ($request->hasFile('receipt_image')) {
                $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
                Log::info('Receipt image saved', ['path' => $receiptPath]);
            }

            // Use transaction to ensure all database operations succeed or fail together
            DB::beginTransaction();
            try {
                // Create separate orders for each shop's products
                $shopOrders = [];
                
                // Get cart items with proper eager loading to avoid N+1 queries
                $cartItems = $cart->items()->with(['product.post.user'])->get();
                
                // Filter out any items with incomplete data
                $validCartItems = $cartItems->filter(function($item) {
                    return $item->product && $item->product->post && $item->product->post->user;
                });
                
                if ($validCartItems->isEmpty()) {
                    throw new Exception("No valid products found in cart");
                }
                
                // Group by seller ID with null check
                $groupedItems = $validCartItems->groupBy(function($item) {
                    return $item->product->post->user->id;
                });
                
                foreach ($groupedItems as $sellerId => $items) {
                    $firstItem = $items->first();
                    $sellerUser = $firstItem->product->post->user;
                    
                    // Calculate total amount for this seller's items
                    $totalAmount = $items->sum(function($item) {
                        return $item->quantity * $item->price;
                    });
                    
                    // Get the first post_id to use as the main post_id for the order
                    // This maintains compatibility with the existing database structure
                    $primaryPostId = $firstItem->product->post->id;
                    
                    // Create an order for this seller
                    $order = Order::create([
                        'seller_id' => $sellerId,
                        'buyer_id' => Auth::id(),
                        'post_id' => $primaryPostId, // Use the first item's post_id instead of null
                        'quantity' => $items->sum('quantity'),
                        'status' => 'pending',
                        'total_amount' => $totalAmount,
                        'receipt_image' => $receiptPath,
                    ]);
                    
                    // Create order items for each product
                    foreach ($items as $item) {
                        // Get post associated with product
                        $post = $item->product->post;
                        
                        // Create order item
                        OrderItem::create([
                            'order_id' => $order->id,
                            'post_id' => $post->id,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                        ]);
                        
                        // Decrease post quantity
                        if ($post->quantity < $item->quantity) {
                            throw new Exception("Not enough quantity available for product: {$post->title}");
                        }
                        
                        $post->quantity -= $item->quantity;
                        $post->save();
                        
                        // Update product stock if exists
                        if ($item->product) {
                            $item->product->stock -= $item->quantity;
                            $item->product->save();
                        }
                    }
                    
                    $shopOrders[] = $order;
                }
                
                // Mark cart as checked out and empty it
                $cart->status = 'completed';
                $cart->save();
                
                // Create a new active cart for the user
                Cart::create([
                    'user_id' => Auth::id(),
                    'status' => 'active',
                    'total' => 0
                ]);
                
                DB::commit();
                
                Log::info('Orders created successfully', [
                    'order_count' => count($shopOrders),
                    'order_ids' => collect($shopOrders)->pluck('id')
                ]);
                
                // Return success response
                return response()->json([
                    'success' => true,
                    'message' => 'Order requests submitted successfully',
                    'order_ids' => collect($shopOrders)->pluck('id')
                ]);
                
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
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
        // Get the current user's active cart
        $cart = Cart::where('user_id', Auth::id())->where('status', 'active')->first();
        
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        // Load products and posts with eager loading to reduce database queries
        $cart->load(['items.product.post.user', 'items.product.user.shop']);
        
        // Check for missing or invalid products
        $validItems = 0;
        foreach ($cart->items as $item) {
            if ($item->product && $item->product->post) {
                $validItems++;
            }
        }
        
        if ($validItems === 0) {
            return redirect()->route('cart.index')->with('error', 'All products in your cart are no longer available.');
        }
        
        if ($validItems < $cart->items->count()) {
            session()->flash('warning', 'Some products in your cart are no longer available.');
        }
        
        return view('orders.checkout', [
            'cart' => $cart,
            'totalPrice' => $cart->total
        ]);
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
        
        // If status is being changed to cancelled, restore the product quantities
        if ($newStatus === 'cancelled') {
            // Get all order items
            foreach ($order->items as $item) {
                $post = Post::find($item->post_id);
                
                if ($post) {
                    // Restore the quantity from the order item back to the post
                    $post->quantity += $item->quantity;
                    $post->save();
                    
                    // Restore any associated product stock
                    $product = Product::where('post_id', $post->id)->first();
                    if ($product) {
                        $product->stock += $item->quantity;
                        $product->save();
                        
                        Log::info('Product stock restored after order cancellation', [
                            'product_id' => $product->id,
                            'new_stock' => $product->stock
                        ]);
                    }
                    
                    Log::info('Post quantity restored after order cancellation', [
                        'post_id' => $post->id,
                        'new_quantity' => $post->quantity
                    ]);
                }
            }
        }
        
        // If status is being changed to completed, we don't need to update quantities again
        // as we already decreased them when the order was created
        if ($newStatus === 'completed') {
            // Store the order amount for the earnings update
            $orderAmount = $order->total_amount;
            
            Log::info('Order completed', [
                'order_id' => $order->id,
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

    /**
     * Cancel an order
     * 
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function cancelOrder(Order $order)
    {
        $isAjax = request()->expectsJson() || request()->ajax();
        
        // Verify that the authenticated user owns this order
        if ($order->buyer_id !== Auth::id()) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to cancel this order.'
                ], 403);
            }
            return redirect()->route('orders.index')->with('error', 'You are not authorized to cancel this order.');
        }

        // Only allow cancelling orders that are in 'pending' status
        if ($order->status !== 'pending') {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending orders can be cancelled.'
                ], 400);
            }
            return redirect()->route('orders.index')->with('error', 'Only pending orders can be cancelled.');
        }

        try {
            DB::beginTransaction();

            // Update order status to cancelled
            $order->status = 'cancelled';
            $order->save();

            // Restore quantities for post and product
            // Get all order items (if using order items)
            if ($order->items()->exists()) {
                foreach ($order->items as $item) {
                    $post = Post::find($item->post_id);
                    
                    if ($post) {
                        // Restore the quantity back to the post
                        $post->quantity += $item->quantity;
                        $post->save();
                        
                        // Restore the associated product stock if exists
                        $product = Product::where('post_id', $post->id)->first();
                        if ($product) {
                            $product->stock += $item->quantity;
                            $product->save();
                        }
                    }
                }
            } else {
                // If using direct post_id on orders (legacy behavior)
                $post = Post::find($order->post_id);
                if ($post) {
                    // Restore quantity
                    $post->quantity += $order->quantity;
                    $post->save();
                    
                    // Restore associated product stock if exists
                    $product = Product::where('post_id', $post->id)->first();
                    if ($product) {
                        $product->stock += $order->quantity;
                        $product->save();
                    }
                }
            }

            DB::commit();

            Log::info('Order cancelled successfully', [
                'order_id' => $order->id,
                'user_id' => Auth::id()
            ]);

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your order has been cancelled successfully.',
                    'order_id' => $order->id
                ]);
            }
            return redirect()->route('orders.index')->with('success', 'Your order has been cancelled successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error cancelling order: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while cancelling your order. Please try again.',
                    'error' => $e->getMessage()
                ], 500);
            }
            return redirect()->route('orders.index')->with('error', 'An error occurred while cancelling your order. Please try again.');
        }
    }
}