<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Shop;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Get recent posts for the landing page
        $posts = Post::with('user')->latest()->take(6)->get();
        
        // Get shops for the landing page
        $shops = Shop::with('user')->take(6)->get();
        
        return view('landingpage.landingpage', compact('posts', 'shops'));
    }
}
