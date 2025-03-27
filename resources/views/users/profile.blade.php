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
            --hoockers-green: #517A5B;
            --hoockers-green-light: #6c9475;
            --hoockers-green-dark: #3c5c44;
            --hoockers-green-bg: rgba(81, 122, 91, 0.08);
        }
        
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            font-family: 'Urbanist', sans-serif;
            color: #333;
            line-height: 1.6;
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

        /* Improved profile header */
        .profile-header {
            background: white;
            padding: 30px 35px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            border-left: 5px solid var(--hoockers-green);
        }

        .profile-header h1 {
            margin: 0;
            color: var(--hoockers-green);
            font-size: 32px;
            margin-bottom: 12px;
            font-weight: 700;
        }
        
        .profile-header p {
            color: #666;
            font-size: 16px;
            max-width: 600px;
            margin: 0;
        }

        /* Enhanced profile info section */
        .profile-info {
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        
        /* Add subtle pattern to profile info */
        .profile-info::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background-color: var(--hoockers-green-bg);
            border-radius: 0 0 0 100%;
            z-index: 0;
        }

        .info-group {
            margin-bottom: 28px;
            position: relative;
            z-index: 1;
        }

        .info-group label {
            display: block;
            color: #555;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-group .value {
            color: #333;
            font-size: 16px;
            padding: 14px 18px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 3px solid var(--hoockers-green);
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
        }
        
        .info-group .value:hover {
            transform: translateX(3px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        }

        /* Improved edit button */
        .edit-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            text-decoration: none;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(81, 122, 91, 0.2);
        }

        .edit-btn:hover {
            background: var(--hoockers-green-dark);
            color: white !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(81, 122, 91, 0.3);
        }
        
        .edit-btn:active {
            transform: translateY(-1px);
        }

        /* Enhanced profile picture container */
        .profile-picture-container {
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .profile-picture {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(81, 122, 91, 0.3);
            position: relative;
            transition: all 0.3s ease;
        }
        
        .profile-picture:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(81, 122, 91, 0.35);
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }
        
        .profile-picture:hover img {
            transform: scale(1.1);
        }

        .profile-icon {
            font-size: 100px;
            color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background-color: #f5f5f5;
        }
        
        /* Username display below profile picture */
        .profile-username {
            font-size: 22px;
            font-weight: 700;
            color: var(--hoockers-green);
            margin: 0 0 5px;
        }
        
        .profile-fullname {
            font-size: 16px;
            color: #666;
            margin: 0;
        }

        /* Redesigned activity stats */
        .activity-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .stat-box {
            background: white;
            padding: 22px 15px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border-top: 4px solid var(--hoockers-green);
            position: relative;
            overflow: hidden;
        }
        
        .stat-box::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(to right, var(--hoockers-green), var(--hoockers-green-light));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        
        .stat-box:hover::after {
            opacity: 1;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--hoockers-green);
            line-height: 1;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        
        .stat-number::after {
            content: '';
            display: block;
            width: 30px;
            height: 3px;
            background-color: var(--hoockers-green-light);
            margin: 5px auto 0;
            border-radius: 2px;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Improved activity section header */
        .section-title {
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 12px;
            font-size: 24px;
            font-weight: 700;
            color: var(--hoockers-green);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--hoockers-green);
            border-radius: 2px;
        }

        /* Enhanced form controls */
        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
            color: #333;
            background-color: #fff;
        }
        
        .form-control:focus {
            border-color: var(--hoockers-green);
            outline: none;
            box-shadow: 0 0 0 3px rgba(81, 122, 91, 0.15);
        }
        
        .form-control::placeholder {
            color: #aaa;
        }

        /* Modal Styles Enhancement */
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
            backdrop-filter: blur(3px);
        }

        .modal-content {
            background-color: white;
            margin: auto;
            padding: 35px;
            border-radius: 18px;
            width: 95%;
            max-width: 650px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: modalAnimation 0.4s ease;
        }

        @keyframes modalAnimation {
            from {opacity: 0; transform: translateY(-40px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 28px;
            cursor: pointer;
            color: #777;
            transition: all 0.3s;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .close-modal:hover {
            color: #333;
            background-color: #f5f5f5;
            transform: rotate(90deg);
        }

        .modal-header {
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 25px;
            padding-bottom: 15px;
        }

        .modal-header h3 {
            margin: 0;
            color: var(--hoockers-green);
            font-size: 26px;
            font-weight: 700;
        }
        
        /* Map container styling enhancement */
        #map-container {
            height: 300px;
            width: 100%;
            margin-top: 10px;
            border-radius: 12px;
            border: 2px solid #eee;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Search container styling enhancement */
        .search-container {
            margin-bottom: 15px;
            position: relative;
        }
        
        #location-search {
            width: 100%;
            padding: 14px 45px 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        #location-search:focus {
            border-color: var(--hoockers-green);
            box-shadow: 0 0 0 3px rgba(81, 122, 91, 0.15);
        }
        
        .search-results {
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            display: none;
            margin-top: 5px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        .search-result-item {
            padding: 12px 15px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: all 0.2s ease;
        }
        
        .search-result-item:last-child {
            border-bottom: none;
        }
        
        .search-result-item:hover {
            background-color: var(--hoockers-green-bg);
        }
        
        .selected-location {
            padding: 15px;
            background-color: #e8f4ea;
            border-radius: 10px;
            margin-top: 15px;
            border-left: 4px solid var(--hoockers-green);
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }
        
        /* Loading indicator enhancement */
        .loader {
            display: none;
            border: 3px solid rgba(81, 122, 91, 0.1);
            border-top: 3px solid var(--hoockers-green);
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        @keyframes spin {
            0% { transform: translateY(-50%) rotate(0deg); }
            100% { transform: translateY(-50%) rotate(360deg); }
        }
        
        /* Responsiveness improvements */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .profile-picture {
                width: 140px;
                height: 140px;
            }
            
            .activity-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .modal-content {
                padding: 25px;
                width: 90%;
            }
        }
        
        /* SweetAlert2 custom styles for larger modals - matching shop dashboard */
        .swal2-popup.swal2-modal.bigger-modal {
            width: 32em !important;
            max-width: 90% !important;
            font-size: 1.2rem !important;
            padding: 2em !important;
        }
        
        .swal2-popup.swal2-modal.bigger-modal .swal2-title {
            font-size: 1.8em !important;
            margin-bottom: 0.5em !important;
            color: var(--hoockers-green);
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
        
        .swal2-popup.swal2-modal.bigger-modal .swal2-icon {
            font-size: 3em !important;
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
                <p>Manage your personal information, settings, and view your activity on Recyclo.</p>
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
                    <h2 class="profile-username">{{ auth()->user()->username }}</h2>
                    <p class="profile-fullname">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</p>
                </div>

                <div class="info-group">
                    <label>Email</label>
                    <div class="value">{{ auth()->user()->email }}</div>
                </div>

                <div class="info-group">
                    <label>Location</label>
                    <div class="value">{{ auth()->user()->location ?: 'Not specified' }}</div>
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
                <h3 class="section-title">Activity Overview</h3>
                <div class="activity-stats">
                    <div class="stat-box">
                        <div class="stat-number">{{ auth()->user()->posts()->count() }}</div>
                        <div class="stat-label">Listings</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ auth()->user()->soldOrders()->where('status', 'delivered')->count() }}</div>
                        <div class="stat-label">Sold Items</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ auth()->user()->boughtOrders()->count() }}</div>
                        <div class="stat-label">My Orders</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ \App\Models\Buy::where('user_id', auth()->id())->count() }}</div>
                        <div class="stat-label">Buy Requests</div>
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
                    <input type="password" name="password" class="form-control" placeholder="Enter new password to change">
                    <small class="text-gray-500">Leave blank to keep current password</small>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="info-group">
                    <label for="location">Location</label>
                    <div class="search-container">
                        <input type="text" id="location-search" placeholder="Search for a location..." class="form-control">
                        <div class="loader" id="search-loader"></div>
                        <div class="search-results" id="search-results"></div>
                    </div>
                    <div id="map-container"></div>
                    <div class="selected-location" id="selected-location">
                        <strong>Selected:</strong> <span id="location-display">{{ auth()->user()->location }}</span>
                    </div>
                    <input type="hidden" name="location" id="location-input" value="{{ auth()->user()->location }}">
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="info-group">
                    <label for="number">Contact Number</label>
                    <input type="text" name="number" value="{{ auth()->user()->number }}" class="form-control" placeholder="Enter your contact number">
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
                    popup: 'bigger-modal'
                }
            });
        @endif
        
        showEditFormBtn.addEventListener('click', function() {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
            
            // Initialize map on modal open
            setTimeout(initMap, 100);
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

        // Add a function to log data when form is submitted for debugging
        const profileForm = document.querySelector('#editProfileModal form');
        if (profileForm) {
            profileForm.addEventListener('submit', function(event) {
                // Don't prevent default, we want the form to submit
                const formData = new FormData(this);
                
                // Check if the location input has a value
                const locationInput = document.getElementById('location-input');
                if (locationInput) {
                    console.log('Location value on submit:', locationInput.value);
                }
                
                // Debug the file input
                const fileInput = document.querySelector('input[name="profile_picture"]');
                console.log('File selected:', fileInput.files.length > 0 ? fileInput.files[0].name : 'No file');
            });
        }
        
        // Make sure the location is properly synchronized between the search and the hidden input
        const locationSearch = document.getElementById('location-search');
        if (locationSearch) {
            locationSearch.addEventListener('change', function() {
                // Ensure the location input is updated whenever the search field changes
                const locationInput = document.getElementById('location-input');
                if (locationInput && this.value) {
                    locationInput.value = this.value;
                }
            });
        }
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
</body>
</html>
