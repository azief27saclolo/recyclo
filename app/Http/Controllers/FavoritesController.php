<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites;
        return view('users.favorites', compact('favorites'));
    }

    public function add(Post $post)
    {
        $user = Auth::user();
        $user->favorites()->attach($post->id);

        return redirect()->back()->with('success', 'Post added to favorites!');
    }

    public function remove(Post $post)
    {
        $user = Auth::user();
        $user->favorites()->detach($post->id);

        return redirect()->back()->with('success', 'Post removed from favorites!');
    }
}
