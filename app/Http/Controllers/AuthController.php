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
        $formFields = $request->validate([
            'firstname' => ['required', 'string', 'min:2', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'min:2', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'birthday' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required']
        ]);
        
        // Remove terms from form fields as it's not a database column
        unset($formFields['terms']);
        
        // Set default value for number field to prevent SQL error
        $formFields['number'] = $request->input('number', '');
        
        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        
        // Create User
        $user = User::create($formFields);
        
        // Instead of logging in, redirect to login page
        return redirect('/login')->with('message', 'Account created successfully! Please login to continue.');
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
