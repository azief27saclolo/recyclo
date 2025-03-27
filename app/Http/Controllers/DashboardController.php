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
        $user = auth()->user();
        
        // Validate form inputs
        $formFields = $request->validate([
            'username' => ['required', 'min:3', Rule::unique('users', 'username')->ignore($user->id)],
            'location' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:20',  // Add validation for number field
            'password' => 'nullable|min:8',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        // Debug information to verify the request data
        \Log::info('Profile update request:', ['request_data' => $request->all()]);

        // Only update password if provided
        if ($request->filled('password')) {
            $formFields['password'] = bcrypt($formFields['password']);
        } else {
            unset($formFields['password']);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            // Store the new image in the public disk
            $formFields['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
            
            // Log successful file upload
            \Log::info('Profile picture uploaded:', ['path' => $formFields['profile_picture']]);
        }

        // Ensure location and number are included in the update
        $formFields['location'] = $request->input('location');
        $formFields['number'] = $request->input('number');
        
        // Debug the final data being saved
        \Log::info('User update data:', ['update_fields' => $formFields]);

        // Update the user
        $user->update($formFields);
        
        // Remove profile_incomplete session flag if both location and number are provided
        if (!empty($user->location) && !empty($user->number)) {
            session()->forget('profile_incomplete');
        }

        return back()->with('success', 'Profile updated successfully!');
    }
}
