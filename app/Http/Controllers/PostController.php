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
use App\Models\Category;

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
        // Get categories for the filter from the database
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        
        // Extract just the category names for the filter dropdown
        $categoryNames = $categories->pluck('name', 'id')->toArray();
        
        // Apply category filter if selected
        $category = $request->input('category');
        $query = Post::query();
        
        // Only show approved posts to regular users
        $query->where('status', Post::STATUS_APPROVED);
        
        if ($category && $category !== 'all') {
            if (is_numeric($category)) {
                // Filter by category ID if it's a number
                $query->where('category_id', $category);
            } else {
                // Filter by legacy category field for backward compatibility
                $query->where('category', $category);
            }
        }
        
        // Apply price sorting if selected
        $priceSort = $request->input('price_sort');
        
        // Reset any previous ordering to avoid conflicts
        if ($priceSort) {
            switch ($priceSort) {
                case 'low_high':
                    $query->orderByRaw('CAST(price AS DECIMAL(10,2)) ASC');
                    break;
                case 'high_low':
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

        // Create products for posts and load the relationship
        foreach ($posts as $post) {
            $product = Product::firstOrCreate(
                ['post_id' => $post->id],
                [
                    'name' => $post->title,
                    'description' => $post->description,
                    'price' => $post->price,
                    'image' => $post->image,
                    'user_id' => $post->user_id,
                    'stock' => $post->quantity
                ]
            );
        }
        $posts->load('product');

        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'categoryNames' => $categoryNames,
            'selectedCategory' => $category,
            'priceSort' => $priceSort
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get categories for the form
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'title' => ['required', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'location' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'original_price' => ['nullable', 'numeric', 'gte:price'], // Must be >= price if provided
            'description' => ['required', 'string'],
            'image' => ['required', 'file', 'max:3000', 'mimes:webp,png,jpg'],
            'unit' => ['required'],
            'quantity' => ['required', 'numeric'],
        ]);

        // Store image
        $path = Storage::disk('public')->put('posts_images', $request->image);

        // Get the category for backwards compatibility
        $category = Category::findOrFail($request->category_id);

        // Prepare post data
        $postData = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'category' => $category->name, // Keep category name for backwards compatibility
            'location' => $request->location,
            'address' => $request->address,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $path,
            'unit' => $request->unit,
            'quantity' => $request->quantity,
            'status' => Post::STATUS_PENDING, // Set as pending by default
        ];

        // Handle pricing and deals
        if ($request->filled('original_price') && $request->original_price > $request->price) {
            $originalPrice = $request->original_price;
            $currentPrice = $request->price;
            $discountPercentage = (($originalPrice - $currentPrice) / $originalPrice) * 100;

            // Add pricing fields but DON'T auto-mark as deal
            $postData['original_price'] = $originalPrice;
            $postData['discount_percentage'] = round($discountPercentage, 2);
            
            // Only mark as deal if discount is very significant (30%+) or if manually promoted later
            // Normal discounts will only become deals when they reach 3+ orders
        }

        // Create a post with pending status
        $post = Auth::user()->posts()->create($postData);

        // Note: We don't automatically calculate deal score here since it's not a deal yet
        // Deal status will be determined by:
        // 1. Auto-promotion when reaching 3+ orders
        // 2. Manual admin promotion
        // 3. Very high discounts (30%+) - uncomment below if desired
        
        // Uncomment this if you want posts with 30%+ discount to be immediate deals
        // if (isset($postData['discount_percentage']) && $postData['discount_percentage'] >= 30) {
        //     $post->update(['is_deal' => true]);
        //     $post->calculateDealScore();
        // }

        // Success message based on whether pricing info was provided
        $message = 'Your post has been submitted and is awaiting admin approval!';
        if (isset($postData['original_price']) && isset($postData['discount_percentage'])) {
            $discountPercentage = $postData['discount_percentage'];
            $message = '✨ Your post with ' . round($discountPercentage, 0) . '% discount has been submitted! ' .
                      'It will become a featured deal once it gets popular (3+ orders) or when promoted by admin.';
        }

        return back()->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Increment views count for deals tracking
        $post->incrementViews();
        
        // Add product relation to ensure posts can be added to cart
        $product = Product::firstOrCreate(
            ['post_id' => $post->id],
            [
                'name' => $post->title,
                'description' => $post->description,
                'price' => $post->price,
                'image' => $post->image,
                'user_id' => $post->user_id,
                'stock' => $post->quantity // Use post quantity as stock
            ]
        );
        
        // Load the product relationship
        $post->load('product');
        
        // Get related posts or recent posts to display in the view
        $posts = Post::where('id', '!=', $post->id)
                    ->where(function($query) use ($post) {
                        $query->where('category_id', $post->category_id)
                              ->orWhere('category', $post->category);
                    })
                    ->latest()
                    ->take(5)
                    ->get();
        
        // If we couldn't find enough related posts, fill with recent posts
        if ($posts->count() < 5) {
            $additionalPosts = Post::where('id', '!=', $post->id)
                                ->where(function($query) use ($post) {
                                    $query->where('category_id', '!=', $post->category_id)
                                          ->where('category', '!=', $post->category);
                                })
                                ->latest()
                                ->take(5 - $posts->count())
                                ->get();
            $posts = $posts->merge($additionalPosts);
        }
        
        return view('posts.show', [
            'post' => $post,
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
            'category_id' => ['required', 'exists:categories,id'],
            'location' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
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

        // Get the category for backwards compatibility
        $category = Category::findOrFail($request->category_id);

        // Prepare update data
        $updateData = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'category' => $category->name, // Keep category name for backwards compatibility
            'location' => $request->location,
            'address' => $request->address,
            'price' => $request->price,
            'description' => $request->description,
            'unit' => $request->unit,
            'quantity' => $request->quantity,
        ];

        // Update image only if a new one is provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            
            // Store new image
            $updateData['image'] = Storage::disk('public')->put('posts_images', $request->image);
        }

        // Update the post
        $post->update($updateData);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post updated successfully!');
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
