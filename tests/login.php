<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup - Recyclo</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="login-body">
    <div class="login-container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Login Form -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="sign-in-form">
                    <img src="./assets/images/mainlogo.png" alt="Recyclo Logo" class="login-logo">
                    <h2 class="title">Sign in to Recyclo</h2>
                    <?php if ($error): ?>
                        <script>
                            Swal.fire({
                                title: 'Error!',
                                text: '<?php echo $error; ?>',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        </script>
                    <?php endif; ?>
                    <div class="input-field">
                        <i class="bi bi-person-fill"></i>
                        <input type="email" name="email" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    <input type="submit" name="login" value="Login" class="btn solid" />
                    
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

                <!-- Sign Up Form -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="sign-up-form" id="signupForm">
                    <img src="./assets/images/mainlogo.png" alt="Recyclo Logo" class="login-logo">
                    <h2 class="title">Join Recyclo</h2>
                    <div class="input-field">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="username" placeholder="Username" required />
                    </div>
                    <div class="input-field">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="bi bi-calendar-fill"></i>
                        <input type="date" name="birthday" placeholder="Birthday" required />
                    </div>
                    <div class="input-field">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" placeholder="Password" id="password" required />
                    </div>
                    <div class="input-field">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm-password" required />
                    </div>
                    <span class="password-error"></span>
                    <div class="terms-checkbox">
                        <input type="checkbox" id="terms" required>
                        <label for="terms">I agree to the Terms & Conditions</label>
                    </div>
                    <input type="submit" name="signup" class="btn" value="Sign up" />
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New to Recyclo?</h3>
                    <p>Join our community of eco-conscious buyers and sellers. Turn waste into opportunity!</p>
                    <button class="btn transparent" id="sign-up-btn">Sign up</button>
                </div>
                <img src="./assets/images/reduce.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Already a member?</h3>
                    <p>Sign in to continue your journey in making the world a better place, one recycled item at a time.</p>
                    <button class="btn transparent" id="sign-in-btn">Sign in</button>
                </div>
                <img src="./assets/images/recycle.svg" class="image" alt="" />
            </div>
        </div>
    </div>
    <script src="./assets/js/login.js"></script>
    <script>
    document.getElementById('signupForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('signup_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'Login'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'login.php';
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
    </script>
</body>
</html>