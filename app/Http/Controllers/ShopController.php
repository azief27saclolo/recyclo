<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use App\Models\Product;

class ShopController extends Controller
{
    /**
     * Show the shop registration form
     */
    public function create()
    {
        // Check if the user already has an application
        $application = Shop::where('user_id', Auth::id())->first();
        $user = Auth::user();
        return view('shops.register', compact('application', 'user'));
    }

    /**
     * Store the shop registration
     */
    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'required|string',
            'valid_id' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Upload files
        $validIdPath = $request->file('valid_id')->store('shop_documents', 'public');

        // Create shop application
        Shop::create([
            'user_id' => Auth::id(),
            'shop_name' => $request->shop_name,
            'shop_address' => $request->shop_address,
            'valid_id_path' => $validIdPath,
            'status' => 'pending'
        ]);

        return redirect()->route('shop.register')->with('success', 'Your shop application has been submitted successfully.');
    }

    /**
     * Dashboard for approved sellers
     */
    public function dashboard()
    {
        // Check if the user has an approved shop
        $shop = Shop::where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->first();
        
        if (!$shop) {
            return redirect()->route('shop.register')
                ->with('error', 'You need an approved shop to access this page.');
        }

        // Get all categories for the inventory filter
        $categories = \App\Models\Category::all();
        
        return view('shops.dashboard', compact('shop', 'categories'));
    }

    /**
     * Update shop details
     */
    public function update(Request $request)
    {
        try {
        $shop = Shop::where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->firstOrFail();
        
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'required|string',
                'shop_description' => 'nullable|string',
                'contact_number' => 'nullable|string|max:20',
                'business_hours' => 'nullable|string|max:100',
            'shop_image' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);
        
        // Update shop details
        $shop->shop_name = $request->shop_name;
        $shop->shop_address = $request->shop_address;
            $shop->shop_description = $request->shop_description;
            $shop->contact_number = $request->contact_number;
            $shop->business_hours = $request->business_hours;
        
        // Update shop image if provided
        if ($request->hasFile('shop_image')) {
            // Delete old image if exists
            if ($shop->image) {
                Storage::disk('public')->delete($shop->image);
            }
            
            // Upload new image
            $imagePath = $request->file('shop_image')->store('shop_images', 'public');
            $shop->image = $imagePath;
        }
        
        $shop->save();
        
            return response()->json([
                'success' => true,
                'message' => 'Shop settings updated successfully!',
                'shop' => $shop
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating shop settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update shop settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get paginated orders for the shop
     */
    public function getOrders(Request $request)
    {
        $itemsPerPage = 5; // Set to show 5 items per page
        $status = $request->input('status', 'all');
        $search = $request->input('search', '');
        
        $query = Order::where('seller_id', Auth::id())
                     ->where('status', '!=', 'pending') // Exclude pending orders
                     ->with(['user', 'post']);
        
        // Apply status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        // Apply search filter (search in order ID, customer name, or product title)
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('username', 'LIKE', "%{$search}%")
                                ->orWhere('firstname', 'LIKE', "%{$search}%")
                                ->orWhere('lastname', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('post', function($postQuery) use ($search) {
                      $postQuery->where('title', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        $orders = $query->latest()->paginate($itemsPerPage);
        
        // Format the data for easier consumption by the frontend
        $formattedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'customer_name' => $order->user ? 
                    ($order->user->username ?: ($order->user->firstname . ' ' . $order->user->lastname)) : 
                    'Customer',
                'created_at' => $order->created_at,
                'product_title' => $order->post->title ?? 'Product',
                'quantity' => $order->quantity,
                'unit' => $order->post->unit ?? 'units',
                'total_amount' => $order->total_amount ?? ($order->quantity * ($order->post->price ?? 0)),
                'status' => $order->status ?? 'pending'
            ];
        });
        
        return response()->json([
            'data' => $formattedOrders,
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage(),
            'per_page' => $orders->perPage(),
            'total' => $orders->total()
        ]);
    }
    
    /**
     * Get details for a specific order
     */
    public function getOrderDetails(Order $order)
    {
        // Ensure the order belongs to the authenticated seller
        if ($order->seller_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Get user details
        $user = $order->user;
        $userName = $user ? ($user->username ?: ($user->firstname . ' ' . $user->lastname)) : 'Customer';
        $userAddress = $user ? $user->location : null;
        $userContact = $user ? $user->number : null;
        
        // Get post details
        $post = $order->post;
        $productTitle = $post ? $post->title : 'Product';
        $productUnit = $post ? $post->unit : 'units';
        
        return response()->json([
            'id' => $order->id,
            'customer_name' => $userName,
            'address' => $userAddress,
            'contact' => $userContact,
            'created_at' => $order->created_at,
            'product_title' => $productTitle,
            'quantity' => $order->quantity,
            'unit' => $productUnit,
            'total_amount' => $order->total_amount,
            'status' => $order->status
        ]);
    }

    /**
     * Get inventory data with pagination and filters
     */
    public function getInventory(Request $request)
    {
        try {
            $query = \App\Models\Post::where('user_id', Auth::id())
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.*', 'categories.name as category_name');

            // Apply search filter
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('posts.title', 'like', "%{$search}%")
                      ->orWhere('posts.description', 'like', "%{$search}%");
                });
            }

            // Apply category filter
            if ($request->has('category') && $request->category) {
                $query->where('posts.category_id', $request->category);
            }

            // Apply stock level filter
            if ($request->has('stock')) {
                switch ($request->stock) {
                    case 'low-stock':
                        $query->where('posts.quantity', '<', 10)->where('posts.quantity', '>', 0);
                        break;
                    case 'out-of-stock':
                        $query->where('posts.quantity', '<=', 0);
                        break;
                    case 'in-stock':
                        $query->where('posts.quantity', '>=', 10);
                        break;
                }
            }

            // Get paginated results
            $perPage = 10;
            $products = $query->paginate($perPage);

            // Transform the products to include category name
            $transformedProducts = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'category_id' => $product->category_id,
                    'category_name' => $product->category_name,
                    'location' => $product->location,
                    'unit' => $product->unit,
                    'quantity' => $product->quantity,
                    'price' => $product->price,
                    'description' => $product->description
                ];
            });

            // Calculate inventory statistics
            $stats = [
                'total_value' => number_format($query->sum(DB::raw('posts.price * posts.quantity')), 2),
                'low_stock' => $query->where('posts.quantity', '<', 10)->where('posts.quantity', '>', 0)->count(),
                'out_of_stock' => $query->where('posts.quantity', '<=', 0)->count()
            ];

            return response()->json([
                'success' => true,
                'products' => $transformedProducts,
                'total_pages' => $products->lastPage(),
                'current_page' => $products->currentPage(),
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching inventory: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load inventory data.'
            ], 500);
        }
    }

    public function getProducts(Request $request)
    {
        try {
            $query = Post::where('user_id', auth()->id())
                        ->with(['category', 'user'])
                        ->orderBy('created_at', 'desc');

            // Apply category filter
            if ($request->has('category') && $request->category !== 'all') {
                $query->where(function($q) use ($request) {
                    $q->where('category_id', $request->category)
                      ->orWhere('category', $request->category);
                });
            }

            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Get paginated results
            $products = $query->paginate(10);

            // Transform the data to include category color and name
            $products->getCollection()->transform(function ($product) {
                // Handle both relationship and string category
                $categoryName = is_object($product->category) ? $product->category->name : $product->category;
                $categoryColor = is_object($product->category) ? $product->category->color : '#6B7280';

                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'image' => $product->image,
                    'category_name' => $categoryName,
                    'category_color' => $categoryColor,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'unit' => $product->unit,
                    'status' => $product->status,
                    'created_at' => $product->created_at->format('Y-m-d H:i:s')
                ];
            });

            return response()->json([
                'products' => $products->items(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getProducts: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load products',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getProduct($id)
    {
        try {
            $product = Post::where('user_id', auth()->id())
                          ->with('category')
                          ->findOrFail($id);
            
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load product',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Post::where('user_id', auth()->id())->findOrFail($id);
            
            $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'location' => 'required|string|max:255',
                'unit' => 'required|string|in:kg,g,pcs,box,sack',
                'quantity' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
            ]);

            // Update product details
            $product->title = $request->title;
            $product->category_id = $request->category_id;
            $product->location = $request->location;
            $product->unit = $request->unit;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->description = $request->description;

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                
                // Upload new image
                $imagePath = $request->file('image')->store('product_images', 'public');
                $product->image = $imagePath;
            }

            $product->save();

            // For AJAX requests, return JSON response
            if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully'
            ]);
            }

            // For regular form submissions, redirect back with success message
            return redirect()->route('shop.dashboard')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            // For AJAX requests, return JSON error
            if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product: ' . $e->getMessage()
            ], 500);
            }

            // For regular form submissions, redirect back with error message
            return redirect()->route('shop.dashboard')
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $shop = User::with(['posts' => function($query) {
            $query->where('status', Post::STATUS_APPROVED)
                  ->latest();
        }])->findOrFail($id);

        // Create products for posts and load the relationship
        foreach ($shop->posts as $post) {
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
        $shop->posts->load('product');

        return view('shops.show', compact('shop'));
    }

    /**
     * Get earnings chart data for the authenticated shop
     */
    public function getEarningsChart(Request $request)
    {
        try {
            $period = $request->input('period', '30d');
            $userId = Auth::id();
            
            \Log::info("Getting earnings chart for user: {$userId}, period: {$period}");
            
            // Calculate date range based on period
            $startDate = match($period) {
                '7d' => now()->subDays(7),
                '30d' => now()->subDays(30),
                '90d' => now()->subDays(90),
                '1y' => now()->subYear(),
                default => now()->subDays(30)
            };

            \Log::info("Date range: {$startDate} to " . now());

            // Get orders data with proper date formatting
            $orders = Order::where('seller_id', $userId)
                ->where('status', 'completed')
                ->where('created_at', '>=', $startDate)
                ->selectRaw('DATE(created_at) as date, SUM(total_amount) as daily_total, COUNT(*) as order_count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            \Log::info("Found {$orders->count()} order records");

            // If no real orders exist, generate some sample data for testing
            if ($orders->isEmpty()) {
                \Log::info("No orders found, generating sample data");
                return $this->generateSampleEarningsData($period, $startDate);
            }

            // Generate all dates in the range
            $dateRange = [];
            $current = $startDate->copy();
            while ($current <= now()) {
                $dateRange[] = $current->format('Y-m-d');
                $current->addDay();
            }

            // Format data for chart
            $chartData = [];
            foreach ($dateRange as $date) {
                $orderData = $orders->firstWhere('date', $date);
                $totalEarnings = $orderData ? $orderData->daily_total : 0;
                $commission = $totalEarnings * 0.1; // 10% commission
                $netEarnings = $totalEarnings - $commission;

                $chartData[] = [
                    'date' => $date,
                    'totalEarnings' => (float) $totalEarnings,
                    'netEarnings' => (float) $netEarnings,
                    'commission' => (float) $commission,
                    'orderCount' => $orderData ? $orderData->order_count : 0
                ];
            }

            $summary = [
                'totalEarnings' => (float) $orders->sum('daily_total'),
                'netEarnings' => (float) ($orders->sum('daily_total') * 0.9),
                'commission' => (float) ($orders->sum('daily_total') * 0.1),
                'totalOrders' => (int) $orders->sum('order_count')
            ];

            \Log::info("Returning chart data with " . count($chartData) . " data points");

            return response()->json([
                'success' => true,
                'data' => $chartData,
                'period' => $period,
                'summary' => $summary,
                'hasRealData' => true
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching earnings chart data: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load earnings data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate sample earnings data for testing when no real orders exist
     */
    private function generateSampleEarningsData($period, $startDate)
    {
        \Log::info("Generating sample earnings data for period: {$period}");
        
        $days = match($period) {
            '7d' => 7,
            '30d' => 30,
            '90d' => 90,
            '1y' => 365,
            default => 30
        };

        $chartData = [];
        $totalSampleEarnings = 0;
        $totalSampleOrders = 0;

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            
            // Generate realistic sample data
            $baseEarning = 200; // Base earning per day
            $variance = rand(-100, 300); // Random variance
            $totalEarnings = max(0, $baseEarning + $variance);
            
            $commission = $totalEarnings * 0.1;
            $netEarnings = $totalEarnings - $commission;
            $orderCount = $totalEarnings > 0 ? rand(1, 5) : 0;
            
            $chartData[] = [
                'date' => $date->format('Y-m-d'),
                'totalEarnings' => (float) $totalEarnings,
                'netEarnings' => (float) $netEarnings,
                'commission' => (float) $commission,
                'orderCount' => $orderCount
            ];

            $totalSampleEarnings += $totalEarnings;
            $totalSampleOrders += $orderCount;
        }

        $summary = [
            'totalEarnings' => (float) $totalSampleEarnings,
            'netEarnings' => (float) ($totalSampleEarnings * 0.9),
            'commission' => (float) ($totalSampleEarnings * 0.1),
            'totalOrders' => $totalSampleOrders
        ];

        \Log::info("Generated sample data with total earnings: {$totalSampleEarnings}");

        return response()->json([
            'success' => true,
            'data' => $chartData,
            'period' => $period,
            'summary' => $summary,
            'hasRealData' => false,
            'message' => 'Sample data generated for demonstration (no completed orders found)'
        ]);
    }
}
