@props(['activePage' => ''])

{{-- Include all dependencies from layout.blade.php --}}
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite(['resources/css/app.css', 'resources/css/style.css', 'resources/css/login.css', 'resources/js/app.js'])

<!-- Mobile Navigation -->
<nav class="mobile-nav">
    <img src="{{ asset('images/recyclo-logo.png') }}" alt="Recyclo Logo" style="height: 30px;">
    <button class="burger-menu" id="burgerMenu" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <img src="{{ asset('images/mainlogo.png') }}" alt="Recyclo Logo">
        <h2>Recyclo</h2>
    </div>
    <nav>
        <a href="{{ url('/') }}" class="menu-item {{ $activePage == 'home' ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('profile') }}" class="menu-item {{ $activePage == 'profile' ? 'active' : '' }}">
            <i class="bi bi-person"></i>
            <span>Profile</span>
        </a>
        
        <a href="{{ route('sell.item') }}" class="menu-item {{ $activePage == 'sell-item' ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i>
            <span>Sell an Item</span>
        </a>
        
        @if(Auth::user()->shop && Auth::user()->shop->status === 'approved')
            <a href="{{ route('shop.dashboard') }}" class="menu-item {{ $activePage == 'shop' ? 'active' : '' }}">
                <i class="bi bi-shop"></i>
                <span>My Shop</span>
            </a>
        @else
            <a href="{{ route('shop.register') }}" class="menu-item {{ $activePage == 'shop-register' ? 'active' : '' }}">
                <i class="bi bi-person-check-fill"></i>
                <span>Register a Shop</span>
            </a>
        @endif
        
        <a href="{{ route('buy.index') }}" class="menu-item {{ $activePage == 'buy-requests' ? 'active' : '' }}">
            <i class="bi bi-bag"></i>
            <span>Buy Requests</span>
        </a>
        
        <a href="{{ route('orders.index') }}" class="menu-item {{ $activePage == 'orders' ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>My Orders</span>
        </a>
        
        <a href="#" class="menu-item {{ $activePage == 'privacy' ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i>
            <span>Privacy Settings</span>
        </a>
        
        <a href="#" class="menu-item logout-item" onclick="confirmLogout(event)">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </nav>
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>

<!-- Desktop Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/mainlogo.png') }}" alt="Recyclo Logo">
        <h2>Recyclo</h2>
    </div>
    <nav>
        <a href="{{ url('/') }}" class="menu-item {{ $activePage == 'home' ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('profile') }}" class="menu-item {{ $activePage == 'profile' ? 'active' : '' }}">
            <i class="bi bi-person"></i>
            <span>Profile</span>
        </a>
        
        <a href="{{ route('sell.item') }}" class="menu-item {{ $activePage == 'sell-item' ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i>
            <span>Sell an Item</span>
        </a>
        
        @if(Auth::user()->shop && Auth::user()->shop->status === 'approved')
            <a href="{{ route('shop.dashboard') }}" class="menu-item {{ $activePage == 'shop' ? 'active' : '' }}">
                <i class="bi bi-shop"></i>
                <span>My Shop</span>
            </a>
        @else
            <a href="{{ route('shop.register') }}" class="menu-item {{ $activePage == 'shop-register' ? 'active' : '' }}">
                <i class="bi bi-person-check-fill"></i>
                <span>Register a Shop</span>
            </a>
        @endif
        
        <a href="{{ route('buy.index') }}" class="menu-item {{ $activePage == 'buy-requests' ? 'active' : '' }}">
            <i class="bi bi-bag"></i>
            <span>Buy Requests</span>
        </a>
        
        <a href="{{ route('orders.index') }}" class="menu-item {{ $activePage == 'orders' ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>My Orders</span>
        </a>
        
        <a href="#" class="menu-item {{ $activePage == 'privacy' ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i>
            <span>Privacy Settings</span>
        </a>
        
        <a href="#" class="menu-item logout-item" onclick="confirmLogout(event)">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </nav>
</div>

<form action="{{ route('logout') }}" method="GET" id="logout-form" style="display: none;">
</form>

