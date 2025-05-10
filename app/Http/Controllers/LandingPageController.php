<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    public function index()
    {
        try {
            // Get recent posts for the landing page
            $posts = Post::with('user')->latest()->take(6)->get();
            
            // Fetch approved shops to display in "Shops For You" section
            $shops = Shop::where('status', 'approved')
                      ->with('user')
                      ->latest()
                      ->take(6)
                      ->get();
            
            // Check profile completion status for authenticated users
            if (Auth::check()) {
                $user = Auth::user();
                
                // Check if user has completed their profile
                if (empty($user->location) || empty($user->number)) {
                    session(['profile_incomplete' => true]);
                }
            }
            
            return view('landingpage.landingpage', [
                'posts' => $posts,
                'shops' => $shops
            ]);
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Landing page error: ' . $e->getMessage());
            
            // Return the view with empty collections to avoid breaking the page
            return view('landingpage.landingpage', [
                'posts' => collect([]),
                'shops' => collect([])
            ]);
        }
    }
}
