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
            'birthday' => [
                'required', 
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                function ($attribute, $value, $fail) {
                    $birthday = \Carbon\Carbon::parse($value);
                    $age = $birthday->age;
                    if ($age < 18) {
                        $fail('Age not valid');
                    }
                },
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required']
        ]);
        
        try {
            // Remove terms from form fields as it's not a database column
            unset($formFields['terms']);
            
            // Set default value for number field to prevent SQL error
            $formFields['number'] = $request->input('number', '');
            
            // Hash Password
            $formFields['password'] = bcrypt($formFields['password']);
            
            // Create User
            $user = User::create($formFields);
            
            // Send verification email
            event(new Registered($user));
            
            // Explicitly regenerate the session to ensure the CSRF token is refreshed
            $request->session()->regenerate();
            
            // Login the user immediately
            Auth::login($user);
            
            // Redirect to verification notice
            return redirect()->route('verification.notice')
                ->with('message', 'Account created successfully! Please check your email to verify your account.');
        } catch (\Exception $e) {
            // If there's an error, redirect back to registration form with error
            return redirect()->route('login', ['form' => 'register'])
                ->withInput()
                ->withErrors(['error' => 'Registration failed. Please try again. ' . ($e->getMessage() ?? '')]);
        }
    }

    // Verify Email Notice Handler
    public function verifyEmailNotice()
    {
        return view('auth.verify-email');
    }

    // Email Verification Handler
    public function verifyEmailHandler(Request $request, $id, $hash)
    {
        try {
            // Find the user by ID - without requiring authentication
            $user = User::findOrFail($id);
            
            \Log::info('Starting email verification process', [
                'user_id' => $user->id,
                'email' => $user->email,
                'current_verified_status' => $user->is_email_verified
            ]);
            
            // Check if the user is already verified
            if ($user->hasVerifiedEmail()) {
                \Log::info('User already verified', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
                
                // If user is not logged in, redirect to login page
                if (!Auth::check()) {
                    return redirect()->route('login')
                        ->with('message', 'Your email is already verified. You can now log in.');
                }
                
                return redirect()->route('landingpage')
                    ->with('message', 'Your email is already verified.');
            }
            
            // Check if the verification URL is valid
            $verifies = hash_equals(
                sha1($user->getEmailForVerification()),
                (string) $hash
            );
            
            if (!$verifies) {
                throw new \Exception('Invalid verification link');
            }
            
            // Mark as verified
            $user->markEmailAsVerified();
            
            // Verify the update was successful
            $user->refresh();
            if (!$user->hasVerifiedEmail()) {
                throw new \Exception('Email verification status was not updated');
            }

            \Log::info('Email verified successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'is_verified' => $user->is_email_verified
            ]);

            // If user is not logged in, redirect to login page
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('verified', 'Your email has been successfully verified! You can now log in.');
            }
            
            return redirect()->route('landingpage')
                ->with('verified', 'Your email has been successfully verified! You can now log in.');
        } catch (\Exception $e) {
            \Log::error('Email verification failed', [
                'error' => $e->getMessage(),
                'user_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('verification.notice')
                ->with('error', 'The verification link is invalid or has expired. Please request a new verification email.');
        }
    }

    // Add a helper method to get the verification email for a user
    public function getEmailForVerification($user)
    {
        return $user->email;
    }

    // Resending the Verification Email Handler
    public function verifyEmailResend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('landingpage')
                ->with('message', 'Your email is already verified.');
        }

        try {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('message', 'Verification link sent! Please check your email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send verification email. Please try again later.');
        }
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
        
        // Check if user exists but is not verified
        $user = User::where('email', $credentials['email'])->first();
        if ($user && !$user->hasVerifiedEmail() && Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'You need to verify your email before logging in. Please check your inbox.',
            ])->with('verification_needed', true);
        }
        
        // Regular user authentication with verified email check
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You need to verify your email before logging in.',
                ])->with('verification_needed', true);
            }
            
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
