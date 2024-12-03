<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {
        $posts = Auth::user()->posts()->latest()->paginate(5);

        return view('users.dashboard', ['posts' => $posts]);
    }

    public function userPosts(User $user) {
        
        $userPosts = $user->posts()->latest()->paginate(5);

        return view('users.posts', [
            'posts' => $userPosts,
            'user' => $user
        ]);
    }
}
