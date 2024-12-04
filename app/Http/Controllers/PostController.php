<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(6);

        return view('posts.index', [ 'posts' => $posts ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'category' => ['required'],
            'location' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
        ]);

        // Create a post
        Auth::user()->posts()->create($fields);

        // Redirect to dashboard
        return back()->with('success', 'Your post was created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [ 'post' => $post ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validate
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'category' => ['required'],
            'location' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
        ]);

        // Update a post
        $post->update($fields);

        // Redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Your post was updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Delete post
        $post->delete();

        // Redirect back to dashboard
        return back()->with('delete', 'Your post was deleted!');
    }
}
