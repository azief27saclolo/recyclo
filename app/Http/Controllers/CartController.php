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
        } else {
            // Add new item to cart
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
        }
        
        $this->updateCartTotal($cart);
        
        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
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
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cartItem = CartItem::findOrFail($id);
        $cart = $cartItem->cart;
        
        // Ensure the cart belongs to the current user
        if ($cart->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
        }
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        $this->updateCartTotal($cart);
        
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
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