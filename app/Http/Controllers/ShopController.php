<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        
        return view('shops.dashboard', compact('shop'));
    }

    /**
     * Update shop details
     */
    public function update(Request $request)
    {
        $shop = Shop::where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->firstOrFail();
        
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'required|string',
            'shop_image' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);
        
        // Update shop details
        $shop->shop_name = $request->shop_name;
        $shop->shop_address = $request->shop_address;
        
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
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Shop settings updated successfully!'
            ]);
        }
        
        return redirect()->route('shop.dashboard')->with('success', 'Shop settings updated successfully!');
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
}
