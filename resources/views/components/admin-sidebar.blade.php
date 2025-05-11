@props(['activePage' => ''])

<!-- Desktop Sidebar -->
<div class="sidebar">
    <div class="logo-section">
        <img src="{{ asset('images/mainlogo.png') }}" alt="Recyclo Logo">
        <h2>Recyclo Admin</h2>
    </div>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $activePage == 'dashboard' ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.orders') }}" class="nav-link {{ $activePage == 'orders' ? 'active' : '' }}">
            <i class="bi bi-cart"></i> Orders
        </a>
        <a href="{{ route('admin.users') }}" class="nav-link {{ $activePage == 'users' ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('admin.post.requests') }}" class="nav-link {{ $activePage == 'post-requests' ? 'active' : '' }}">
            <i class="bi bi-file-earmark-plus"></i> Post Requests
            @if(App\Models\Post::where('status', App\Models\Post::STATUS_PENDING)->count() > 0)
                <span class="badge" style="background-color: #FF6B6B; color: white; margin-left: 5px; border-radius: 50%; padding: 3px 8px;">
                    {{ App\Models\Post::where('status', App\Models\Post::STATUS_PENDING)->count() }}
                </span>
            @endif
        </a>
        <a href="{{ route('admin.products') }}" class="nav-link {{ $activePage == 'products' ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Products
        </a>
        <a href="{{ route('admin.shops') }}" class="nav-link {{ $activePage == 'shops' ? 'active' : '' }}">
            <i class="bi bi-shop"></i> Shops
        </a>
        <a href="{{ route('admin.reports') }}" class="nav-link {{ $activePage == 'reports' ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Reports
        </a>
        <a href="javascript:void(0)" class="nav-link" onclick="confirmLogout()">
            <i class="bi bi-box-arrow-right"></i> Logout
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
        overflow-y: auto;
        z-index: 1000;
        left: 0;
        top: 0;
    }

    .logo-section {
        display: flex;
        align-items: center;
        margin-bottom: 40px;
        padding: 20px 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .logo-section img {
        width: 45px;
        height: 45px;
        margin-right: 15px;
    }

    .logo-section h2 {
        font-size: 1.5rem;
        margin: 0;
        font-weight: 600;
    }

    .nav-link {
        color: white;
        text-decoration: none;
        padding: 12px 15px;
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .nav-link i {
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .nav-link:hover, .nav-link.active {
        background: rgba(255,255,255,0.2);
        transform: translateX(5px);
    }

    @media screen and (max-width: 768px) {
        .sidebar {
            display: none;
        }
    }
</style>

<script>
    function confirmLogout() {
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
                window.location.href = "{{ route('logout') }}";
            }
        });
    }
</script> 