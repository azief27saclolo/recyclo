<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    // Register User
    public function register(Request $request) 
    {
        // Validate user inputs
        $validatedData = $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'birthday' => [
                'required', 
                'date',
                'before:' . date('Y-m-d', strtotime('-16 years')) // Using date() instead of now()->subYears()
            ],
            'password' => 'required|confirmed|min:8',
        ]);
        
        // Optional debugging log - remove if not needed
        // \Log::info('Validated registration data:', ['data' => $validatedData]);
        
        // Create user with validated data
        $userData = [
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'birthday' => $validatedData['birthday'],
            'password' => bcrypt($validatedData['password']),
        ];
        
        // Remove terms from form fields as it's not a database column
        if (isset($request['terms'])) {
            unset($request['terms']);
        }
        
        // Create User
        $user = User::create($userData);
        
        // Login
        auth()->login($user);
        
        // Redirect directly to posts page
        return redirect('/posts')->with('message', 'Account created successfully! Welcome to Recyclo.');
    }

    // Verify Email Notice Handler - Modified to redirect to dashboard
    public function verifyEmailNotice()
    {
        // Bypass verification by redirecting to dashboard
        return redirect('/dashboard');
    }

    // Email Verification Handler - kept for future use if needed
    public function verifyEmailHandler(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('dashboard');
    }

    // Resending the Verification Email Handler - kept for future use if needed
    public function verifyEmailResend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

    // Login User
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Check if the user is an admin
        $admin = Admin::where('email', $credentials['email'])->first();
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            // Create a session for admin
            $request->session()->put('admin_logged_in', true);
            $request->session()->put('admin_email', $admin->email);
            $request->session()->put('admin_id', $admin->id);
            return redirect('/admin/dashboard');
        }
        
        // Regular user authentication
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if user has completed their profile setup
            $user = auth()->user();
            $profileIncomplete = false;
            
            // Check for empty or null values in important profile fields
            if (empty($user->location) || empty($user->number)) {
                $profileIncomplete = true;
                session(['profile_incomplete' => true]);
            } else {
                session()->forget('profile_incomplete');
            }

            return redirect()->intended('posts');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logout User
    public function logout(Request $request) {
        // Logout the user
        Auth::logout();
        // Invalidate the user's session
        $request->session()->invalidate();
        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect to home
        return redirect('/');
    }
}
