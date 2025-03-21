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
                return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
            }
            
            // Update quantity
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            
            // Refresh cart from database to get accurate data
            $cart->refresh();
            $cart->load('items');
            
            // Calculate total
            $total = 0;
            foreach($cart->items as $item) {
                $total += $item->quantity * $item->price;
            }
            
            $cart->total = $total;
            $cart->save();
            
            // Return to cart without success message
            return redirect()->route('cart.index');
        } catch (\Exception $e) {
            \Log::error('Error updating cart: ' . $e->getMessage());
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
}