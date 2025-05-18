{{-- Mobile Login/Register View --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Recyclo (Mobile)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <style>
        body {
            font-family: 'Urbanist', Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .mobile-login-container {
            max-width: 420px;
            margin: 0 auto;
            padding: 32px 12px 24px 12px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            min-height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .mobile-login-logo {
            display: block;
            margin: 0 auto 18px auto;
            max-width: 120px;
        }
        .mobile-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: #517A5B;
            margin-bottom: 24px;
        }
        .input-field {
            display: flex;
            align-items: center;
            background: #f0f0f0;
            border-radius: 8px;
            margin-bottom: 14px;
            padding: 0 10px;
        }
        .input-field i {
            color: #517A5B;
            font-size: 1.2rem;
            margin-right: 8px;
        }
        .input-field input {
            border: none;
            background: transparent;
            flex: 1;
            padding: 14px 0;
            font-size: 1rem;
            outline: none;
        }
        .btn {
            width: 100%;
            background: #517A5B;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 18px 0 10px 0;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #3a5941;
        }
        .switch-link {
            display: block;
            text-align: center;
            color: #517A5B;
            font-weight: 500;
            margin-top: 10px;
            text-decoration: underline;
            cursor: pointer;
        }
        .text-red-500 {
            color: #b71c1c;
            font-size: 0.95em;
            margin-bottom: 6px;
        }
        .terms-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        .terms-checkbox label {
            margin-left: 6px;
            font-size: 0.97em;
        }
        .forgot-password-link {
            display: block;
            text-align: right;
            color: #517A5B;
            font-size: 0.98em;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        /* Animation styles */
        .mobile-form-switcher {
            position: relative;
            width: 100%;
            min-height: 420px;
        }
        .mobile-form {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0;
            transform: translateX(40px) scale(0.98);
            pointer-events: none;
            transition: opacity 0.4s cubic-bezier(.4,0,.2,1), transform 0.4s cubic-bezier(.4,0,.2,1);
        }
        .mobile-form.active {
            opacity: 1;
            transform: translateX(0) scale(1);
            pointer-events: auto;
            z-index: 2;
        }
    </style>
</head>
<body>
    <div class="mobile-login-container">
        <img src="{{ asset('images/recyclo-logo.png') }}" alt="Recyclo Logo" class="mobile-login-logo">
        <div class="mobile-form-switcher">
            <div id="mobile-login" class="mobile-form active">
                <h2 class="mobile-title">Sign in to Recyclo</h2>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-field">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required />
                    </div>
                    @error('email')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    @error('password')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="terms-checkbox">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <a href="{{ route('password.request') }}" class="forgot-password-link">Forgot your password?</a>
                </form>
                <span class="switch-link" onclick="switchMobileForm('signup')">Don't have an account? Sign Up</span>
            </div>
            <div id="mobile-signup" class="mobile-form">
                <h2 class="mobile-title">Join Recyclo</h2>
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="input-field">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="firstname" value="{{ old('firstname') }}" placeholder="First name" required />
                    </div>
                    @error('firstname')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="middlename" value="{{ old('middlename') }}" placeholder="Middle name" />
                    </div>
                    @error('middlename')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="lastname" value="{{ old('lastname') }}" placeholder="Last name" required />
                    </div>
                    @error('lastname')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="bi bi-person-badge-fill"></i>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Username" required />
                    </div>
                    @error('username')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required />
                    </div>
                    @error('email')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="bi bi-calendar-fill"></i>
                        <input type="date" name="birthday" value="{{ old('birthday') }}" placeholder="Birthday" required />
                    </div>
                    @error('birthday')
                        <div class="text-red-500">Age not valid</div>
                    @enderror
                    <div class="input-field">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    @error('password')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password_confirmation" placeholder="Confirm password" required />
                    </div>
                    <div class="terms-checkbox">
                        <input type="checkbox" name="terms" id="terms" required>
                        <label for="terms">I accept the <span class="terms-link" id="openTermsMobile">terms and conditions</span></label>
                    </div>
                    <button type="submit" class="btn">Sign up</button>
                </form>
                <span class="switch-link" onclick="switchMobileForm('login')">Already have an account? Sign In</span>
            </div>
        </div>
    </div>
    <!-- Terms and Conditions Modal -->
    <div class="terms-modal" id="termsModalMobile" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);z-index:9999;justify-content:center;align-items:center;">
        <div style="background:#fff;padding:24px 16px;border-radius:12px;max-width:95vw;width:400px;max-height:80vh;overflow-y:auto;position:relative;box-shadow:0 4px 20px rgba(0,0,0,0.15);">
            <h2 style="color:#517A5B;font-size:1.4rem;font-weight:700;margin-bottom:16px;text-align:center;">Terms and Conditions</h2>
            <div style="font-size:1rem;color:#333;line-height:1.6;">
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
            <button id="closeTermsMobile" style="margin-top:18px;width:100%;background:#517A5B;color:#fff;border:none;padding:12px 0;border-radius:8px;font-size:1.1rem;font-weight:600;cursor:pointer;">Close</button>
        </div>
    </div>
    <script>
        function switchMobileForm(form) {
            const login = document.getElementById('mobile-login');
            const signup = document.getElementById('mobile-signup');
            if(form === 'signup') {
                login.classList.remove('active');
                signup.classList.add('active');
            } else {
                signup.classList.remove('active');
                login.classList.add('active');
            }
        }
        // Terms modal logic
        document.addEventListener('DOMContentLoaded', function() {
            const openBtn = document.getElementById('openTermsMobile');
            const modal = document.getElementById('termsModalMobile');
            const closeBtn = document.getElementById('closeTermsMobile');
            if(openBtn && modal && closeBtn) {
                openBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    modal.style.display = 'flex';
                });
                closeBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
                modal.addEventListener('click', function(e) {
                    if(e.target === modal) modal.style.display = 'none';
                });
            }
        });
        // On page load, if there are sign-up validation errors, show sign-up form
        document.addEventListener('DOMContentLoaded', function() {
            var hasSignupError = false;
            @if ($errors->has('firstname') || $errors->has('middlename') || $errors->has('lastname') || $errors->has('username') || $errors->has('birthday') || $errors->has('password') || $errors->has('terms') || $errors->has('email'))
                hasSignupError = true;
            @endif
            if (hasSignupError) {
                switchMobileForm('signup');
            }
        });
    </script>
</body>
</html> 