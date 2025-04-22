<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register a Shop - Recyclo</title>
    
    <!-- Required imports as specified -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
    <!-- OpenStreetMap Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <!-- Leaflet Control Geocoder for search functionality -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
    
    <!-- SweetAlert for confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Base styles matching profile.php */
        .profile-container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 40px;
        }

        /* Updated seller form styles to match profile.php */
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
            font-size: 32px;
            margin-bottom: 20px;
        }

        .profile-header p {
            font-size: 16px;
        }

        .requirements {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .requirements h3 {
            color: var(--hoockers-green);
            font-size: 24px;
            margin-bottom: 20px;
        }

        .requirements ul {
            list-style: none;
            padding: 0;
        }

        .requirements li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #333;
            font-size: 18px;
        }

        .requirements li:before {
            content: "\F26B"; /* Bootstrap Icons check-circle */
            font-family: "Bootstrap Icons";
            margin-right: 10px;
            color: var(--hoockers-green);
        }

        .seller-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #666;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 18px;
        }

        .file-input-wrapper {
            margin-top: 10px;
        }

        .file-label {
            display: block;
            padding: 12px;
            background: #f8f9fa;
            border: 2px dashed #ddd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .file-label:hover {
            border-color: var(--hoockers-green);
            background: #f0f0f0;
        }

        .file-label.has-file {
            border-style: solid;
            border-color: var(--hoockers-green);
            color: var(--hoockers-green);
        }

        .submit-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: #3c5c44; /* Using direct color instead of variable */
            color: white !important; /* Using !important to override any other styles */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .required {
            color: #dc3545;
            margin-left: 3px;
        }

        .input-hint {
            display: block;
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Application status styles */
        .application-status-container {
            max-width: 800px;
            margin: 40px auto;
        }

        .status-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .status-box.pending {
            border-top: 5px solid #ffc107;
        }

        .status-box.approved {
            border-top: 5px solid #28a745;
        }

        .status-box.rejected {
            border-top: 5px solid #dc3545;
        }

        .status-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .pending .status-icon {
            color: #ffc107;
        }

        .approved .status-icon {
            color: #28a745;
        }

        .rejected .status-icon {
            color: #dc3545;
        }

        .status-details {
            margin: 25px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            font-size: 16px;
        }

        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 500;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.approved {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .info-message {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #e9ecef;
            border-radius: 10px;
            margin-top: 20px;
        }

        .info-message i {
            color: #517A5B;
            font-size: 1.2rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #517A5B;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #3c5c44;
            transform: translateY(-2px);
        }

        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            text-decoration: underline;
        }
        
        /* Map Related Styles */
        #map-container {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 10px;
            margin-bottom: 15px;
        }
        
        .search-container {
            margin-bottom: 15px;
        }
        
        #location-search {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .search-results {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
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
            border-radius: 8px;
            margin-top: 10px;
            border-left: 4px solid var(--hoockers-green);
        }
        
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
    <div class="profile-container">
        <!-- Sidebar Component -->
        <x-sidebar activePage="shop-register" />

        <!-- Main Content -->
        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (!isset($application))
                <!-- Show regular application form for new applicants -->
                <div class="profile-header">
                    <h1>Register a Shop</h1>
                    <p>Start your journey as a Recyclo shop owner and contribute to a sustainable future</p>
                </div>

                <div class="requirements">
                    <h3>Requirements</h3>
                    <ul>
                        <li>Valid Government-issued ID</li>
                        <li>Physical store/warehouse address</li>
                        <li>Active email address</li>
                        <li>Mobile number for verification</li>
                    </ul>
                </div>

                <div class="seller-form">
                    <form method="POST" action="{{ route('shop.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" name="shop_name" required placeholder="Enter your shop name" value="{{ old('shop_name') }}">
                            @error('shop_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Shop Address</label>
                            <div class="search-container">
                                <input type="text" id="location-search" placeholder="Search for a location..." value="{{ $user->location }}" class="form-control">
                                <div class="loader" id="search-loader"></div>
                                <div class="search-results" id="search-results"></div>
                            </div>
                            <div id="map-container"></div>
                            <div class="selected-location" id="selected-location">
                                <strong>Selected:</strong> <span id="location-display">{{ $user->location }}</span>
                            </div>
                            <textarea name="shop_address" id="shop-address-input" rows="3" required placeholder="Enter your complete shop address">{{ old('shop_address', $user->location) }}</textarea>
                            @error('shop_address')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Valid ID <span class="required">*</span></label>
                            <div class="file-input-wrapper">
                                <label class="file-label">
                                    <i class="bi bi-upload"></i> Upload Valid ID
                                    <input type="file" name="valid_id" accept=".jpg,.jpeg,.png,.pdf" style="display: none;" required>
                                </label>
                            </div>
                            <small class="input-hint">Upload a valid government-issued ID (Max: 5MB)</small>
                            @error('valid_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="submit-btn">Submit Application</button>
                    </form>
                </div>
            @else
                <!-- Show application status -->
                <div class="application-status-container">
                    @if ($application->status == 'pending')
                        <div class="status-box pending">
                            <i class="bi bi-hourglass-split status-icon"></i>
                            <h2>Application Under Review</h2>
                            <p>Your shop application is currently being reviewed by our team.</p>
                            <div class="status-details">
                                <p>Application Date: {{ $application->created_at->format('F j, Y - g:i A') }}</p>
                                @if ($application->updated_at && $application->updated_at != $application->created_at)
                                    <p>Status Update: {{ $application->updated_at->format('F j, Y - g:i A') }}</p>
                                @endif
                                <p>Status: <span class="status-badge pending">Pending</span></p>
                            </div>
                            <div class="info-message">
                                <i class="bi bi-info-circle"></i>
                                <p>Please wait while we verify your information. This process typically takes 1-2 business days.</p>
                            </div>
                        </div>
                    @elseif ($application->status == 'approved')
                        <div class="status-box approved">
                            <i class="bi bi-check-circle-fill status-icon"></i>
                            <h2>Congratulations!</h2>
                            <p>Your application has been approved. You are now a verified Recyclo shop owner.</p>
                            <div class="status-details">
                                <p>Application Date: {{ $application->created_at->format('F j, Y - g:i A') }}</p>
                                @if ($application->updated_at && $application->updated_at != $application->created_at)
                                    <p>Status Update: {{ $application->updated_at->format('F j, Y - g:i A') }}</p>
                                @endif
                                <p>Status: <span class="status-badge approved">Approved</span></p>
                            </div>
                            <a href="{{ route('shop.dashboard') }}" class="btn-primary">
                                <i class="bi bi-shop"></i> Go to Shop Dashboard
                            </a>
                        </div>
                    @elseif ($application->status == 'rejected')
                        <div class="status-box rejected">
                            <i class="bi bi-x-circle-fill status-icon"></i>
                            <h2>Application Not Approved</h2>
                            <p>Unfortunately, your shop application was not approved at this time.</p>
                            <div class="status-details">
                                <p>Application Date: {{ $application->created_at->format('F j, Y - g:i A') }}</p>
                                @if ($application->updated_at && $application->updated_at != $application->created_at)
                                    <p>Status Update: {{ $application->updated_at->format('F j, Y - g:i A') }}</p>
                                @endif
                                <p>Status: <span class="status-badge rejected">Rejected</span></p>
                                @if ($application->remarks)
                                    <p>Reason: {{ $application->remarks }}</p>
                                @endif
                            </div>
                            <div class="info-message">
                                <i class="bi bi-info-circle"></i>
                                <p>You can submit a new application after 30 days with updated information.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let map, marker, geocoder;
        
        // Initialize map if the map container exists (only on new application page)
        if (document.getElementById('map-container')) {
            initMap();
        }
        
        // Show filename when file is selected
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                if (e.target.files[0]) {
                    let fileName = e.target.files[0].name;
                    let fileSize = e.target.files[0].size / (1024 * 1024); // Convert to MB
                    let label = e.target.parentElement;
                    
                    if (fileSize > 5) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'File size must be less than 5MB',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                        e.target.value = ''; // Clear the input
                        return;
                    }

                    label.innerHTML = `<i class="bi bi-file-earmark-check"></i> ${fileName}`;
                    label.classList.add('has-file');
                    input.style.display = 'none'; // Keep the input hidden
                    label.appendChild(input); // Re-append the input to the label
                }
            });
        });

        // Form validation
        document.querySelector('form')?.addEventListener('submit', function(e) {
            let validId = document.querySelector('input[name="valid_id"]');

            if (validId && !validId.files[0]) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Valid ID is required',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
            }
        });
        
        function initMap() {
            // Default to Zamboanga City coordinates
            let initialLat = 6.9214;
            let initialLng = 122.0790;
            let initialZoom = 13;
            
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
            
            // Try to geocode user's current location from profile
            const currentLocation = document.getElementById('location-search').value;
            if (currentLocation && currentLocation !== '') {
                geocodeLocation(currentLocation);
            }
        }
        
        // Initialize search functionality
        function initSearch() {
            const searchInput = document.getElementById('location-search');
            const searchResults = document.getElementById('search-results');
            const searchLoader = document.getElementById('search-loader');
            let searchTimeout;
            
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
                            
                            // Update location inputs
                            document.getElementById('location-display').textContent = result.display_name;
                            document.getElementById('shop-address-input').value = result.display_name;
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
        function reverseGeocode(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        document.getElementById('location-display').textContent = data.display_name;
                        document.getElementById('shop-address-input').value = data.display_name;
                        document.getElementById('location-search').value = data.display_name;
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
