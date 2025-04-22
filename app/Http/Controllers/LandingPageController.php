<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Shop;
use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{
    public function index() {
        // Fetch only approved posts with pagination and ensure we get at least 6
        $posts = Post::where('status', Post::STATUS_APPROVED)
                     ->latest()
                     ->take(6)
                     ->get();
        
        // If we don't have enough approved posts, get any posts to fill the slider
        if ($posts->count() < 6) {
            $posts = Post::latest()->take(6)->get();
        }
        
        // Fetch approved shops to display in "Shops For You" section
        $shops = Shop::where('status', 'approved')
                      ->with('user')
                      ->latest()
                      ->take(6)
                      ->get();

        return view('landingpage.landingpage', [
            'posts' => $posts,
            'shops' => $shops
        ]);
    }
}
