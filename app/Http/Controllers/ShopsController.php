<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopsController extends Controller
{
    /**
     * Display a listing of approved shops.
     */
    public function index()
    {
        // First, let's get all approved shops
        $approvedShops = Shop::where('status', 'approved')->get();
        Log::info('Approved shops found:', ['count' => $approvedShops->count()]);

        // Get all users who have approved shops
        $shops = User::whereHas('shop', function($query) {
                $query->where('status', 'approved');
            })
            ->with(['posts' => function($query) {
                $query->latest();
            }, 'shop'])
            ->get();

        Log::info('Users with approved shops found:', [
            'count' => $shops->count(),
            'shops' => $shops->map(function($shop) {
                return [
                    'user_id' => $shop->id,
                    'username' => $shop->username,
                    'shop_name' => $shop->shop ? $shop->shop->shop_name : 'N/A',
                    'posts_count' => $shop->posts->count()
                ];
            })->toArray()
        ]);

        return view('shops.index', compact('shops'));
    }

    /**
     * Display the specified shop.
     */
    public function show(User $user)
    {
        try {
            // Get the shop (user)
            $shop = $user;
            
            // Check if the shop is approved
            $approvedShop = Shop::where('user_id', $shop->id)
                              ->where('status', 'approved')
                              ->first();
            
            if (!$approvedShop) {
                return redirect()->route('shops')->with('error', 'This shop is not available.');
            }
            
            // Log for debugging
            Log::info("Loading shop view for user ID: {$shop->id}, username: {$shop->username}");
            
            // Get shop's posts (products)
            $posts = $shop->posts()->latest()->get();
            Log::info("Found {$posts->count()} posts for shop");
            
            // Get latest 6 posts for "New Arrivals" section
            $latestPosts = $shop->posts()->latest()->take(6)->get();
            
            // Log view data
            Log::info("Rendering view with shop data: " . json_encode([
                'shop_id' => $shop->id,
                'shop_username' => $shop->username,
                'posts_count' => $posts->count(),
                'latestPosts_count' => $latestPosts->count(),
            ]));
            
            return view('shops.show', compact('user', 'posts', 'latestPosts', 'approvedShop'));
        
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error in shop view: " . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            // Return a view with error information
            return view('shops.show', [
                'error' => $e->getMessage(),
                'user' => isset($user) ? $user : null,
                'posts' => collect([]),
                'latestPosts' => collect([])
            ]);
        }
    }
}
