<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'verified'], except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);

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
        $request->validate([
            'title' => ['required', 'max:255'],
            'category' => ['required'],
            'location' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'image' => ['required', 'file', 'max:3000', 'mimes:webp,png,jpg'],
        ]);

        // Store image
        $path = Storage::disk('public')->put('posts_images', $request->image);

        // Create a post
        $post = Auth::user()->posts()->create([
            'title' => $request->title,
            'category' => $request->category,
            'location' => $request->location,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $path
        ]);

        // Send email
        // Mail::to(Auth::user())->send(new WelcomeMail(Auth::user(), $post));

        // Redirect to dashboard
        return back()->with('success', 'Your post was created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $posts = Post::latest()->paginate(10); // Fetch the latest posts with pagination
        return view('posts.show', ['post' => $post, 'posts' => $posts]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('modify', $post);

        return view('posts.edit', [ 'post' => $post ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Aurhorizing the action
        Gate::authorize('modify', $post);

        // Validate
        $request->validate([
            'title' => ['required', 'max:255'],
            'category' => ['required'],
            'location' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'image' => ['required', 'file', 'max:3000', 'mimes:webp,png,jpg'],
        ]);

        // Update image
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $path = Storage::disk('public')->put('posts_images', $request->image);

        // Update a post
        $post->update([
            'title' => $request->title,
            'category' => $request->category,
            'location' => $request->location,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $path
        ]);

        // Redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Your post was updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Aurhorizing the action
        Gate::authorize('modify', $post);

        // Delete post image
        Storage::disk('public')->delete($post->image);

        // Delete post
        $post->delete();

        // Redirect back to dashboard
        return back()->with('delete', 'Your post was deleted!');
    }
}
