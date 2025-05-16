<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display the user's cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the current user's active cart
        $cart = $this->getOrCreateCart();
        
        // Load cart items with all necessary relationships
        $cart->load(['items.product.post', 'items.product.user']);
        
        // Check for and handle missing products
        $this->handleMissingProducts($cart);
        
        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $product = Product::with('post')->findOrFail($request->product_id);
            
            // Verify product has a post
            if (!$product->post) {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is no longer available.'
                ], 422);
            }

            // Get the current user's cart to check existing quantities
            $cart = $this->getOrCreateCart();
            $existingCartItem = CartItem::where('cart_id', $cart->id)
                                      ->where('product_id', $product->id)
                                      ->first();
            
            // Check if requested quantity is available
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available. Only ' . $product->stock . ' items left.'
                ], 422);
            }

            $newQuantity = $request->quantity;
            if ($existingCartItem) {
                // Update quantity if product already exists
                $existingCartItem->quantity += $newQuantity;
                $existingCartItem->save();
                $message = "{$product->name} quantity updated in your cart!";
            } else {
                // Add new item to cart
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $newQuantity,
                    'price' => $product->price
                ]);
                $message = "{$product->name} added to your cart!";
            }
            
            // Update product stock and post quantity
            $product->stock -= $newQuantity;
            $product->save();
            
            if ($product->post) {
                $product->post->quantity -= $newQuantity;
                $product->post->save();
            }

            // Refresh the product to ensure we have the latest data
            $product->refresh();
            
            $this->updateCartTotal($cart);
            
            DB::commit();
            
            // Check if the request wants JSON response (for AJAX)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'message' => $message]);
            }
            
            // Otherwise, redirect back with a flash message
            return back()->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error adding to cart: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding to cart: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error adding to cart: ' . $e->getMessage());
        }
    }

    /**
     * Update the quantity of a cart item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateQuantity(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);
            
            $cartItem = CartItem::with('product.post')->findOrFail($id);
            $cart = $cartItem->cart;
            
            // Ensure the cart belongs to the current user
            if ($cart->user_id !== Auth::id()) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized action.'
                    ], 403);
                }
                return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
            }
            
            $product = $cartItem->product;
            $oldQuantity = $cartItem->quantity;
            $newQuantity = $request->quantity;
            $quantityDifference = $newQuantity - $oldQuantity;
            
            // Check if new quantity is available
            if ($quantityDifference > 0 && $product->stock < $quantityDifference) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available. Only ' . $product->stock . ' items left.'
                ], 422);
            }
            
            // Update quantity
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
            
            // Update product stock and post quantity
            $product->stock -= $quantityDifference;
            $product->save();
            
            if ($product->post) {
                $product->post->quantity -= $quantityDifference;
                $product->post->save();
            }
            
            // Refresh cart from database to get accurate data
            $cart->refresh();
            $cart->load('items.product');
            
            // Calculate total
            $this->updateCartTotal($cart);
            
            DB::commit();
            
            // For AJAX requests, return updated cart data
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully',
                    'itemPrice' => $cartItem->price,
                    'cartTotal' => $cart->total,
                    'itemsCount' => $cart->items->sum('quantity')
                ]);
            }
            
            // For non-AJAX requests, redirect to cart
            return redirect()->route('cart.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating cart: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating cart: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('cart.index')->with('error', 'Error updating cart: ' . $e->getMessage());
        }
    }

    /**
     * Remove an item from the cart.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeItem($id)
    {
        try {
            DB::beginTransaction();
            
            $cartItem = CartItem::with(['product.post', 'product'])->findOrFail($id);
            $cart = $cartItem->cart;
            
            // Ensure the cart belongs to the current user
            if ($cart->user_id !== Auth::id()) {
                return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
            }
            
            // Restore product stock and post quantity
            $product = $cartItem->product;
            if ($product) {
                // Update product stock
                $product->stock += $cartItem->quantity;
                $product->save();
                
                // Update post quantity
                if ($product->post) {
                    $product->post->quantity += $cartItem->quantity;
                    $product->post->save();
                }

                // Refresh the product to ensure we have the latest data
                $product->refresh();
            }
            
            // Delete the cart item
            $cartItem->delete();
            
            // Check if this was the last item in the cart
            $remainingItems = CartItem::where('cart_id', $cart->id)->count();
            
            if ($remainingItems === 0) {
                // If no items left, delete the cart
                $cart->delete();
                DB::commit();
                return redirect()->route('cart.index')->with('success', 'Cart is now empty!');
            }
            
            // Update cart total if there are still items
            $this->updateCartTotal($cart);
            
            DB::commit();
            
            return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error removing item from cart: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Error removing item from cart.');
        }
    }

    /**
     * Empty the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function emptyCart()
    {
        try {
            DB::beginTransaction();
            
            $cart = $this->getOrCreateCart();
            
            // Restore stock for all items
            foreach ($cart->items as $item) {
                $product = $item->product;
                if ($product) {
                    // Update product stock
                    $product->stock += $item->quantity;
                    $product->save();
                    
                    // Update post quantity
                    if ($product->post) {
                        $product->post->quantity += $item->quantity;
                        $product->post->save();
                    }

                    // Refresh the product to ensure we have the latest data
                    $product->refresh();
                }
            }
            
            // Delete all items in the cart
            CartItem::where('cart_id', $cart->id)->delete();
            
            // Delete the cart itself
            $cart->delete();
            
            DB::commit();
            
            return redirect()->route('cart.index')->with('success', 'Your cart has been emptied!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error emptying cart: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Error emptying cart.');
        }
    }

    /**
     * Get the current user's active cart or create a new one.
     *
     * @return \App\Models\Cart
     */
    private function getOrCreateCart()
    {
        try {
            DB::beginTransaction();

            // First, check for any existing active cart
            $cart = Cart::where('user_id', Auth::id())
                       ->where('status', 'active')
                       ->with(['items.product.post', 'items.product'])
                       ->first();
            
            if ($cart) {
                // Verify all items in the cart are still valid
                $hasInvalidItems = false;
                foreach ($cart->items as $item) {
                    if (!$item->product || !$item->product->post) {
                        $hasInvalidItems = true;
                        break;
                    }
                }

                // If there are invalid items or no items, clean up the cart
                if ($hasInvalidItems || $cart->items->isEmpty()) {
                    // Restore stock for any remaining valid items
                    foreach ($cart->items as $item) {
                        if ($item->product) {
                            $item->product->stock += $item->quantity;
                            $item->product->save();
                            
                            if ($item->product->post) {
                                $item->product->post->quantity += $item->quantity;
                                $item->product->post->save();
                            }
                        }
                    }

                    // Delete all cart items and the cart itself
                    CartItem::where('cart_id', $cart->id)->delete();
                    $cart->delete();
                    $cart = null;
                }
            }
            
            // Create new cart if none exists
            if (!$cart) {
                $cart = Cart::create([
                    'user_id' => Auth::id(),
                    'status' => 'active',
                    'total' => 0
                ]);
            }
            
            DB::commit();
            return $cart;
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in getOrCreateCart: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update the cart total based on its items.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    private function updateCartTotal(Cart $cart)
    {
        $total = $cart->items->sum(function($item) {
            return $item->quantity * $item->price;
        });
        
        $cart->total = $total;
        $cart->save();
    }

    /**
     * Handle missing products in the cart
     * 
     * @param \App\Models\Cart $cart
     * @return void
     */
    private function handleMissingProducts(Cart $cart)
    {
        $hasInvalidItems = false;
        
        // First pass - just identify if there are invalid items
        foreach ($cart->items as $item) {
            if (!$item->product) {
                $hasInvalidItems = true;
                break;
            }
        }
        
        // If invalid items were found, show a notification
        if ($hasInvalidItems) {
            session()->flash('warning', 'Some products in your cart are no longer available.');
        }
    }

    /**
     * Process cart checkout.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        // Get the current user's active cart
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->with(['items.product.post.user', 'items.product.user'])
            ->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add some products before checkout.');
        }
        
        // Validate that all products are available and have required relationships
        $validItems = $cart->items->filter(function($item) {
            return $item->product && 
                   $item->product->post && 
                   $item->product->user && 
                   $item->product->post->user;
        });
        
        if ($validItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Some products in your cart are no longer available. Please remove them and try again.');
        }
        
        // Calculate total price
        $totalPrice = $validItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        
        // Return the checkout view with the cart containing valid items
        return view('orders.checkout', [
            'cart' => $cart,
            'totalPrice' => $totalPrice
        ]);
    }
}