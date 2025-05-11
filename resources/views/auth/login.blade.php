<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Recyclo</title>
    
    <!-- Required imports as specified -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preload" as="image" href="images/logo.png">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/css/login.css', 'resources/js/app.js'])
    <style>
        .back-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background-color: var(--hoockers-green, #517A5B);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .back-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            background-color: var(--hoockers-green_80, #3a5941);
        }
        
        .back-button i {
            font-size: 24px;
        }
        
        /* Make input fields in sign-up form more compact */
        .sign-up-form .input-field {
            margin: 8px 0;
            height: 45px; /* Reduced from default height */
        }
        
        .sign-up-form .input-field i {
            line-height: 45px; /* Match the new height */
        }
        
        .sign-up-form .input-field input {
            padding: 0 10px 0 45px; /* Adjust padding */
        }
        
        /* Add more vertical spacing efficiency */
        .sign-up-form {
            padding: 15px 30px;
        }
        
        .sign-up-form .title {
            margin-bottom: 10px;
        }
        
        /* Reduce space between error messages and fields */
        .sign-up-form .text-red-500 {
            margin-top: 0 !important;
            margin-bottom: 4px;
        }
        
        /* Make the terms checkbox more compact */
        .sign-up-form .terms-checkbox {
            margin: 5px 0;
        }
        
        /* Add styling for CSRF token notice */
        .csrf-notice {
            color: #517A5B;
            font-size: 12px;
            margin-top: 5px;
            text-align: center;
        }
        
        /* Enhanced success message styling */
        .success-message {
            background-color: rgba(81, 122, 91, 0.15);
            color: #3C6255;
            font-size: 16px;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            border-left: 4px solid #3C6255;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Forgot password link styling */
        .forgot-password-link {
            font-size: 16px;
            font-weight: 600;
            color: #517A5B;
            margin-top: 15px;
            text-align: center;
            display: block;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 6px;
        }
        
        .forgot-password-link:hover {
            background-color: rgba(81, 122, 91, 0.1);
            text-decoration: underline;
            transform: translateY(-2px);
        }

        /* Terms and Conditions Modal Styles */
        .terms-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .terms-modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .terms-modal-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #517A5B;
        }

        .terms-modal-header h2 {
            color: #517A5B;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .terms-modal-body {
            margin-bottom: 20px;
            line-height: 1.6;
            color: #333;
        }

        .terms-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .terms-modal-btn {
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .terms-modal-btn.accept {
            background-color: #517A5B;
            color: white;
        }

        .terms-modal-btn.accept:hover {
            background-color: #3a5941;
        }

        .terms-modal-btn.reject {
            background-color: #f1f1f1;
            color: #333;
        }

        .terms-modal-btn.reject:hover {
            background-color: #e1e1e1;
        }

        .terms-link {
            color: #517A5B;
            text-decoration: underline;
            cursor: pointer;
            font-weight: 500;
        }

        .terms-link:hover {
            color: #3a5941;
        }

        /* Mobile Navigation Styles */
        .mobile-nav {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #517A5B;
            padding: 15px;
            z-index: 1001;
        }

        .burger-menu {
            display: none;
            cursor: pointer;
            padding: 10px;
            z-index: 1002;
        }

        .burger-menu span {
            display: block;
            width: 25px;
            height: 3px;
            background-color: white;
            margin: 5px 0;
            transition: all 0.3s ease;
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            background-color: white;
            padding: 60px 20px 20px;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            z-index: 1000;
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-menu li {
            margin: 15px 0;
        }

        .mobile-menu a {
            color: #333;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .mobile-menu a:hover {
            background-color: #f5f5f5;
            color: #517A5B;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }

        /* Mobile Tab Navigation */
        .mobile-tabs {
            display: none;
            width: 100%;
            margin-bottom: 20px;
            background: #f5f5f5;
            border-radius: 8px;
            overflow: hidden;
        }

        .mobile-tab {
            width: 50%;
            padding: 15px;
            text-align: center;
            background-color: #f5f5f5;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            border: none;
            outline: none;
        }

        .mobile-tab.active {
            background-color: #517A5B;
            color: white;
        }

        /* Enhanced Mobile Responsive Styles */
        @media screen and (max-width: 768px) {
            .mobile-nav {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .burger-menu {
                display: block;
            }

            .login-container {
                margin-top: 60px;
                padding: 15px;
                min-height: calc(100vh - 60px);
            }

            .forms-container {
                width: 100%;
                padding: 0;
            }

            .signin-signup {
                width: 100%;
                left: 0;
                padding: 0;
                transform: none !important;
            }

            .sign-in-form,
            .sign-up-form {
                padding: 20px 15px;
                width: 100%;
                position: absolute;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease;
                transform: none !important;
            }

            .sign-in-form.active,
            .sign-up-form.active {
                opacity: 1;
                visibility: visible;
                position: relative;
            }

            .panels-container {
                display: none;
            }

            /* Hide the original flip buttons and disable flip mode */
            .panel .btn.transparent {
                display: none;
            }

            .sign-up-mode {
                transform: none !important;
            }

            .sign-up-mode .signin-signup {
                transform: none !important;
            }

            .sign-up-mode .sign-in-form {
                transform: none !important;
            }

            .sign-up-mode .sign-up-form {
                transform: none !important;
            }

            .sign-in-form .title,
            .sign-up-form .title {
                font-size: 24px;
                margin-bottom: 15px;
            }

            .input-field {
                margin: 8px 0;
                height: 45px;
            }

            .input-field input {
                font-size: 14px;
                padding: 0 10px 0 45px;
            }

            .input-field i {
                font-size: 18px;
                line-height: 45px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 16px;
                margin: 15px 0;
            }

            .social-media {
                margin: 15px 0;
            }

            .social-icon {
                width: 35px;
                height: 35px;
                line-height: 35px;
                font-size: 16px;
                margin: 0 5px;
            }

            .back-button {
                top: 15px;
                right: 15px;
                width: 40px;
                height: 40px;
            }

            .back-button i {
                font-size: 20px;
            }

            .terms-modal-content {
                width: 95%;
                margin: 10px;
                padding: 20px;
                max-height: 85vh;
            }

            .terms-modal-header h2 {
                font-size: 20px;
            }

            .terms-modal-body {
                font-size: 14px;
            }

            .terms-modal-body h3 {
                font-size: 16px;
                margin: 15px 0 10px;
            }

            .terms-modal-btn {
                padding: 8px 20px;
                font-size: 14px;
            }

            /* Form specific mobile adjustments */
            .sign-up-form .input-field {
                margin: 6px 0;
            }

            .sign-up-form .terms-checkbox {
                margin: 10px 0;
                font-size: 14px;
            }

            .sign-up-form .text-red-500 {
                font-size: 12px;
                margin: 2px 0 8px;
            }

            .forgot-password-link {
                font-size: 14px;
                margin-top: 10px;
            }

            .social-text {
                font-size: 14px;
                margin: 15px 0;
            }

            /* Success message mobile adjustments */
            .success-message {
                font-size: 14px;
                padding: 10px;
                margin-bottom: 15px;
            }

            /* Login logo adjustments */
            .login-logo {
                max-width: 150px;
                margin-bottom: 15px;
            }

            /* Terms checkbox mobile adjustments */
            .terms-checkbox input[type="checkbox"] {
                width: 16px;
                height: 16px;
            }

            .terms-checkbox label {
                font-size: 14px;
                line-height: 1.4;
            }

            /* Error message mobile adjustments */
            .text-red-500 {
                font-size: 12px;
                margin: 2px 0 8px;
            }

            .mobile-promo {
                display: block;
            }
        }

        /* Additional breakpoint for very small devices */
        @media screen and (max-width: 360px) {
            .login-container {
                padding: 10px;
            }

            .sign-in-form,
            .sign-up-form {
                padding: 15px 10px;
            }

            .input-field {
                height: 40px;
            }

            .input-field i {
                line-height: 40px;
            }

            .btn {
                padding: 10px 15px;
                font-size: 14px;
            }

            .social-icon {
                width: 30px;
                height: 30px;
                line-height: 30px;
            }
        }

        /* Burger Menu Animation */
        .burger-menu.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .burger-menu.active span:nth-child(2) {
            opacity: 0;
        }

        .burger-menu.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* Mobile Promotional Section */
        .mobile-promo {
            display: none;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
            border-top: 1px solid #eee;
        }

        .mobile-promo h3 {
            color: #517A5B;
            font-size: 18px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .mobile-promo p {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .mobile-promo .btn {
            background-color: #517A5B;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .mobile-promo .btn:hover {
            background-color: #3a5941;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Mobile Navigation -->
    <nav class="mobile-nav">
        <img src="{{ asset('images/recyclo-logo.png') }}" alt="Recyclo Logo" style="height: 30px;">
        <div class="burger-menu" id="burgerMenu">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="{{ route('landingpage') }}">Home</a></li>
            <li><a href="{{ route('posts') }}">Posts</a></li>
            <li><a href="{{ route('password.request') }}">Forgot Password</a></li>
            <li><a href="#" onclick="switchToSignup(); return false;">Sign Up</a></li>
        </ul>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

<!-- Back Button -->
<a href="{{ route('landingpage') }}" class="back-button" title="Back to Home">
    <i class="bi bi-arrow-left"></i>
</a>

<div class="login-body">
    <div class="login-container" id="container">
            <!-- Mobile Tabs -->
            <div class="mobile-tabs">
                <button class="mobile-tab active" data-tab="signin">Sign In</button>
                <button class="mobile-tab" data-tab="signup">Sign Up</button>
            </div>

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

                    @if (session('message'))
                        <div class="success-message">
                            {{ session('message') }}
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
                    
                    <a href="{{ route('password.request') }}" class="forgot-password-link">
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
                    
                    <!-- Add a hidden input with the token as a backup -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <!-- First Name -->
                    <div class="input-field">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="firstname" value="{{ old('firstname') }}" placeholder="First name" required />
                    </div>
                    @error('firstname')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Middle Name -->
                    <div class="input-field">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="middlename" value="{{ old('middlename') }}" placeholder="Middle name" />
                    </div>
                    @error('middlename')
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
                            <p class="text-red-500 text-sm mt-1" style="font-size: 14px; font-weight: 500;">Age not valid</p>
                    @enderror
                        <small class="text-muted" style="display: block; margin-top: -5px; margin-bottom: 10px; color: #666; font-size: 12px;">
                            You must be at least 18 years old to register.
                        </small>
                    
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
                            <label for="terms">I accept the <span class="terms-link" id="openTerms">terms and conditions</span></label>
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

    <!-- Terms and Conditions Modal -->
    <div class="terms-modal" id="termsModal">
        <div class="terms-modal-content">
            <div class="terms-modal-header">
                <h2>Terms and Conditions</h2>
            </div>
            <div class="terms-modal-body">
                <h3>1. Acceptance of Terms</h3>
                <p>By accessing and using Recyclo, you agree to be bound by these Terms and Conditions.</p>

                <h3>2. User Responsibilities</h3>
                <p>Users must:</p>
                <ul>
                    <li>Provide accurate and complete information</li>
                    <li>Maintain the security of their account</li>
                    <li>Comply with all applicable laws and regulations</li>
                    <li>Not engage in any fraudulent or harmful activities</li>
                </ul>

                <h3>3. Privacy Policy</h3>
                <p>We collect and process personal data in accordance with our Privacy Policy. By using our service, you consent to such processing.</p>

                <h3>4. Content Guidelines</h3>
                <p>Users must ensure that all content posted:</p>
                <ul>
                    <li>Is accurate and not misleading</li>
                    <li>Does not violate any third-party rights</li>
                    <li>Complies with our community guidelines</li>
                </ul>

                <h3>5. Account Termination</h3>
                <p>We reserve the right to terminate accounts that violate these terms or engage in inappropriate behavior.</p>

                <h3>6. Changes to Terms</h3>
                <p>We may modify these terms at any time. Continued use of the service constitutes acceptance of modified terms.</p>
            </div>
            <div class="terms-modal-footer">
                <button class="terms-modal-btn reject" id="rejectTerms">Reject</button>
                <button class="terms-modal-btn accept" id="acceptTerms">Accept</button>
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

    // Add code to help debug CSRF token issues
    document.addEventListener('DOMContentLoaded', function() {
        // Check for CSRF token in both forms
        const loginForm = document.querySelector('.sign-in-form');
        const registerForm = document.querySelector('.sign-up-form');
        
        // Function to check if form has CSRF token
        function checkCsrfToken(form, formName) {
            const csrfField = form.querySelector('input[name="_token"]');
            if (!csrfField || !csrfField.value) {
                console.warn(`⚠️ CSRF token missing in ${formName} form`);
            } else {
                console.info(`✓ CSRF token present in ${formName} form: ${csrfField.value.substring(0, 10)}...`);
            }
        }
        
        // Check both forms
        checkCsrfToken(loginForm, 'login');
        checkCsrfToken(registerForm, 'registration');
        
        // Add event listener to registration form for debugging
        registerForm.addEventListener('submit', function(e) {
            const csrfToken = registerForm.querySelector('input[name="_token"]');
            console.info('Form submission attempt with token:', csrfToken ? csrfToken.value.substring(0, 10) + '...' : 'MISSING');
        });

        // Special handling for registration success
        const successMessage = "{{ session('message') }}";
        if (successMessage && successMessage.includes('Account created successfully')) {
            container.classList.remove('sign-up-mode');
            
            // Add attention to the success message
            const messageDiv = document.querySelector('.success-message');
            if (messageDiv) {
                setTimeout(() => {
                    messageDiv.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        messageDiv.style.transform = 'scale(1)';
                    }, 200);
                }, 500);
            }
        }

        // Add subtle pulse animation to the forgot password link
        const forgotPasswordLink = document.querySelector('.forgot-password-link');
        if (forgotPasswordLink) {
            setTimeout(() => {
                forgotPasswordLink.style.transition = 'all 0.6s ease';
                forgotPasswordLink.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    forgotPasswordLink.style.transform = 'scale(1)';
                }, 300);
            }, 2000);
        }
    });

        // Terms and Conditions Modal Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('termsModal');
            const openTermsBtn = document.getElementById('openTerms');
            const acceptTermsBtn = document.getElementById('acceptTerms');
            const rejectTermsBtn = document.getElementById('rejectTerms');
            const termsCheckbox = document.getElementById('terms');

            // Open modal when clicking the terms link
            openTermsBtn.addEventListener('click', function(e) {
                e.preventDefault();
                modal.style.display = 'flex';
            });

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Handle accept button
            acceptTermsBtn.addEventListener('click', function() {
                termsCheckbox.checked = true;
                modal.style.display = 'none';
            });

            // Handle reject button
            rejectTermsBtn.addEventListener('click', function() {
                termsCheckbox.checked = false;
                modal.style.display = 'none';
            });

            // Prevent checkbox from being checked directly
            termsCheckbox.addEventListener('click', function(e) {
                if (!this.checked) {
                    e.preventDefault();
                    modal.style.display = 'flex';
                }
            });
        });

        // Mobile Menu Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const burgerMenu = document.getElementById('burgerMenu');
            const mobileMenu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('overlay');

            function toggleMenu() {
                burgerMenu.classList.toggle('active');
                mobileMenu.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
            }

            burgerMenu.addEventListener('click', toggleMenu);
            overlay.addEventListener('click', toggleMenu);

            // Close menu when clicking a link
            const mobileMenuLinks = mobileMenu.querySelectorAll('a');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (mobileMenu.classList.contains('active')) {
                        toggleMenu();
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth > 768 && mobileMenu.classList.contains('active')) {
                    toggleMenu();
                }
            });
        });

        // Mobile Tab Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileTabs = document.querySelectorAll('.mobile-tab');
            const signInForm = document.querySelector('.sign-in-form');
            const signUpForm = document.querySelector('.sign-up-form');
            const container = document.getElementById('container');

            function switchTab(tab) {
                // Update tab styles
                mobileTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Show/hide forms
                if (tab.dataset.tab === 'signin') {
                    signInForm.classList.add('active');
                    signUpForm.classList.remove('active');
                    container.classList.remove('sign-up-mode');
                } else {
                    signInForm.classList.remove('active');
                    signUpForm.classList.add('active');
                    container.classList.add('sign-up-mode');
                }
            }

            // Add click handlers to tabs
            mobileTabs.forEach(tab => {
                tab.addEventListener('click', () => switchTab(tab));
            });

            // Check URL parameters for initial tab
            const urlParams = new URLSearchParams(window.location.search);
            const form = urlParams.get('form');
            
            if (form && form.toLowerCase() === 'register') {
                switchTab(mobileTabs[1]); // Switch to signup tab
            } else {
                switchTab(mobileTabs[0]); // Default to signin tab
            }

            // Disable original flip functionality on mobile
            if (window.innerWidth <= 768) {
                if (signUpButton) signUpButton.style.display = 'none';
                if (signInButton) signInButton.style.display = 'none';
            }

            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth <= 768) {
                    if (signUpButton) signUpButton.style.display = 'none';
                    if (signInButton) signInButton.style.display = 'none';
                } else {
                    if (signUpButton) signUpButton.style.display = '';
                    if (signInButton) signInButton.style.display = '';
                }
            });
        });

        // Function to switch to signup tab
        function switchToSignup() {
            const signupTab = document.querySelector('.mobile-tab[data-tab="signup"]');
            if (signupTab) {
                switchTab(signupTab);
            }
        }

        // Update the mobile menu click handler to close menu after clicking
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuLinks = document.querySelectorAll('.mobile-menu a');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    const mobileMenu = document.getElementById('mobileMenu');
                    const burgerMenu = document.getElementById('burgerMenu');
                    const overlay = document.getElementById('overlay');
                    
                    if (mobileMenu.classList.contains('active')) {
                        mobileMenu.classList.remove('active');
                        burgerMenu.classList.remove('active');
                        overlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            });
        });
</script>
</body>
</html>