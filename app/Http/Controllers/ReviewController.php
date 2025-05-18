<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:500'
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your review has been submitted successfully.',
            'review' => $review->load('user')
        ]);
    }

    public function index(Post $post)
    {
        $reviews = $post->reviews()
            ->with('user')
            ->latest()
            ->get();

        return response()->json($reviews);
    }
}
