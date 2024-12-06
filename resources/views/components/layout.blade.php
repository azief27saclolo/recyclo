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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
              <input type="search" name="search" placeholder="Search product" class="search-field">
              <button class="search-submit" aria-label="search">
                <ion-icon name="search" aria-hidden="true"></ion-icon>
              </button>
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
                {{-- Dropdown Button --}}
              <button @click="open = !open" type="button" class="header-action-btn" aria-label="user">
                <ion-icon name="person" aria-hidden="true" aria-hidden="true" class="text-3xl cursor-pointer mr-[10px]" onclick="onToggleMenu(this)"></ion-icon>
              </button>

              {{-- Dropdown Menu --}}
              <div x-show="open" @click.outside="open = false" class="bg-white shadow-lg absolute z-10 top-20 right-30 rounded-lg overflow-hidden font-light">
                    
                @auth
                    <p class="username">Hello! {{ auth()->user()->username }}</p>                  
                @endauth
                @guest
                <a class="block hover:text-green-200 pl-4 pr-8 py-2 mb-1" href="{{ route('login') }}">Login</a>
                <a class="block hover:text-green-200 pl-4 pr-8 py-2 mb-1" href="{{ route('register') }}">Register</a>
                @endguest
                @auth                       
                    <a href="{{ route('dashboard') }}" class="block hover:text-green-200 pl-4 pr-8 py-2 mb-1">Profile</a>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="block hover:text-green-200 pl-4 pr-8 py-2 mb-1">Logout</button>
                    </form>
                @endauth
            </div>

              <button class="header-action-btn" aria-label="heart item">
                <ion-icon name="heart" aria-hidden="true" aria-hidden="true"></ion-icon>
                <span class="btn-badge">0</span>
              </button>
              <button class="header-action-btn" aria-label="cart item">
                <ion-icon name="cart" aria-hidden="true" aria-hidden="true"></ion-icon>
                <span class="btn-badge">0</span>
              </button>
            </div>
            
            <nav class="navbar">
              <ul class="navbar-list">
                <li>
                  <a href="{{ route('posts') }}" class="navbar-link has-after">Home</a>
                </li>
                <li>
                  <a href="#collection" class="navbar-link has-after">About Us</a>
                </li>
                <li>
                  <a href="#collection" class="navbar-link has-after">Categories</a>
                </li>
                <li>
                  <a href="#collection" class="navbar-link has-after">Goals</a>
                </li>
                <li>
                  <a href="#shop" class="navbar-link has-after">Shops</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </header>

    <main>
        {{ $slot }}
    </main>

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