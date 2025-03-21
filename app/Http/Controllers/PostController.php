<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Models\User;
use App\Models\Buy;
use App\Models\Product;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth'], except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get unique categories for the filter
        $categories = Post::select('category')->distinct()->pluck('category')->toArray();
        
        // Apply category filter if selected
        $category = $request->input('category');
        $query = Post::query();
        
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }
        
        // Apply price sorting if selected
        $priceSort = $request->input('price_sort');
        
        // Reset any previous ordering to avoid conflicts
        if ($priceSort) {
            switch ($priceSort) {
                case 'low_high':
                    // Force numeric ordering to ensure correct results
                    $query->orderByRaw('CAST(price AS DECIMAL(10,2)) ASC');
                    break;
                case 'high_low':
                    // Force numeric ordering to ensure correct results
                    $query->orderByRaw('CAST(price AS DECIMAL(10,2)) DESC');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest(); // Default sorting by latest
        }
        
        $posts = $query->paginate(20)->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'selectedCategory' => $category,
            'priceSort' => $priceSort
        ]);
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
        $request->validate([
            'title' => ['required', 'max:255'],
            'category' => ['required'],
            'location' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'image' => ['required', 'file', 'max:3000', 'mimes:webp,png,jpg'],
            'unit' => ['required'],
            'quantity' => ['required', 'numeric'],
        ]);

        // Store image
        $path = Storage::disk('public')->put('posts_images', $request->image);

        // Create a post
        $post = Auth::user()->posts()->create([
            'title' => $request->title,
            'category' => $request->category,
            'location' => $request->location,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $path,
            'unit' => $request->unit,
            'quantity' => $request->quantity,
        ]);

        // Send email
        // Mail::to(Auth::user())->send(new WelcomeMail(Auth::user(), $post));

        // Redirect to dashboard
        return back()->with('success', 'Your post was created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Add product relation to ensure posts can be added to cart
        $product = Product::firstOrCreate(
            ['post_id' => $post->id],
            [
                'name' => $post->title,
                'description' => $post->description,
                'price' => $post->price,
                'image' => $post->image,
                'user_id' => $post->user_id,
                'stock' => 1 // Default stock
            ]
        );
        
        // Get related posts or recent posts to display in the view
        $posts = Post::where('id', '!=', $post->id)
                    ->where('category', $post->category)
                    ->latest()
                    ->take(5)
                    ->get();
        
        // If we couldn't find enough related posts, fill with recent posts
        if ($posts->count() < 5) {
            $additionalPosts = Post::where('id', '!=', $post->id)
                                ->where('category', '!=', $post->category)
                                ->latest()
                                ->take(5 - $posts->count())
                                ->get();
            $posts = $posts->merge($additionalPosts);
        }
        
        return view('posts.show', [
            'post' => $post,
            'product_id' => $product->id,
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('modify', $post);
        
        // Explicitly prevent redirection to email verification
        if (Auth::check()) {
            return view('posts.edit', [ 'post' => $post ]);
        }
        
        return redirect()->route('login');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Authorizing the action
        Gate::authorize('modify', $post);

        // Validate with image as optional
        $validationRules = [
            'title' => ['required', 'max:255'],
            'category' => ['required'],
            'location' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'unit' => ['required'],
            'quantity' => ['required', 'numeric'],
        ];

        // Only validate image if one is provided
        if ($request->hasFile('image')) {
            $validationRules['image'] = ['file', 'max:3000', 'mimes:webp,png,jpg'];
        }

        $request->validate($validationRules);

        // Prepare update data
        $updateData = [
            'title' => $request->title,
            'category' => $request->category,
            'location' => $request->location,
            'price' => $request->price,
            'description' => $request->description,
            'unit' => $request->unit,
            'quantity' => $request->quantity,
        ];

        // Update image only if a new one is provided
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            
            // Store new image
            $path = Storage::disk('public')->put('posts_images', $request->image);
            $updateData['image'] = $path;
        }

        // Update the post with the new data
        $post->update($updateData);

        // Check referrer and redirect accordingly
        $referer = $request->headers->get('referer');
        
        if (strpos($referer, 'shop/dashboard') !== false) {
            // If editing from shop dashboard, redirect back there
            return redirect()->route('shop.dashboard')->with('success', 'Your product was updated!');
        }
        
        // Default redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Your post was updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Aurhorizing the action
        Gate::authorize('modify', $post);

        // Delete post image
        Storage::disk('public')->delete($post->image);

        // Delete post
        $post->delete();

        // Redirect back to dashboard
        return back()->with('delete', 'Your post was deleted!');
    }

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
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            $products = $user->posts()->latest()->get();
            
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
}
