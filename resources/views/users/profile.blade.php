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

        /* Map container styling */
        #map-container {
            height: 300px;
            width: 100%;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        
        /* Search container styling */
        .search-container {
            margin-bottom: 10px;
        }
        
        #location-search {
            width: 100%;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .search-results {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 6px;
            display: none;
        }
        
        .search-result-item {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        
        .search-result-item:hover {
            background-color: #f0f0f0;
        }
        
        .selected-location {
            padding: 10px;
            background-color: #e8f4ea;
            border-radius: 6px;
            margin-top: 10px;
            border-left: 4px solid var(--hoockers-green);
        }
        
        /* Loading indicator */
        .loader {
            display: none;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--hoockers-green);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
                    <input type="password" name="password" class="form-control">
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
        let map, marker, geocoder;
        
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
