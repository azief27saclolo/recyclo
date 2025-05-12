<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Profile - Recyclo</title>
    
    <!-- Required imports -->
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
    
    <!-- OpenStreetMap Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <!-- Leaflet Control Geocoder for search functionality -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/css/login.css', 'resources/js/app.js'])
    
    <!-- SweetAlert for logout confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-color: #517A5B;
            --secondary-color: #3c5c44;
            --accent-color: #8BA888;
            --background-color: #f8f9fa;
            --text-color: #333;
            --text-light: #666;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
            font-family: 'Urbanist', sans-serif;
            color: var(--text-color);
        }
        
        .page-container {
            display: flex;
            min-height: 100vh;
            background-color: var(--background-color);
        }

        .main-content {
            flex: 1;
            padding: 40px;
            margin-left: 250px; /* Match sidebar width */
            max-width: calc(100% - 250px); /* Account for sidebar */
            min-height: 100vh;
            background-color: var(--background-color);
        }

        .profile-header {
            background: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 120px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            z-index: 0;
        }

        .profile-header h1 {
            margin: 0;
            color: white;
            font-size: 32px;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .profile-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            position: relative;
            z-index: 1;
        }

        .profile-content {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
            margin-top: -60px;
            position: relative;
            z-index: 2;
        }

        .profile-sidebar {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            height: fit-content;
        }

        .profile-main {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            min-height: 500px;
        }

        .profile-picture-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-picture {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 4px solid white;
            box-shadow: var(--box-shadow);
            position: relative;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-icon {
            font-size: 120px;
            color: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background: #f8f9fa;
        }

        .info-group {
            margin-bottom: 25px;
        }

        .info-group label {
            display: block;
            color: var(--text-light);
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .info-group .value {
            color: var(--text-color);
            font-size: 16px;
            padding: 12px;
            background: var(--background-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
        }

        .info-group .value i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .edit-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
        }

        .edit-btn i {
            margin-right: 8px;
        }

        .edit-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .activity-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .stat-box {
            background: white;
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            text-align: center;
            transition: var(--transition);
        }

        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-light);
            font-weight: 500;
        }

        .section-title {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--background-color);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            overflow: auto;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            margin: 30px auto;
            padding: 0;
            border-radius: 16px;
            width: 95%;
            max-width: 700px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: modalAnimation 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
        }

        @keyframes modalAnimation {
            from {opacity: 0; transform: scale(0.9) translateY(-20px);}
            to {opacity: 1; transform: scale(1) translateY(0);}
        }

        .close-modal {
            position: absolute;
            top: 24px;
            right: 24px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            color: #fff;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transition: var(--transition);
            z-index: 5;
        }

        .close-modal:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-header {
            margin: 0;
            padding: 35px 40px 30px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            position: relative;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .modal-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20px;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(-50%, 50%);
        }

        .modal-header h3 {
            margin: 0;
            color: white;
            font-size: 28px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .modal-header p {
            margin: 8px 0 0;
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            position: relative;
            z-index: 1;
        }

        .modal-body {
            padding: 30px 40px 40px;
        }

        .form-tabs {
            display: flex;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            position: relative;
        }

        .form-tab {
            padding: 12px 20px;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-light);
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 3px solid transparent;
            display: flex;
            align-items: center;
        }

        .form-tab i {
            margin-right: 8px;
            font-size: 18px;
        }

        .form-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .form-tab:hover:not(.active) {
            color: var(--text-color);
            border-bottom-color: #ddd;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(10px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .profile-upload-container {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-upload-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #eee;
            position: relative;
            flex-shrink: 0;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-upload-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-upload-preview .profile-icon {
            font-size: 60px;
            color: #ccc;
        }

        .profile-upload-info {
            margin-left: 20px;
        }

        .profile-upload-label {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 10px;
            font-weight: 500;
            font-size: 14px;
        }
        
        .profile-upload-label:hover {
            background-color: var(--secondary-color);
        }

        .profile-upload-info p {
            font-size: 13px;
            color: var(--text-light);
            margin: 0;
        }

        .profile-picture-input {
            position: absolute;
            width: 0;
            height: 0;
            overflow: hidden;
            opacity: 0;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: var(--text-color);
            margin-bottom: 8px;
            font-size: 15px;
            font-weight: 600;
        }

        .form-input {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 14px 16px;
            width: 100%;
            font-size: 15px;
            transition: var(--transition);
            color: var(--text-color);
        }

        .form-input:focus {
            border-color: var(--primary-color);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(81, 122, 91, 0.1);
            outline: none;
        }

        .form-input-icon {
            position: relative;
        }

        .form-input-icon input {
            padding-left: 42px;
        }

        .form-input-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            transition: var(--transition);
        }

        .form-input-icon input:focus + i {
            color: var(--primary-color);
        }

        .search-container {
            position: relative;
            margin-bottom: 15px;
        }

        .loader {
            display: none;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translateY(-50%) rotate(0deg); }
            100% { transform: translateY(-50%) rotate(360deg); }
        }

        .search-results {
            display: none;
            position: absolute;
            left: 0;
            right: 0;
            top: 100%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
        }

        .search-result-item {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: var(--transition);
            font-size: 14px;
            }

        .search-result-item:hover {
            background-color: #f9f9f9;
            }

        .search-result-item:last-child {
            border-bottom: none;
            }

        .selected-location {
            background-color: #f9f9f9;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 15px;
            margin-bottom: 15px;
            color: var(--text-color);
        }

        #map-container {
            height: 250px;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #eee;
            margin-bottom: 15px;
            }

        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            font-weight: 500;
            }

        .submit-btn {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 16px 25px;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            margin-top: 15px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn i {
            margin-right: 10px;
            font-size: 18px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(0,0,0,0.1);
        }

        .submit-btn:after {
            content: '';
            position: absolute;
            width: 30px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            transform: rotate(45deg);
            left: -85px;
            animation: shine 3s ease-in-out infinite;
        }

        @keyframes shine {
            0% { left: -85px; }
            20% { left: 120%; }
            100% { left: 120%; }
        }

        /* Mobile Responsive Styles for Modal */
        @media screen and (max-width: 768px) {
            .modal-content {
                width: 95%;
                margin: 20px auto;
            }
            
            .modal-header,
            .modal-body {
                padding: 25px;
            }

            .profile-upload-container {
                flex-direction: column;
                text-align: center;
            }

            .profile-upload-info {
                margin-left: 0;
                margin-top: 15px;
            }
            
            .form-tabs {
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 5px;
            }

            .form-tab {
                padding: 10px 15px;
                font-size: 14px;
            }
        }

        @media screen and (max-width: 480px) {
            .modal-header h3 {
                font-size: 22px;
            }
            
            .modal-header,
            .modal-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <!-- Sidebar component -->
        <x-sidebar activePage="profile" />

        <!-- Main Content -->
        <div class="main-content">
            <div class="profile-header">
                <h1>My Profile</h1>
                <p>Manage your personal information and account settings</p>
            </div>

            <div class="profile-content">
                <div class="profile-sidebar">
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
                        <button id="showEditForm" class="edit-btn">
                            <i class="bi bi-pencil"></i> Edit Profile
                        </button>
                </div>

                <div class="info-group">
                    <label>Username</label>
                        <div class="value">
                            <i class="bi bi-person"></i>
                            {{ auth()->user()->username }}
                        </div>
                </div>

                <div class="info-group">
                    <label>Name</label>
                        <div class="value">
                            <i class="bi bi-person-badge"></i>
                            {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                        </div>
                </div>

                <div class="info-group">
                    <label>Location</label>
                        <div class="value">
                            <i class="bi bi-geo-alt"></i>
                            {{ auth()->user()->location }}
                        </div>
                </div>

                <div class="info-group">
                    <label>Contact Number</label>
                        <div class="value">
                            <i class="bi bi-telephone"></i>
                            {{ auth()->user()->number ?? 'Not provided' }}
                        </div>
                </div>

                <div class="info-group">
                    <label>Member Since</label>
                        <div class="value">
                            <i class="bi bi-calendar"></i>
                            {{ auth()->user()->created_at->format('F j, Y') }}
                        </div>
                    </div>
                </div>

                <div class="profile-main">
                    <h2 class="section-title">Activity Overview</h2>
                <div class="activity-stats">
                    <div class="stat-box">
                        <div class="stat-number">{{ auth()->user()->posts()->count() }}</div>
                            <div class="stat-label">Active Listings</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ auth()->user()->soldOrders()->where('orders.status', 'delivered')->count() }}</div>
                            <div class="stat-label">Items Sold</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ auth()->user()->boughtOrders()->count() }}</div>
                            <div class="stat-label">Orders Placed</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ \App\Models\Buy::where('user_id', auth()->id())->count() }}</div>
                        <div class="stat-label">Buy Requests</div>
                        </div>
                    </div>

                    <h2 class="section-title" style="margin-top: 40px;">Recent Activity</h2>
                    <div class="recent-activity">
                        <!-- Add recent activity content here -->
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
                <p>Update your personal information and profile settings</p>
            </div>
            <div class="modal-body">
                <div class="form-tabs">
                    <div class="form-tab active" data-tab="personal">
                        <i class="bi bi-person"></i> Personal Info
                    </div>
                    <div class="form-tab" data-tab="location">
                        <i class="bi bi-geo-alt"></i> Location
                    </div>
                    <div class="form-tab" data-tab="security">
                        <i class="bi bi-shield-lock"></i> Security
                    </div>
                </div>
                
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" id="profile-form">
                @csrf
                @method('PUT')

                    <!-- Personal Info Tab -->
                    <div class="tab-content active" id="tab-personal">
                        <div class="profile-upload-container">
                            <div class="profile-upload-preview" id="preview-container">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" id="profile-preview">
                                @else
                                    <div class="profile-icon">
                                        <ion-icon name="person"></ion-icon>
                                    </div>
                                @endif
                            </div>
                            <div class="profile-upload-info">
                                <label for="profile_picture" class="profile-upload-label">
                                    <i class="bi bi-camera"></i> Choose Image
                                </label>
                                <input type="file" name="profile_picture" id="profile_picture" class="profile-picture-input">
                                <p>Recommended: Square JPG, PNG.<br>Max size: 2MB</p>
                    @error('profile_picture')
                                    <div class="error-message">{{ $message }}</div>
                    @enderror
                            </div>
                </div>

                        <div class="form-group">
                    <label for="username">Username</label>
                            <div class="form-input-icon">
                                <input type="text" name="username" id="username" value="{{ auth()->user()->username }}" class="form-input">
                                <i class="bi bi-at"></i>
                            </div>
                    @error('username')
                                <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                        <div class="form-group">
                            <label for="number">Contact Number</label>
                            <div class="form-input-icon">
                                <input type="text" name="number" id="number" value="{{ auth()->user()->number }}" class="form-input">
                                <i class="bi bi-telephone"></i>
                            </div>
                            @error('number')
                                <div class="error-message">{{ $message }}</div>
                    @enderror
                        </div>
                </div>

                    <!-- Location Tab -->
                    <div class="tab-content" id="tab-location">
                        <div class="form-group">
                            <label for="location-search">Search Location</label>
                    <div class="search-container">
                                <div class="form-input-icon">
                                    <input type="text" id="location-search" placeholder="Search for a location..." class="form-input">
                                    <i class="bi bi-search"></i>
                                </div>
                        <div class="loader" id="search-loader"></div>
                        <div class="search-results" id="search-results"></div>
                    </div>
                        </div>
                        
                    <div id="map-container"></div>
                        
                    <div class="selected-location" id="selected-location">
                            <strong>Selected Location:</strong> <span id="location-display">{{ auth()->user()->location }}</span>
                    </div>
                    <input type="hidden" name="location" id="location-input" value="{{ auth()->user()->location }}">
                    @error('location')
                            <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                    <!-- Security Tab -->
                    <div class="tab-content" id="tab-security">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <div class="form-input-icon">
                                <input type="password" name="password" id="password" class="form-input" placeholder="Leave blank to keep current password">
                                <i class="bi bi-lock"></i>
                            </div>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <div class="form-input-icon">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Confirm new password">
                                <i class="bi bi-key"></i>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <i class="bi bi-check-lg"></i> Save Changes
                </button>
            </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('editProfileModal');
        const showEditFormBtn = document.getElementById('showEditForm');
        const closeModalBtn = document.querySelector('.close-modal');
        const formTabs = document.querySelectorAll('.form-tab');
        const tabContents = document.querySelectorAll('.tab-content');
        const profilePictureInput = document.getElementById('profile_picture');
        const profilePreviewContainer = document.getElementById('preview-container');
        
        let map, marker, geocoder;
        
        // Check for success message in session and show popup
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'swal-wide'
                }
            });
        @endif
        
        // Check for validation errors and show modal if there are any
        @if($errors->any())
            showModal();
            // Show the tab containing the error
            const errorFields = [@error('profile_picture') 'profile_picture', @enderror
                              @error('username') 'username', @enderror
                              @error('number') 'number', @enderror
                              @error('location') 'location', @enderror
                              @error('password') 'password', @enderror];
            
            if (errorFields.includes('profile_picture') || 
                errorFields.includes('username') || 
                errorFields.includes('number')) {
                switchTab('personal');
            } else if (errorFields.includes('location')) {
                switchTab('location');
            } else if (errorFields.includes('password')) {
                switchTab('security');
            }
        @endif
        
        // Tab switching
        formTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                switchTab(tabId);
            });
        });
        
        function switchTab(tabId) {
            // Remove active class from all tabs and content
            formTabs.forEach(tab => tab.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to selected tab and content
            document.querySelector(`.form-tab[data-tab="${tabId}"]`).classList.add('active');
            document.getElementById(`tab-${tabId}`).classList.add('active');
            
            // If location tab is selected, initialize map
            if (tabId === 'location' && modal.style.display === 'flex') {
            setTimeout(initMap, 100);
            }
        }
        
        // Profile picture preview
        if (profilePictureInput) {
            profilePictureInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        let existingImg = profilePreviewContainer.querySelector('img');
                        let existingIcon = profilePreviewContainer.querySelector('.profile-icon');
                        
                        if (existingIcon) {
                            existingIcon.remove();
                        }
                        
                        if (existingImg) {
                            existingImg.src = e.target.result;
                        } else {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.id = 'profile-preview';
                            img.alt = 'Profile Preview';
                            profilePreviewContainer.appendChild(img);
                        }
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // Modal functionality
        showEditFormBtn.addEventListener('click', showModal);
        
        function showModal() {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            // Initialize first tab
            switchTab('personal');
        }
        
        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
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
        
        // Initialize map
        function initMap() {
            if (map) {
                map.invalidateSize();
                return;
            }
            
            // Default to Zamboanga City coordinates
            let initialLat = 6.9214;
            let initialLng = 122.0790;
            let initialZoom = 13;
            
            // Try to geocode user's current location
            const currentLocation = document.getElementById('location-input').value;
            if (currentLocation && currentLocation !== '') {
                // Only geocode if it doesn't already contain "Zamboanga City"
                if (!currentLocation.toLowerCase().includes('zamboanga')) {
                    geocodeLocation(currentLocation);
                }
            } else {
                // If no location set, use Zamboanga City and set it as initial location
                reverseGeocode(initialLat, initialLng, true);
            }
            
            // Initialize the map
            map = L.map('map-container').setView([initialLat, initialLng], initialZoom);
            
            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // Initialize marker at Zamboanga City position
            marker = L.marker([initialLat, initialLng], {
                draggable: true
            }).addTo(map);
            
            // Add a label for Zamboanga City
            L.marker([initialLat, initialLng], {
                icon: L.divIcon({
                    className: 'location-label',
                    html: '<div style="background-color: rgba(255,255,255,0.8); padding: 5px; border-radius: 4px; font-weight: bold; border: 1px solid #517A5B;">Zamboanga City</div>',
                    iconSize: [100, 20],
                    iconAnchor: [50, 0]
                })
            }).addTo(map);
            
            // Update location when marker is dragged
            marker.on('dragend', function(event) {
                const position = marker.getLatLng();
                reverseGeocode(position.lat, position.lng);
            });
            
            // Add click event to map for positioning marker
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                reverseGeocode(e.latlng.lat, e.latlng.lng);
            });
            
            // Initialize the geocoder control
            geocoder = L.Control.geocoder({
                defaultMarkGeocode: false
            }).on('markgeocode', function(e) {
                const latlng = e.geocode.center;
                marker.setLatLng(latlng);
                map.setView(latlng, 16);
                reverseGeocode(latlng.lat, latlng.lng);
            }).addTo(map);
            
            // Initialize search functionality
            initSearch();
        }
        
        // Initialize search functionality
        function initSearch() {
            const searchInput = document.getElementById('location-search');
            const searchResults = document.getElementById('search-results');
            const searchLoader = document.getElementById('search-loader');
            let searchTimeout;
            
            // Set initial search value to "Zamboanga City" if input is empty
            if (!searchInput.value) {
                searchInput.value = "Zamboanga City";
            }
            
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length < 3) {
                    searchResults.style.display = 'none';
                    return;
                }
                
                // Show loading indicator
                searchLoader.style.display = 'inline-block';
                
                // Add small delay before searching
                searchTimeout = setTimeout(() => {
                    // Focus search on Zamboanga City area by adding it to the query
                    searchLocation(query + " Zamboanga City");
                }, 500);
            });
        }
        
        // Search for locations using Nominatim API
        function searchLocation(query) {
            const searchResults = document.getElementById('search-results');
            const searchLoader = document.getElementById('search-loader');
            
            // Add viewbox parameter to bias results toward Zamboanga City area
            // viewbox=min_lon,min_lat,max_lon,max_lat
            const viewbox = '121.8790,6.8214,122.2790,7.0214'; // Box around Zamboanga City
            
            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&viewbox=${viewbox}&bounded=1&format=json&limit=5`)
                .then(response => response.json())
                .then(data => {
                    searchLoader.style.display = 'none';
                    searchResults.innerHTML = '';
                    
                    if (data.length === 0) {
                        searchResults.innerHTML = '<div class="search-result-item">No results found</div>';
                        searchResults.style.display = 'block';
                        return;
                    }
                    
                    data.forEach(result => {
                        const resultItem = document.createElement('div');
                        resultItem.className = 'search-result-item';
                        resultItem.textContent = result.display_name;
                        resultItem.addEventListener('click', function() {
                            // Update map and marker
                            const lat = parseFloat(result.lat);
                            const lon = parseFloat(result.lon);
                            map.setView([lat, lon], 16);
                            marker.setLatLng([lat, lon]);
                            
                            // Update location input
                            document.getElementById('location-input').value = result.display_name;
                            document.getElementById('location-display').textContent = result.display_name;
                            document.getElementById('location-search').value = result.display_name;
                            
                            // Hide search results
                            searchResults.style.display = 'none';
                        });
                        searchResults.appendChild(resultItem);
                    });
                    
                    searchResults.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error searching location:', error);
                    searchLoader.style.display = 'none';
                    searchResults.innerHTML = '<div class="search-result-item">Error searching location</div>';
                    searchResults.style.display = 'block';
                });
        }
        
        // Reverse geocode coordinates to address
        function reverseGeocode(lat, lng, isInitial = false) {
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        document.getElementById('location-input').value = data.display_name;
                        document.getElementById('location-display').textContent = data.display_name;
                        document.getElementById('location-search').value = data.display_name;
                        
                        // If this is the initial load and we're using default Zamboanga City coordinates,
                        // add a specific note to make it clear
                        if (isInitial) {
                            document.getElementById('location-display').textContent = data.display_name + " (Default)";
                        }
                    }
                })
                .catch(error => {
                    console.error('Error in reverse geocoding:', error);
                });
        }
        
        // Geocode address to coordinates
        function geocodeLocation(address) {
            // If address doesn't include Zamboanga, append it to bias results
            let searchAddress = address;
            if (!address.toLowerCase().includes('zamboanga')) {
                searchAddress = address + ", Zamboanga City";
            }
            
            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(searchAddress)}&format=json&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const result = data[0];
                        const lat = parseFloat(result.lat);
                        const lon = parseFloat(result.lon);
                        
                        if (map) {
                            map.setView([lat, lon], 16);
                            if (marker) {
                                marker.setLatLng([lat, lon]);
                            } else {
                                marker = L.marker([lat, lon], {
                                    draggable: true
                                }).addTo(map);
                                
                                marker.on('dragend', function(event) {
                                    const position = marker.getLatLng();
                                    reverseGeocode(position.lat, position.lng);
                                });
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error geocoding address:', error);
                });
        }
    });
    </script>
</body>
</html>
