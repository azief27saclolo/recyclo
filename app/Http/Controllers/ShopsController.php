<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ShopsController extends Controller
{
    /**
     * Display a listing of shops (users with posts).
     */
    public function index()
    {
        // Get all users who have posts (shops)
        $shops = User::has('posts')
            ->with(['posts' => function($query) {
                $query->latest();
            }])
            ->get();

        return view('shops.index', compact('shops'));
    }
}