<style>
    /* Desktop Sidebar Styles */
    .sidebar {
        width: 250px;
        background: var(--hoockers-green);
        padding: 20px;
        color: white;
        position: fixed;
        height: 100vh;
        z-index: 1000;
        transition: transform 0.3s ease;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar-header img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .sidebar-header h2 {
        margin: 0;
        font-size: 22px;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 5px;
        transition: all 0.3s ease;
    }

    .menu-item:hover, .menu-item.active {
        background: rgba(255,255,255,0.1);
        transform: translateX(5px);
    }

    .menu-item i {
        margin-right: 10px;
        font-size: 18px;
    }

    .logout-item {
        color: #dc3545 !important;
    }

    /* Mobile Navigation Styles */
    .mobile-nav {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 60px;
        background-color: var(--hoockers-green);
        padding: 0 15px;
        z-index: 1001;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .burger-menu {
        display: none;
        cursor: pointer;
        padding: 15px;
        margin: -15px;
        z-index: 1002;
        background: none;
        border: none;
        outline: none;
        position: relative;
    }

    .burger-menu span {
        display: block;
        width: 25px;
        height: 3px;
        background-color: white;
        margin: 5px 0;
        transition: all 0.3s ease;
        transform-origin: center;
    }

    .mobile-menu {
        display: none;
        position: fixed;
        top: 0;
        left: -100%;
        width: 80%;
        max-width: 300px;
        height: 100vh;
        background-color: var(--hoockers-green);
        padding: 60px 20px 20px;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        transition: left 0.3s ease;
        z-index: 1000;
        color: white;
        overflow-y: auto;
    }

    .mobile-menu.active {
        left: 0;
    }

    .mobile-menu-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .mobile-menu-header img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .mobile-menu-header h2 {
        margin: 0;
        font-size: 22px;
        color: white;
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
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .overlay.active {
        display: block;
        opacity: 1;
    }

    /* Burger Menu Animation */
    .burger-menu.active span:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
    }

    .burger-menu.active span:nth-child(2) {
        opacity: 0;
    }

    .burger-menu.active span:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
    }

    /* Mobile Responsive Styles */
    @media screen and (max-width: 768px) {
        .sidebar {
            display: none;
        }

        .mobile-nav {
            display: flex;
        }

        .burger-menu {
            display: block;
        }

        .mobile-menu {
            display: block;
        }

        .main-content {
            margin-left: 0 !important;
            padding-top: 60px !important;
        }
    }

    /* Additional breakpoint for very small devices */
    @media screen and (max-width: 360px) {
        .mobile-menu {
            width: 100%;
            max-width: none;
        }

        .mobile-menu .menu-item {
            padding: 12px;
            font-size: 15px;
        }

        .mobile-menu .menu-item i {
            font-size: 18px;
            margin-right: 12px;
        }
    }

    /* SweetAlert2 custom styles for larger modals */
    .swal2-popup.swal2-modal.bigger-modal {
        width: 32em !important;
        max-width: 90% !important;
        font-size: 1.2rem !important;
        padding: 2em !important;
    }
    
    .swal2-popup.swal2-modal.bigger-modal .swal2-title {
        font-size: 1.8em !important;
        margin-bottom: 0.5em !important;
    }
    
    .swal2-popup.swal2-modal.bigger-modal .swal2-content,
    .swal2-popup.swal2-modal.bigger-modal .swal2-html-container {
        font-size: 1.1em !important;
        line-height: 1.5 !important;
    }
    
    .swal2-popup.swal2-modal.bigger-modal .swal2-confirm,
    .swal2-popup.swal2-modal.bigger-modal .swal2-cancel {
        font-size: 1.1em !important;
        padding: 0.6em 1.5em !important;
    }

    /* Update mobile menu styles for better touch targets */
    .mobile-menu .menu-item {
        padding: 15px;
        margin-bottom: 8px;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    .mobile-menu .menu-item:active {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .mobile-menu .menu-item i {
        width: 24px;
        text-align: center;
        margin-right: 12px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const burgerMenu = document.getElementById('burgerMenu');
        const mobileMenu = document.getElementById('mobileMenu');
        const overlay = document.getElementById('overlay');
        const body = document.body;

        function toggleMenu() {
            burgerMenu.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            overlay.classList.toggle('active');
            
            if (mobileMenu.classList.contains('active')) {
                body.style.overflow = 'hidden';
            } else {
                body.style.overflow = '';
            }
        }

        if (burgerMenu) {
            burgerMenu.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMenu();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                toggleMenu();
            });
        }

        const menuItems = mobileMenu.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                if (!this.classList.contains('logout-item')) {
                    const href = this.getAttribute('href');
                    if (href && href !== '#') {
                        toggleMenu();
                        window.location.href = href;
                    }
                }
            });
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && mobileMenu.classList.contains('active')) {
                toggleMenu();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                toggleMenu();
            }
        });
    });

    function confirmLogout(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Logout Confirmation',
            text: "Do you really want to logout?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#517A5B',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'No, stay',
            customClass: {
                popup: 'bigger-modal'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
