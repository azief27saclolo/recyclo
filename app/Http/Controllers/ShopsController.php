<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopsController extends Controller
{
    /**
     * Display a listing of shops (users with posts).
     */
    public function index()
    {
        // Get all users who have posts (shops)
        $shops = User::has('posts')
            ->with(['posts' => function($query) {
                $query->latest();
            }])
            ->get();

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
            
            return view('shops.show', compact('shop', 'posts', 'latestPosts'));
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error in shop view: " . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            // Return a view with error information
            return view('shops.show', [
                'error' => $e->getMessage(),
                'shop' => isset($user) ? $user : null,
                'posts' => collect([]),
                'latestPosts' => collect([])
            ]);
        }
    }
}
