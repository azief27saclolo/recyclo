<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{
    public function index() {
        $posts = Post::latest()->paginate(10); // Fetch the latest posts with pagination

        return view('landingpage.landingpage', ['posts' => $posts]);
    }
}
