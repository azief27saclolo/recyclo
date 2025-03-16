<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Profile - Recyclo</title>
    
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
    <link rel="preload" as="image" href="images/sss.jpg">
    <link rel="preload" as="image" href="images/mm.jpg">
    <link rel="preload" as="image" href="images/bboo.jpg">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/css/login.css', 'resources/js/app.js'])
    
    <!-- SweetAlert for logout confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .profile-container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

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

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 40px;
        }

        .profile-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .profile-header h1 {
            margin: 0;
            color: var(--hoockers-green);
            font-size: 28px;
            margin-bottom: 20px;
        }

        .profile-info {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .info-group {
            margin-bottom: 25px;
        }

        .info-group label {
            display: block;
            color: #666;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .info-group .value {
            color: #333;
            font-size: 16px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .edit-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }

        .edit-btn:hover {
            background: #3c5c44; /* Direct hex color instead of variable */
            color: white !important; /* Force white text on hover */
            transform: translateY(-2px); /* Add subtle lift effect */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Add shadow for better look */
        }

        .profile-picture-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 15px;
            border: 3px solid var(--hoockers-green);
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-icon {
            font-size: 100px;
            color: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .activity-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .stat-box {
            flex: 1;
            text-align: center;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 0 5px;
        }

        .stat-number {
            font-size: 26px;
            font-weight: bold;
            color: var(--hoockers-green);
        }

        .stat-label {
            font-size: 13px;
            color: #666;
        }

        #editProfileForm {
            display: none;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--hoockers-green);
            outline: none;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/mainlogo.png') }}" alt="Recyclo Logo">
                <h2>Recyclo</h2>
            </div>
            <nav>
                <a href="{{ url('/') }}" class="menu-item">
                    <i class="bi bi-house-door"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('profile') }}" class="menu-item active">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
                
                @if(Auth::user()->shop && Auth::user()->shop->status === 'approved')
                    <a href="{{ route('shop.dashboard') }}" class="menu-item">
                        <i class="bi bi-shop"></i>
                        <span>My Shop</span>
                    </a>
                @else
                    <a href="{{ route('shop.register') }}" class="menu-item">
                        <i class="bi bi-person-check-fill"></i>
                        <span>Register a Shop</span>
                    </a>
                @endif
                
                <a href="#" class="menu-item">
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

        <!-- Main Content -->
        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="profile-header">
                <h1>My Profile</h1>
                <p>Manage your personal information and account settings</p>
            </div>

            <!-- Profile Information -->
            <div class="profile-info">
                <div class="profile-picture-container">
                    <div class="profile-picture">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture">
                        @else
                            <div class="profile-icon">
                                <ion-icon name="person"></ion-icon>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="info-group">
                    <label>Username</label>
                    <div class="value">{{ auth()->user()->username }}</div>
                </div>

                <div class="info-group">
                    <label>Name</label>
                    <div class="value">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</div>
                </div>

                <div class="info-group">
                    <label>Location</label>
                    <div class="value">{{ auth()->user()->location }}</div>
                </div>

                <div class="info-group">
                    <label>Member Since</label>
                    <div class="value">{{ auth()->user()->created_at->format('F j, Y') }}</div>
                </div>

                <button id="showEditForm" class="edit-btn">
                    <i class="bi bi-pencil"></i> Edit Profile
                </button>
            </div>

            <!-- Edit Profile Form (Initially Hidden) -->
            <div id="editProfileForm" class="profile-info">
                <h3>Edit Your Profile</h3>
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="info-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" name="profile_picture" class="form-control">
                        @error('profile_picture')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="info-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" value="{{ auth()->user()->username }}" class="form-control">
                        @error('username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="info-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="info-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" value="{{ auth()->user()->location }}" class="form-control">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="edit-btn" style="margin-bottom: 15px;">Update Profile</button>
                    <button type="button" id="cancelEdit" class="edit-btn" style="background-color: #dc3545; margin-left: 10px;">Cancel</button>
                </form>
            </div>

            <!-- Activity Overview -->
            <div class="profile-info">
                <h3 style="margin-bottom: 20px; color: var(--hoockers-green);">Activity Overview</h3>
                <div class="activity-stats">
                    <div class="stat-box">
                        <div class="stat-number">{{ auth()->user()->posts()->count() }}</div>
                        <div class="stat-label">Listings</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ auth()->user()->soldOrders()->count() }}</div>
                        <div class="stat-label">Sold Items</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const showEditFormBtn = document.getElementById('showEditForm');
        const cancelEditBtn = document.getElementById('cancelEdit');
        const editProfileForm = document.getElementById('editProfileForm');
        
        showEditFormBtn.addEventListener('click', function() {
            editProfileForm.style.display = 'block';
            showEditFormBtn.style.display = 'none';
        });
        
        cancelEditBtn.addEventListener('click', function() {
            editProfileForm.style.display = 'none';
            showEditFormBtn.style.display = 'inline-block';
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
            cancelButtonText: 'No, stay'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
    </script>
</body>
</html>
