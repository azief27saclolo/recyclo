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

    public function profile()
    {
        return view('users.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'profile_picture' => ['nullable', 'image', 'max:2048'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->username = $request->username;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->location = $request->location;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}
