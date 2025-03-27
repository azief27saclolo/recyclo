<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(6);

        return view('posts.index', [ 'posts' => $posts ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'category' => ['required'],
            'location' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
        ]);

        // Create a post
        Auth::user()->posts()->create($fields);

        // Redirect to dashboard
        return back()->with('success', 'Your post was created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [ 'post' => $post ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validate
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'category' => ['required'],
            'location' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
        ]);

        // Update a post
        $post->update($fields);

        // Redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Your post was updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Delete post
        $post->delete();

        // Redirect back to dashboard
        return back()->with('delete', 'Your post was deleted!');
    }
<<<<<<< Updated upstream
=======

    /**
     * Search for posts and buy requests.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search for posts
        $posts = Post::where('title', 'LIKE', "%{$query}%")
                     ->orWhere('description', 'LIKE', "%{$query}%")
                     ->paginate(10);

        // Search for buy requests
        $buyRequests = Buy::where('category', 'LIKE', "%{$query}%")
                          ->orWhere('description', 'LIKE', "%{$query}%")
                          ->paginate(10);

        return view('posts.search', [
            'posts' => $posts,
            'buyRequests' => $buyRequests,
            'query' => $query
        ]);
    }

    /**
     * Get all products for the authenticated user
     */
    public function getUserProducts()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
            }
            
            $products = $user->posts()->latest()->get();
            
            // Ensure quantity is numeric for all products
            $products->map(function ($product) {
                $product->quantity = (int) $product->quantity;
                $product->price = (float) $product->price;
                return $product;
            });
            
            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching user products: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Server error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the stock of a post.
     */
    public function updateStock(Request $request, Post $post)
    {
        try {
            // Capture old value for history
            $oldQuantity = $post->quantity;
            
            $post->quantity = $request->input('quantity');
            $post->save();

            // Log the stock change to history
            \App\Http\Controllers\InventoryHistoryController::logHistory(
                $post->id,
                'update',
                'quantity',
                $oldQuantity,
                $post->quantity,
                'Stock updated manually'
            );

            // Calculate the total inventory for the user
            $totalInventory = Post::where('user_id', Auth::id())->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Stock updated successfully!',
                'total_inventory' => $totalInventory
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock. Please try again.'
            ], 500);
        }
    }

    /**
     * Update the price of a post.
     */
    public function updatePrice(Request $request, Post $post)
    {
        try {
            // Validate the price
            $request->validate([
                'price' => 'required|numeric|min:0'
            ]);

            // Capture old value for history
            $oldPrice = $post->price;
            
            $post->price = $request->input('price');
            $post->save();

            // Log the price change to history
            \App\Http\Controllers\InventoryHistoryController::logHistory(
                $post->id,
                'update',
                'price',
                $oldPrice,
                $post->price,
                'Price updated manually'
            );

            // Also update the related product if it exists
            $product = Product::where('post_id', $post->id)->first();
            if ($product) {
                $product->price = $request->input('price');
                $product->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Price updated successfully!',
                'new_price' => number_format($post->price, 2)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update price. Please try again.'
            ], 500);
        }
    }

    /**
     * Batch update multiple posts.
     */
    public function batchUpdate(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'products' => 'required|array',
                'products.*.id' => 'required|numeric|exists:posts,id',
                'action' => 'required|string|in:stock,price,category',
                'value' => 'required',
            ]);

            $products = $request->input('products');
            $action = $request->input('action');
            $value = $request->input('value');
            $user = Auth::user();
            $updatedCount = 0;

            // Log the incoming request for debugging
            \Log::info('Batch update request:', [
                'action' => $action,
                'value' => $value,
                'products_count' => count($products),
                'products' => $products
            ]);

            // Process each product
            foreach ($products as $productData) {
                $post = Post::find($productData['id']);
                
                // Check if user owns this post
                if ($post && $post->user_id === $user->id) {
                    $oldValue = null;
                    $fieldName = '';

                    switch ($action) {
                        case 'stock':
                            $oldValue = $post->quantity;
                            $fieldName = 'quantity';
                            $post->quantity = (int)$value;
                            break;
                        case 'price':
                            $oldValue = $post->price;
                            $fieldName = 'price';
                            $post->price = (float)$value;
                            // Update related product if it exists
                            $product = Product::where('post_id', $post->id)->first();
                            if ($product) {
                                $product->price = (float)$value;
                                $product->save();
                            }
                            break;
                        case 'category':
                            $oldValue = $post->category;
                            $fieldName = 'category';
                            $post->category = $value;
                            break;
                    }

                    $post->save();
                    $updatedCount++;

                    // Log to history
                    \App\Http\Controllers\InventoryHistoryController::logHistory(
                        $post->id,
                        'update',
                        $fieldName,
                        $oldValue,
                        $action === 'stock' ? (int)$value : ($action === 'price' ? (float)$value : $value),
                        'Batch updated'
                    );

                    \Log::info('Updated post:', [
                        'post_id' => $post->id,
                        'title' => $post->title,
                        'new_value' => $action === 'stock' ? $post->quantity : 
                                      ($action === 'price' ? $post->price : $post->category)
                    ]);
                }
            }

            // Get updated total inventory if stock was updated
            $totalInventory = null;
            if ($action === 'stock') {
                $totalInventory = Post::where('user_id', Auth::id())->sum('quantity');
            }

            return response()->json([
                'success' => true,
                'message' => $updatedCount . ' product(s) updated successfully',
                'total_inventory' => $totalInventory,
                'action' => $action
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in batch update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Server error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }
>>>>>>> Stashed changes
}
