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
    /**
     * Show user dashboard with their posts and status information
     */
    public function index()
    {
        $user = auth()->user();
        
        // Group posts by status for cleaner display
        $posts = $user->posts()->latest()->get();
        
        $postsByStatus = [
            'pending' => $posts->where('status', 'pending'),
            'approved' => $posts->where('status', 'approved'),
            'rejected' => $posts->where('status', 'rejected'),
        ];
        
        // Get counts for dashboard stats
        $pendingCount = $postsByStatus['pending']->count();
        $approvedCount = $postsByStatus['approved']->count();
        $rejectedCount = $postsByStatus['rejected']->count();
        
        return view('dashboard', compact(
            'user', 
            'posts', 
            'postsByStatus',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
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
        
        $formFields = $request->validate([
            'username' => ['required', 'min:3', Rule::unique('users', 'username')->ignore($user->id)],
            'location' => 'nullable|string',
            'number' => 'nullable|string',  // Add validation for number field
            'password' => 'nullable|min:8',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

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
                Storage::delete($user->profile_picture);
            }
            
            $formFields['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Update the user
        $user->update($formFields);

        return back()->with('success', 'Profile updated successfully!');
    }
}
