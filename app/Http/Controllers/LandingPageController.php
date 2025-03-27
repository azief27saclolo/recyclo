<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index() {
        $posts = Post::latest()->paginate(10); // Fetch the latest posts with pagination
        
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
    }
}
