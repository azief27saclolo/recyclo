<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{
    public function index() {
        $posts = Auth::user()->posts()->latest();

        return view('landingpage.landingpage', ['posts' => $posts]);
    }
}
