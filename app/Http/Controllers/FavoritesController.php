<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        // Eager load the user relationship
        $favorites = Auth::user()->favorites()->with('user')->get();
        return view('users.favorites', compact('favorites'));
    }

    public function add(Post $post)
    {
        $user = Auth::user();
        $user->favorites()->attach($post->id);

        return redirect()->back()->with(['success' => 'Item added to favorites!', 'type' => 'success']);
    }

    public function remove(Post $post)
    {
        $user = Auth::user();
        $user->favorites()->detach($post->id);

        return redirect()->back()->with(['success' => 'Item removed from favorites!', 'type' => 'error']);
    }
}
