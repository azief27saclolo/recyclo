<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index() {
        $posts = Auth::user()->posts()->latest()->paginate(10);
        $orders = Auth::user()->boughtOrders()->with('post')->get();

        return view('users.dashboard', compact('posts', 'orders'));
    }

    public function userPosts(User $user) {
        
        $userPosts = $user->posts()->latest()->paginate(10);

        return view('users.posts', [
            'posts' => $userPosts,
            'user' => $user
        ]);
    }
}
