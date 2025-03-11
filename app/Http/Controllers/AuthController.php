<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    // Register User
    public function register(Request $request) 
    {
        $formFields = $request->validate([
            'firstname' => ['required', 'string', 'min:2', 'max:255'],
            'lastname' => ['required', 'string', 'min:2', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'birthday' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required']
        ]);
        
        // Remove terms from form fields as it's not a database column
        unset($formFields['terms']);
        
        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);
        
        // Create User
        $user = User::create($formFields);
        
        // Login
        auth()->login($user);
        
        // Send verification email
        $user->sendEmailVerificationNotification();
        
        return redirect('/email/verify')->with('message', 'User created and logged in');
    }

    // Verify Email Notice Handler
    public function verifyEmailNotice()
    {
        return view('auth.verify-email');
    }

    // Email Verification Handler
    public function verifyEmailHandler(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('dashboard');
    }

    // Resending the Verification Email Handler
    public function verifyEmailResend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

    // Login User
    public function login(Request $request) {
        // Validate
        $fields = $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required']
        ]);

        // Try To Log In The User
        if(Auth::attempt($fields, $request->remember)) {
            return redirect()->intended('posts');
        } else {
            return back()->withErrors([
                'failed' => 'The provided credentials do not match our records.'
            ]);
        }
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
