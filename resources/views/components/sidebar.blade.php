@props(['activePage' => ''])

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
            cancelButtonText: 'No, stay'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
