<x-layout>
    
    <div class="flex justify-center items-center h-screen px-4">
        
<<<<<<< Updated upstream
        <form action="{{ route('login') }}" method="post">
            @csrf
=======
        .back-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            background-color: var(--hoockers-green_80, #3a5941);
        }
        
        .back-button i {
            font-size: 24px;
        }
            </style>
</head>
<body>
>>>>>>> Stashed changes

            <div class="w-full max-w-sm p-6 shadow-lg bg-gray-100 rounded-md"> <!-- Changed to max-w-md for better responsiveness -->

    
                <div class="flex justify-center items-center mb-4">
                    <img src="images/recyclo-logo.png" alt="Logo" class="max-w-full h-auto"> <!-- Added responsive image styles -->
                </div>
    
                <hr class="mt-3">

                {{-- Email --}}
                <div class="mt-3">
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="border w-full text-base px-2 py-2 focus:outline-none 
                    focus:ring-0 focus:border-gray-600 rounded-2xl @error('title') ring-red-500 @enderror" placeholder="Enter Username..."/>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Password --}}
                <div class="mt-5"> 
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 
                    focus:border-gray-600 rounded-2xl @error('title') ring-red-500 @enderror" placeholder="Enter Password..."/>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Remember Me --}}
                <div class="mb-4 mt-4">
                    <input type="checkbox" name="remember" id="remember">
                    <span for="remember">Remember Me</span>
                </div>

                @error('failed')
                    <p class="error">{{ $message }}</p>
                @enderror
    
                {{-- Login Button --}}
                <div class="mt-5">
                    <button type="submit" class="border-2 border-yellow-400 bg-yellow-400 py-2 w-full rounded-md">Log In</button> <!-- Increased padding for better touch targets -->
                </div>
    
                {{-- Log In With --}}
                <div class="flex justify-center items-center mt-3">
                    <label class="text-sm">or log in with</label>
                </div>
        
                <div class="flex justify-center items-center mt-2 space-x-4">
                    <a href="#link1" class="block">
                        <img src="images/apple-logo.png" alt="Apple Logo" class="h-8 w-8">
                    </a>
                    <a href="#link2" class="block">
                        <img src="images/google-logo.png" alt="Google Logo" class="h-8 w-8">
                    </a>
                    <a href="#link3" class="block">
                        <img src="images/facebook-logo.png" alt="Facebook Logo" class="h-8 w-8">
                    </a>
<<<<<<< Updated upstream
=======
                    
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
                        <input type="date" name="birthday" id="birthday" value="{{ old('birthday') }}" max="{{ date('Y-m-d', strtotime('-16 years')) }}" placeholder="Birthday" required />
                    </div>
                    <small style="color: #6c757d; text-align: left; display: block; margin-top: -5px; margin-bottom: 10px;">
                        <i class="bi bi-info-circle"></i> You must be at least 16 years old to register
                    </small>
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
>>>>>>> Stashed changes
                </div>
    
<<<<<<< Updated upstream
            </div>
        </form>
    </div>

</x-layout>
=======
    // Add glow effect to input fields when focused
    document.querySelectorAll('.input-field input').forEach(input => {
        input.addEventListener('focus', () => {
            input.previousElementSibling.classList.add('glow');
        });
        input.addEventListener('blur', () => {
            input.previousElementSibling.classList.remove('glow');
        });
    });
    
    // Remove birthday validation code
    document.addEventListener('DOMContentLoaded', function() {
        const birthdayInput = document.getElementById('birthday');
        
        // Add standard event listener for all inputs including birthday
        document.querySelectorAll('.input-field input').forEach(input => {
            input.addEventListener('focus', () => {
                input.previousElementSibling.classList.add('glow');
            });
            input.addEventListener('blur', () => {
                input.previousElementSibling.classList.remove('glow');
            });
        });
    });
</script>
</body>
</html>
>>>>>>> Stashed changes
