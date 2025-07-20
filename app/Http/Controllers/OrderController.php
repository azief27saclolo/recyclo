<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\DeliveryDetail;
use App\Models\DeliveryMethod;
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
                
                // Check if user is trying to buy their own product
                if ($post->user_id === Auth::id()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Habibi why you want to buy your own product? Hayya!'
                    ], 400);
                }
                
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
                    // Prepare order data (simplified)
                    $orderData = [
                        'post_id' => $post->id,
                        'buyer_id' => Auth::id(),
                        'seller_id' => $post->user->id,
                        'quantity' => $quantity,
                        'status' => 'pending',
                        'total_amount' => $post->price * $quantity,
                        'receipt_image' => $receiptPath,
                    ];
                    
                    $order = Order::create($orderData);
                    
                    // Create delivery details
                    $deliveryMethodId = DeliveryMethod::where('name', $request->delivery_method ?? 'delivery')->first()->id;
                    $deliveryFee = $request->delivery_method === 'pickup' ? 0 : 35.00;
                    
                    $deliveryData = [
                        'order_id' => $order->id,
                        'delivery_method_id' => $deliveryMethodId,
                        'status' => 'pending',
                        'delivery_fee' => $deliveryFee,
                    ];
                    
                    // Add method-specific fields
                    if ($request->delivery_method === 'pickup') {
                        $deliveryData['pickup_date'] = $request->pickup_date;
                        $deliveryData['pickup_time_slot'] = $request->pickup_time;
                        $deliveryData['pickup_notes'] = $request->pickup_notes;
                    } else {
                        // Handle delivery address based on user selection
                        if ($request->use_saved_address === 'true' && $request->delivery_address) {
                            $deliveryData['delivery_address'] = $request->delivery_address;
                        } else {
                            // Construct address from individual fields
                            $addressParts = [];
                            if ($request->delivery_address) $addressParts[] = $request->delivery_address;
                            if ($request->delivery_city) $addressParts[] = $request->delivery_city;
                            if ($request->delivery_province) $addressParts[] = $request->delivery_province;
                            if ($request->delivery_postal) $addressParts[] = $request->delivery_postal;
                            
                            $deliveryData['delivery_address'] = !empty($addressParts) 
                                ? implode(', ', $addressParts) 
                                : 'Customer will provide address';
                        }
                        $deliveryData['estimated_delivery_time'] = now()->addDays(3); // Default 3 days
                    }
                    
                    DeliveryDetail::create($deliveryData);
                    
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
                    
                    // Increment orders count for deals tracking
                    $post->incrementOrders();
                    
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
                        
                        // Prepare order data (simplified)
                        $orderData = [
                            'seller_id' => $sellerId,
                            'buyer_id' => Auth::id(),
                            'post_id' => $firstItem->product->post->id,
                            'quantity' => $items->sum('quantity'),
                            'status' => 'pending',
                            'total_amount' => $totalAmount,
                            'receipt_image' => $receiptPath,
                        ];
                        
                        // Create an order for this seller
                        $order = Order::create($orderData);
                        
                        // Create delivery details
                        $deliveryMethodId = DeliveryMethod::where('name', $request->delivery_method ?? 'delivery')->first()->id;
                        $deliveryFee = $request->delivery_method === 'pickup' ? 0 : 35.00;
                        
                        $deliveryData = [
                            'order_id' => $order->id,
                            'delivery_method_id' => $deliveryMethodId,
                            'status' => 'pending',
                            'delivery_fee' => $deliveryFee,
                        ];
                        
                        // Add method-specific fields
                        if ($request->delivery_method === 'pickup') {
                            $deliveryData['pickup_date'] = $request->pickup_date;
                            $deliveryData['pickup_time_slot'] = $request->pickup_time;
                            $deliveryData['pickup_notes'] = $request->pickup_notes;
                        } else {
                            // Handle delivery address based on user selection
                            if ($request->use_saved_address === 'true' && $request->delivery_address) {
                                $deliveryData['delivery_address'] = $request->delivery_address;
                            } else {
                                // Construct address from individual fields
                                $addressParts = [];
                                if ($request->delivery_address) $addressParts[] = $request->delivery_address;
                                if ($request->delivery_city) $addressParts[] = $request->delivery_city;
                                if ($request->delivery_province) $addressParts[] = $request->delivery_province;
                                if ($request->delivery_postal) $addressParts[] = $request->delivery_postal;
                                
                                $deliveryData['delivery_address'] = !empty($addressParts) 
                                    ? implode(', ', $addressParts) 
                                    : 'Customer will provide address';
                            }
                            $deliveryData['estimated_delivery_time'] = now()->addDays(3); // Default 3 days
                        }
                        
                        DeliveryDetail::create($deliveryData);
                        
                        // Create order items for each product
                        foreach ($items as $item) {
                            // Create order item
                            OrderItem::create([
                                'order_id' => $order->id,
                                'post_id' => $item->product->post->id,
                                'quantity' => $item->quantity,
                                'price' => $item->price,
                            ]);
                            
                            // Increment orders count for deals tracking
                            $item->product->post->incrementOrders();
                            
                            // No need to update stock here since it was already decreased when adding to cart
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
        $orders = Auth::user()->boughtOrders()->with(['items.post', 'seller', 'deliveryDetail.deliveryMethod'])->get();
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
                
                // Check if user is trying to buy their own product
                if ($post->user_id === Auth::id()) {
                    return redirect()->route('posts.show', $post->id)
                        ->with('error', 'You cannot buy your own products.');
                }
                
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
                    'quantity' => $quantity,
                    'userLocation' => Auth::user()->location
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
            'directCheckout' => false,
            'userLocation' => Auth::user()->location
        ]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Validate that the user is either the seller or the buyer
        if ($order->seller_id !== Auth::id() && $order->buyer_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        // Validate the status
        $validStatus = $request->validate([
            'status' => 'required|in:processing,delivering,delivered,for_pickup,cancelled,completed'
        ]);
                   
        $newStatus = $validStatus['status'];
        $orderAmount = null;

        // If buyer is marking as completed, only allow if current status is 'delivered'
        if ($order->buyer_id === Auth::id() && $newStatus === 'completed') {
            if ($order->status !== 'delivered') {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only mark orders as completed when they are delivered.'
                ], 400);
            }
        }
        
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

        // Only allow cancelling orders that are in 'pending' or 'processing' status
        if (!in_array($order->status, ['pending', 'processing'])) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending or processing orders can be cancelled.'
                ], 400);
            }
            return redirect()->route('orders.index')->with('error', 'Only pending or processing orders can be cancelled.');
        }

        try {
            DB::beginTransaction();

            // Get cancellation reason if provided
            $cancellationReason = request()->input('cancellation_reason');
            
            // Update order status to cancelled
            $order->status = 'cancelled';
            if ($cancellationReason) {
                $order->cancellation_reason = $cancellationReason;
            }
            $order->save();

            // Restore quantities for post and product
            if ($order->items()->exists()) {
                foreach ($order->items as $item) {
                    // Get the post
                    $post = Post::find($item->post_id);
                    if ($post) {
                        // Restore post quantity
                        $post->quantity += $item->quantity;
                        $post->save();

                        // Restore product stock if it exists
                        $product = Product::where('post_id', $post->id)->first();
                        if ($product) {
                            $product->stock += $item->quantity;
                            $product->save();
                        }
                        
                        Log::info('Stock restored for order cancellation', [
                            'order_id' => $order->id,
                            'post_id' => $post->id,
                            'product_id' => $product ? $product->id : null,
                            'quantity_restored' => $item->quantity,
                            'new_post_quantity' => $post->quantity,
                            'new_product_stock' => $product ? $product->stock : null,
                            'cancellation_reason' => $cancellationReason
                        ]);
                    }
                }
            } else {
                // Handle legacy orders without items
                $post = Post::find($order->post_id);
                if ($post) {
                    // Restore post quantity
                    $post->quantity += $order->quantity;
                    $post->save();

                    // Restore product stock if it exists
                    $product = Product::where('post_id', $post->id)->first();
                    if ($product) {
                        $product->stock += $order->quantity;
                        $product->save();
                    }
                    
                    Log::info('Stock restored for legacy order cancellation', [
                        'order_id' => $order->id,
                        'post_id' => $post->id,
                        'product_id' => $product ? $product->id : null,
                        'quantity_restored' => $order->quantity,
                        'new_post_quantity' => $post->quantity,
                        'new_product_stock' => $product ? $product->stock : null,
                        'cancellation_reason' => $cancellationReason
                    ]);
                }
            }

            DB::commit();

            Log::info('Order cancelled successfully', [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'cancellation_reason' => $cancellationReason
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