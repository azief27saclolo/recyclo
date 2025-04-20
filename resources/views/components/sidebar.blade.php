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
        <form action="{{ route('logout') }}" method="GET" id="logout-form" style="display: none;">
        </form>
        <a href="#" class="menu-item" style="color: #dc3545;" onclick="confirmLogout(event)">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </nav>
</div>

<style>
    .sidebar {
        width: 250px;
        background: var(--hoockers-green);
        padding: 20px;
        color: white;
        position: fixed;
        height: 100vh;
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
</style>

<script>
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
