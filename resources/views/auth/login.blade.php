@extends('components.layout')

@section('content')
<div class="login-body">
    <div class="login-container" id="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Login Form -->
                <form action="{{ route('login') }}" method="post" class="sign-in-form">
                    @csrf
                    <img src="{{ asset('images/recyclo-logo.png') }}" alt="Recyclo Logo" class="login-logo">
                    <h2 class="title">Sign in to Recyclo</h2>
                    
                    @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="input-field">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required />
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    <div class="input-field">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    <div class="terms-checkbox">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    
                    <input type="submit" value="Login" class="btn solid" />
                    
                    <a href="{{ route('password.request') }}" class="mt-3 text-sm text-secondary-green hover:underline">
                        Forgot your password?
                    </a>
                    
                    <p class="social-text">Or Sign in with</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-twitter"></i>
                        </a>
                    </div>
                </form>

                <!-- Full Registration Form -->
                <form action="{{ route('register') }}" method="post" class="sign-up-form">
                    @csrf
                    <h2 class="title">Join Recyclo</h2>
                    
                    <!-- First Name -->
                    <div class="input-field">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="firstname" value="{{ old('firstname') }}" placeholder="First name" required />
                    </div>
                    @error('firstname')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Last Name -->
                    <div class="input-field">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="lastname" value="{{ old('lastname') }}" placeholder="Last name" required />
                    </div>
                    @error('lastname')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Username -->
                    <div class="input-field">
                        <i class="bi bi-person-badge-fill"></i>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Username" required />
                    </div>
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Email -->
                    <div class="input-field">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required />
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Birthday -->
                    <div class="input-field">
                        <i class="bi bi-calendar-fill"></i>
                        <input type="date" name="birthday" value="{{ old('birthday') }}" placeholder="Birthday" required />
                    </div>
                    @error('birthday')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Password -->
                    <div class="input-field">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Confirm Password -->
                    <div class="input-field">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password_confirmation" placeholder="Confirm password" required />
                    </div>
                    
                    <!-- Terms & Conditions -->
                    <div class="terms-checkbox">
                        <input type="checkbox" name="terms" id="terms" required>
                        <label for="terms">I accept the terms and conditions</label>
                    </div>
                    
                    <input type="submit" class="btn" value="Sign up" />
                    
                    <!-- Removed social login options here -->
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New to Recyclo?</h3>
                    <p>Join our community of eco-conscious buyers and sellers. Turn waste into opportunity!</p>
                    <div class="text-center w-full mt-4">
                        <button type="button" class="btn transparent" id="sign-up-btn">Sign up</button>
                    </div>
                </div>
                <img src="{{ asset('images/reduce.svg') }}" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Already a member?</h3>
                    <p>Sign in to continue your journey in making the world a better place, one recycled item at a time.</p>
                    <button type="button" class="btn transparent" id="sign-in-btn">Sign in</button>
                </div>
                <img src="{{ asset('images/recycle.svg') }}" class="image" alt="" />
            </div>
        </div>
    </div>
</div>

<script>
    const signUpButton = document.getElementById('sign-up-btn');
    const signInButton = document.getElementById('sign-in-btn');
    const container = document.getElementById('container');

    // Function to set focus on the first input of the active form
    function setFormFocus() {
        // Determine which form is active
        const activeForm = container.classList.contains('sign-up-mode') ? 
            document.querySelector('.sign-up-form .input-field input') : 
            document.querySelector('.sign-in-form .input-field input');
        
        // Set focus on the first input field
        if (activeForm) {
            activeForm.focus();
        }
    }

    // Check URL parameters to determine which form to show
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const form = urlParams.get('form');
        
        // Check for 'register' parameter, case-insensitive
        if (form && form.toLowerCase() === 'register') {
            container.classList.add('sign-up-mode');
            console.log('Registration form activated via URL parameter');
        } else {
            // Ensure we're in login mode and focus on login field
            container.classList.remove('sign-up-mode');
        }
        
        // Focus on the appropriate form's input - use a shorter delay for better UX
        setTimeout(setFormFocus, 50);
    });

    signUpButton.addEventListener('click', () => {
        container.classList.add('sign-up-mode');
        setTimeout(setFormFocus, 300); // Add delay to wait for animation
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove('sign-up-mode');
        setTimeout(setFormFocus, 300); // Add delay to wait for animation
    });
    
    // Add glow effect to input fields when focused
    document.querySelectorAll('.input-field input').forEach(input => {
        input.addEventListener('focus', () => {
            input.previousElementSibling.classList.add('glow');
        });
        input.addEventListener('blur', () => {
            input.previousElementSibling.classList.remove('glow');
        });
    });
</script>
@endsection