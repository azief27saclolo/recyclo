<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preload" as="image" href="images/logo.png">
    <link rel="preload" as="image" href="images/sss.jpg">
    <link rel="preload" as="image" href="images/mm.jpg">
    <link rel="preload" as="image" href="images/bboo.jpg">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/css/login.css', 'resources/js/app.js'])
    <style>
        .btn-badge {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--accent, #ff6b6b);
            color: white;
            width: 20px;
            height: 20px;
            font-size: 12px;
            border-radius: 50%;
            line-height: 1;
            text-align: center;
        }
        
        .header-action-btn {
            position: relative;
        }
    </style>
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="top">
    <header class="header">
        <div class="header-top" data-header>
          <div class="container">
            <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
              <span class="line line-1"></span>
              <span class="line line-2"></span>
              <span class="line line-3"></span>
            </button>
            <div class="input-wrapper">
              <form action="{{ route('search') }}" method="GET">
                <input type="search" name="query" placeholder="Search product" class="search-field">
                <button type="submit" class="search-submit" aria-label="search">
                  <ion-icon name="search" aria-hidden="true"></ion-icon>
                </button>
              </form>
            </div>
            
            <a href="{{ route('landingpage') }}">
                <div style="display: flex; align-items: center;">
                    <img src="{{ asset('images/mainlogo.png') }}" alt="Logo" style="width: 50px; height: 50px; flex-shrink: 0; margin-right: 10px;">
                    <div style="flex-grow: 1; text-align: center;">
                        <h1 style="color: green; margin: 0;">Recyclo</h1>
                    </div>
                </div>
            </a>
          
            <div class="header-actions" x-data="{ open: false }">
                @auth
                    {{-- Direct link to profile for logged in users (replacing dropdown) --}}
                    <a href="{{ route('profile') }}" class="header-action-btn" aria-label="user profile">
                        <ion-icon name="person" aria-hidden="true" class="text-3xl cursor-pointer mr-[10px]"></ion-icon>
                    </a>
                @else
                    {{-- Direct link to login for non-logged in users --}}
                    <a href="{{ route('login') }}" class="header-action-btn" aria-label="user">
                        <ion-icon name="person" aria-hidden="true" class="text-3xl cursor-pointer mr-[10px]"></ion-icon>
                    </a>
                @endauth

              <button class="header-action-btn" aria-label="heart item" onclick="window.location.href='{{ route('favorites') }}'">
                <ion-icon name="heart" aria-hidden="true"></ion-icon>
                <span class="btn-badge">{{ Auth::check() ? Auth::user()->favorites->count() : 0 }}</span>
              </button>
              <a href="{{ route('cart.index') }}" class="header-action-btn" aria-label="cart item">
                <ion-icon name="cart" aria-hidden="true"></ion-icon>
                <span class="btn-badge">
                    @php
                        $cartCount = 0;
                        if(Auth::check()) {
                            $cart = App\Models\Cart::where('user_id', Auth::id())
                                ->where('status', 'active')
                                ->first();
                            if($cart) {
                                $cartCount = App\Models\CartItem::where('cart_id', $cart->id)
                                    ->sum('quantity');
                            }
                        }
                    @endphp
                    {{ $cartCount }}
                </span>
              </a>
            </div>
            
            <nav class="navbar">
              <ul class="navbar-list">
                <li>
                  <a href="{{ route('posts') }}" class="navbar-link has-after">Selling</a>
                </li>
                <li>
                  <a href="{{ route('buy.marketplace') }}" class="navbar-link has-after">Buying</a>
                </li>
                <li>
                  <a href="#collection" class="navbar-link has-after">About Us</a>
                </li>
                <li>
                  <a href="{{ route('orders.index') }}" class="navbar-link has-after">My Orders</a>
                </li>
                <li>
                  <a href="#collection" class="navbar-link has-after">Goals</a>
                </li>
                <li>
                  <a href="{{ route('shops') }}" class="navbar-link has-after">Shops</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
      <div class="container">
        <div class="footer-top">
          <ul class="footer-list">
            <li>
              <p class="footer-list-title"><i class="bi bi-link-45deg"></i> Recyclo Links</p>
            </li>
            <li>
              <p class="footer-list-text">
                <i class="bi bi-facebook"></i>   <a href="#" class="link">Recyclo</a>
              </p>
            </li>
            <br>
            <li>
              <p class="footer-list-text">
                <i class="bi bi-instagram"></i>   <a href="#" class="link">@RecycloEst2024</a>
              </p>
            </li>
            <br>
            <li>
              <p class="footer-list-text">
                <i class="bi bi-twitter"></i>   <a href="#" class="link">RecycloEst2024</a>
              </p>
            </li>
          </ul>
  
          <ul class="footer-list">
  
            <li>
              <p class="footer-list-title">Shops</p>
            </li>
  
            <li>
              <a href="#" class="footer-link">New Products</a>
            </li>
  
            <li>
              <a href="#" class="footer-link">Best Sellers</a>
            </li>
  
          </ul>
  
          <ul class="footer-list">
            <li>
              <p class="footer-list-title"><i class="bi bi-info-circle"></i> Infomation</p>
            </li>
            <li>
              <a href="#" class="footer-link">About Us</a>
            </li>
            <li>
              <a href="#" class="footer-link">Start a Return</a>
            </li>
  
            <li>
              <a href="#" class="footer-link">Contact Us</a>
            </li>
  
            <li>
              <a href="#" class="footer-link">Shipping FAQ</a>
            </li>
  
            <li>
              <a href="#" class="footer-link">Terms & Conditions</a>
            </li>
  
            <li>
              <a href="#" class="footer-link">Privacy Policy</a>
            </li>
  
          </ul>
  
          <div class="footer-list">
  
            <p class="newsletter-title">Good emails.</p>
  
            <p class="newsletter-text">
              Enter your email below to be the first to know about new collections and product launches.
            </p>
  
            <form action="" class="newsletter-form">
              <input type="email" name="email_address" placeholder="Enter your email address" required
                class="email-field">
  
              <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
  
          </div>
  
        </div>
  
        <div class="footer-bottom">
  
          <div class="wrapper">
            <p class="copyright">
              &copy; 2024 Recyclo
            </p>
  
            <ul class="social-list">
  
              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-twitter"></ion-icon>
                </a>
              </li>
  
              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-facebook"></ion-icon>
                </a>
              </li>
  
              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-instagram"></ion-icon>
                </a>
              </li>
  
              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-youtube"></ion-icon>
                </a>
              </li>
  
            </ul>
          </div>
  
          <div style="display: flex; align-items: center;">
            <img src="./assets/images/mainlogo.png" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px;">
            <h1 style="color: black; margin: 0;"></h1>
        </div>
  
          <img src="./assets/images/p.png" width="313" height="28" alt="available all payment method" class="w-100">
  
        </div>
  
      </div>
    </footer>

    <script>
        // Set form: x-data="formSubmit" @submit.prevent="submit" and button: x-ref="btn"
        document.addEventListener('alpine:init', () => {
            Alpine.data('formSubmit', () => ({
                submit() {
                    this.$refs.btn.disabled = true;
                    this.$refs.btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                    this.$refs.btn.classList.add('bg-indigo-400');
                    this.$refs.btn.innerHTML =
                        `<span class="absolute left-2 top-1/2 -translate-y-1/2 transform">
                        <i class="fa-solid fa-spinner animate-spin"></i>
                        </span>Please wait...`;

                    this.$el.submit()
                }
            }))
        })
    </script>
    {{-- <script src="script.js" defer></script> --}}
</body>
</html>