<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Shop;
<<<<<<< Updated upstream
use Illuminate\Http\Request;
=======
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
>>>>>>> Stashed changes

class LandingPageController extends Controller
{
    public function index()
    {
        // Get recent posts for the landing page
        $posts = Post::with('user')->latest()->take(6)->get();
        
<<<<<<< Updated upstream
        // Get shops for the landing page
        $shops = Shop::with('user')->take(6)->get();
        
        return view('landingpage.landingpage', compact('posts', 'shops'));
=======
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
>>>>>>> Stashed changes
    }
}
