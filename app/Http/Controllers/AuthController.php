<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register User
<<<<<<< Updated upstream
    public function register(Request $request) {
        
        // Validate
        $fields = $request->validate([
            'firstname' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
            'username' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'number' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Register
        $user = User::create($fields);
        
        // Login
        Auth::login($user);
=======
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
>>>>>>> Stashed changes

        //Redirect
        return redirect()->route('posts');
    }

    // Login User
    public function login(Request $request) {
        // Validate
        $fields = $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required']
        ]);

<<<<<<< Updated upstream
        // Try To Log In The User
        if(Auth::attempt($fields, $request->remember)) {
=======
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

>>>>>>> Stashed changes
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
