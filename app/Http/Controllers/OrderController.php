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
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

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
            
            // Check if this is a direct checkout
            if ($request->has('direct_checkout') && $request->has('post_id') && $request->has('quantity')) {
                // This is a direct product checkout
                $post = Post::with('user')->findOrFail($request->post_id);
                $quantity = (int)$request->quantity;
                
                // Validate quantity
                if ($post->quantity < $quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'The requested quantity exceeds available stock.'
                    ], 422);
                }
                
                // Store receipt image
                $receiptPath = null;
                if ($request->hasFile('receipt_image')) {
                    $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
                    Log::info('Receipt image saved', ['path' => $receiptPath]);
                }
                
                // Create the order
                DB::beginTransaction();
                try {
                    $order = Order::create([
                        'post_id' => $post->id,
                        'buyer_id' => Auth::id(),
                        'seller_id' => $post->user->id,
                        'quantity' => $quantity,
                        'status' => 'pending',
                        'total_amount' => $post->price * $quantity,
                        'receipt_image' => $receiptPath,
                    ]);
                    
                    // Create order item
                    OrderItem::create([
                        'order_id' => $order->id,
                        'post_id' => $post->id,
                        'quantity' => $quantity,
                        'price' => $post->price,
                    ]);
                    
                    // Decrease post quantity
                    $post->quantity -= $quantity;
                    $post->save();
                    
                    DB::commit();
                    
                    Log::info('Direct checkout order created successfully', [
                        'order_id' => $order->id,
                        'post_id' => $post->id,
                        'quantity' => $quantity
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Order request submitted successfully',
                        'order_id' => $order->id
                    ]);
                } catch (Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            } else {
                // Regular cart checkout
                // Get the user's active cart with all necessary relationships
                $cart = Cart::where('user_id', Auth::id())
                    ->where('status', 'active')
                    ->with(['items.product.post.user', 'items.product.user'])
                    ->first();
                
                if (!$cart || $cart->items->isEmpty()) {
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
                    
                    // Get cart items with proper eager loading
                    $cartItems = $cart->items;
                    
                    // Debug logging for cart items
                    Log::info('Cart Items Debug:', [
                        'total_items' => $cartItems->count(),
                        'items' => $cartItems->map(function($item) {
                            return [
                                'item_id' => $item->id,
                                'product_id' => $item->product_id,
                                'has_product' => $item->product ? 'yes' : 'no',
                                'has_post' => $item->product && $item->product->post ? 'yes' : 'no',
                                'has_user' => $item->product && $item->product->user ? 'yes' : 'no',
                                'product_name' => $item->product ? $item->product->name : 'N/A'
                            ];
                        })->toArray()
                    ]);
                    
                    // Filter out any items with missing products or posts
                    $validCartItems = $cartItems->filter(function($item) {
                        return $item->product && 
                               $item->product->post && 
                               $item->product->user && 
                               $item->product->post->user;
                    });
                    
                    if ($validCartItems->isEmpty()) {
                        Log::error('No valid products found in cart', [
                            'cart_id' => $cart->id,
                            'user_id' => Auth::id(),
                            'total_items' => $cartItems->count(),
                            'valid_items' => $validCartItems->count()
                        ]);
                        throw new Exception("No valid products found in cart");
                    }
                    
                    // Group by seller ID
                    $groupedItems = $validCartItems->groupBy(function($item) {
                        return $item->product->user_id;
                    });
                    
                    foreach ($groupedItems as $sellerId => $items) {
                        $firstItem = $items->first();
                        $sellerUser = $firstItem->product->user;
                        
                        // Calculate total amount for this seller's items
                        $totalAmount = $items->sum(function($item) {
                            return $item->quantity * $item->price;
                        });
                        
                        // Create an order for this seller
                        $order = Order::create([
                            'seller_id' => $sellerId,
                            'buyer_id' => Auth::id(),
                            'post_id' => $firstItem->product->post->id,
                            'quantity' => $items->sum('quantity'),
                            'status' => 'pending',
                            'total_amount' => $totalAmount,
                            'receipt_image' => $receiptPath,
                        ]);
                        
                        // Create order items for each product
                        foreach ($items as $item) {
                            // Create order item
                            OrderItem::create([
                                'order_id' => $order->id,
                                'post_id' => $item->product->post->id,
                                'quantity' => $item->quantity,
                                'price' => $item->price,
                            ]);
                            
                            // Update product stock and post quantity
                            if ($item->product) {
                                if ($item->product->stock < $item->quantity) {
                                    throw new Exception("Not enough stock available for product: {$item->product->name}");
                                }
                                
                                // Update product stock
                                $item->product->stock -= $item->quantity;
                                $item->product->save();
                                
                                // Update post quantity
                                $post = $item->product->post;
                                if ($post) {
                                    $post->quantity -= $item->quantity;
                                    $post->save();
                                }
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
        // Check if we're doing a direct checkout from product page
        if ($request->has('direct') && $request->has('post_id') && $request->has('quantity')) {
            try {
                // Validate parameters
                $validatedData = $request->validate([
                    'post_id' => 'required|exists:posts,id',
                    'quantity' => 'required|integer|min:1'
                ]);
                
                $post_id = $request->post_id;
                $quantity = $request->quantity;
                
                // Find the post
                $post = Post::with('user')->findOrFail($post_id);
                
                // Check if quantity is valid
                if ($post->quantity < $quantity) {
                    return redirect()->route('posts.show', $post->id)
                        ->with('error', 'The requested quantity exceeds available stock.');
                }
                
                // Create a temporary cart-like structure for the view
                $cartItem = new \stdClass();
                $cartItem->quantity = $quantity;
                $cartItem->price = $post->price;
                $cartItem->product = new \stdClass();
                $cartItem->product->post = $post;
                
                $cart = new \stdClass();
                $cart->items = collect([$cartItem]);
                $cart->is_direct_checkout = true;
                
                $totalPrice = $quantity * $post->price;
                
                return view('orders.checkout', [
                    'cart' => $cart,
                    'totalPrice' => $totalPrice,
                    'post' => $post,
                    'directCheckout' => true,
                    'quantity' => $quantity
                ]);
            } catch (\Exception $e) {
                \Log::error('Direct checkout error: ' . $e->getMessage());
                return redirect()->route('posts.show', $request->post_id)
                    ->with('error', 'An error occurred while processing your checkout request.');
            }
        }
        
        // Regular cart checkout flow
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
            'totalPrice' => $cart->total,
            'directCheckout' => false
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

    public function export($format)
    {
        $filename = 'orders-' . date('Y-m-d') . '.' . $format;
        
        switch ($format) {
            case 'pdf':
                return Excel::download(new OrdersExport('pdf'), $filename, \Maatwebsite\Excel\Excel::DOMPDF);
            case 'csv':
                return Excel::download(new OrdersExport('csv'), $filename, \Maatwebsite\Excel\Excel::CSV);
            case 'doc':
                return Excel::download(new OrdersExport('doc'), $filename, \Maatwebsite\Excel\Excel::XLSX);
            default:
                return Excel::download(new OrdersExport('xlsx'), $filename, \Maatwebsite\Excel\Excel::XLSX);
        }
    }
}