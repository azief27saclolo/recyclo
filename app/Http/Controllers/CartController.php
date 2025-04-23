<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        // Load cart items with product details
        $cart->load('items.product');
        
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

        $product = Product::findOrFail($request->product_id);
        $cart = $this->getOrCreateCart();
        
        // Check if product already exists in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $product->id)
                            ->first();
        
        if ($cartItem) {
            // Update quantity if product already exists
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
            $message = "{$product->name} quantity updated in your cart!";
        } else {
            // Add new item to cart
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
            $message = "{$product->name} added to your cart!";
        }
        
        $this->updateCartTotal($cart);
        
        // Check if the request wants JSON response (for AJAX)
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        
        // Otherwise, redirect back with a flash message
        return back()->with('success', $message);
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
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);
            
            $cartItem = CartItem::findOrFail($id);
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
            
            // Update quantity
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            
            // Refresh cart from database to get accurate data
            $cart->refresh();
            $cart->load('items.product');
            
            // Calculate total
            $this->updateCartTotal($cart);
            
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
        $cartItem = CartItem::findOrFail($id);
        $cart = $cartItem->cart;
        
        // Ensure the cart belongs to the current user
        if ($cart->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
        }
        
        $cartItem->delete();
        $this->updateCartTotal($cart);
        
        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    /**
     * Empty the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function emptyCart()
    {
        $cart = $this->getOrCreateCart();
        
        // Delete all items in the cart
        CartItem::where('cart_id', $cart->id)->delete();
        
        // Reset cart total
        $cart->total = 0;
        $cart->save();
        
        return redirect()->route('cart.index')->with('success', 'Your cart has been emptied!');
    }

    /**
     * Get the current user's active cart or create a new one.
     *
     * @return \App\Models\Cart
     */
    private function getOrCreateCart()
    {
        $cart = Cart::where('user_id', Auth::id())
                   ->where('status', 'active')
                   ->first();
        
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'status' => 'active',
                'total' => 0
            ]);
        }
        
        return $cart;
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
        $cart = $this->getOrCreateCart();
        
        // Load cart items with ALL necessary related data to avoid null references
        $cart->load('items.product.post.user');
        
        // Check if cart has items
        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add some products before checkout.');
        }
        
        // Check for and filter out missing or invalid products
        $validItems = $cart->items->filter(function($item) {
            return $item->product && $item->product->post && $item->product->post->user;
        });
        
        if ($validItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart contains only unavailable products. Please remove them and add valid products before checkout.');
        }
        
        // Check if any invalid items were filtered out
        if ($validItems->count() < $cart->items->count()) {
            session()->flash('warning', 'Some products in your cart are no longer available and have been excluded from checkout.');
        }
        
        // Return the checkout view with the cart containing all items (including invalid ones for display purposes)
        // The blade template will filter them out when needed
        return view('orders.checkout', [
            'cart' => $cart,
            'totalPrice' => $validItems->sum(function($item) {
                return $item->quantity * $item->price;
            })
        ]);
    }
}