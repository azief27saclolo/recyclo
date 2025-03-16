<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $user = Auth::user();
        
        // Validate the form data
        $validatedData = $request->validate([
            'username' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'nullable|string|min:8',
            'location' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        
        // Update username and location
        $user->username = $validatedData['username'];
        
        if ($request->filled('location')) {
            $user->location = $validatedData['location'];
        }
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }
        
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            // Store the new image
            $profilePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $profilePath;
        }
        
        // Save changes
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}
