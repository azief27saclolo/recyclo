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
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            font-family: 'Urbanist', sans-serif;
        }
        
        .page-container {
            display: flex;
            min-height: 100vh;
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

        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box; /* Ensures padding is included in width */
        }
        
        .form-control:focus {
            border-color: var(--hoockers-green);
            outline: none;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow: auto;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            margin: auto;
            padding: 25px;
            border-radius: 15px;
            width: 95%;
            max-width: 600px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: modalAnimation 0.3s ease;
        }

        @keyframes modalAnimation {
            from {opacity: 0; transform: translateY(-30px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #777;
            transition: color 0.3s;
        }

        .close-modal:hover {
            color: #333;
        }

        .modal-header {
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
            padding-bottom: 15px;
        }

        .modal-header h3 {
            margin: 0;
            color: var(--hoockers-green);
            font-size: 22px;
        }
        
        /* Adjust form layout in modal */
        .modal .info-group {
            margin-bottom: 20px;
            padding: 0; /* Remove horizontal padding */
            width: 100%; /* Ensure full width */
        }
        
        .modal form {
            width: 100%;
            padding: 0;
        }
        
        /* Make input fields take full width */
        .modal .form-control {
            width: 100%;
            display: block;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <!-- Sidebar component - properly positioned -->
        <x-sidebar activePage="profile" />

        <!-- Main Content -->
        <div class="main-content">
            
            <div class="profile-header">
                <h1>My Profile</h1>
                <p>Manage your personal information and account settings</p>
            </div>

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
                    <label>Contact Number</label>
                    <div class="value">{{ auth()->user()->number ?? 'Not provided' }}</div>
                </div>

                <div class="info-group">
                    <label>Member Since</label>
                    <div class="value">{{ auth()->user()->created_at->format('F j, Y') }}</div>
                </div>

                <button id="showEditForm" class="edit-btn">
                    <i class="bi bi-pencil"></i> Edit Profile
                </button>
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

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <h3>Edit Your Profile</h3>
            </div>
            <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" style="width: 100%;">
                @csrf
                @method('PUT')

                <div class="info-group" style="width: 100%;">
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

                <div class="info-group">
                    <label for="number">Contact Number</label>
                    <input type="text" name="number" value="{{ auth()->user()->number }}" class="form-control">
                    @error('number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="info-group">
                    <button type="submit" class="edit-btn" style="width: 100%; margin-bottom: 15px;">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('editProfileModal');
        const showEditFormBtn = document.getElementById('showEditForm');
        const closeModalBtn = document.querySelector('.close-modal');
        
        // Check for success message in session and show popup
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'OK'
            });
        @endif
        
        showEditFormBtn.addEventListener('click', function() {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        });
        
        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Enable scrolling again
        }
        
        closeModalBtn.addEventListener('click', closeModal);
        
        // Close modal when clicking outside of it
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.style.display === 'flex') {
                closeModal();
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
