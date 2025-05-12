<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register a Shop - Recyclo</title>
    
    <!-- Required imports -->
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
        :root {
            --primary-color: #517A5B;
            --secondary-color: #3c5c44;
            --accent-color: #8BA888;
            --background-color: #f8f9fa;
            --text-color: #333;
            --text-light: #666;
            --border-radius: 16px;
            --box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        body {
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
            font-family: 'Urbanist', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        .page-container {
            display: flex;
            min-height: 100vh;
            background-color: var(--background-color);
        }

        .main-content {
            flex: 1;
            padding: 40px;
            margin-left: 250px;
            max-width: calc(100% - 250px);
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
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .profile-header h1 {
            margin: 0;
            color: var(--primary-color);
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .profile-header p {
            color: var(--text-light);
            font-size: 18px;
            max-width: 600px;
        }

        .requirements {
            background: white;
            padding: 35px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .requirements h3 {
            color: var(--primary-color);
            font-size: 24px;
            margin-bottom: 25px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .requirements h3::before {
            content: "\F26B";
            font-family: "Bootstrap Icons";
            color: var(--primary-color);
        }

        .requirements ul {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .requirements li {
            display: flex;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            border: 1px solid rgba(81, 122, 91, 0.1);
            font-size: 16px;
        }

        .requirements li:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }

        .requirements li:before {
            content: "\F26B";
            font-family: "Bootstrap Icons";
            margin-right: 15px;
            color: var(--primary-color);
            font-size: 20px;
        }

        .seller-form {
            background: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-group label {
            display: block;
            color: var(--text-color);
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .form-input {
            background-color: white;
            border: 2px solid #eee;
            border-radius: 12px;
            padding: 16px 20px;
            width: 100%;
            font-size: 16px;
            transition: var(--transition);
            color: var(--text-color);
        }

        .form-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(81, 122, 91, 0.1);
            outline: none;
        }

        .file-input-wrapper {
            margin-top: 10px;
        }

        .file-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 20px;
            background: white;
            border: 2px dashed #ddd;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 16px;
            color: var(--text-color);
        }

        .file-label:hover {
            border-color: var(--primary-color);
            background: rgba(81, 122, 91, 0.05);
        }

        .file-label.has-file {
            border-style: solid;
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: rgba(81, 122, 91, 0.05);
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 18px 30px;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            font-size: 18px;
            font-weight: 600;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .submit-btn i {
            margin-right: 12px;
            font-size: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(81, 122, 91, 0.2);
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

        .required {
            color: #dc3545;
            margin-left: 3px;
        }

        .input-hint {
            display: block;
            color: var(--text-light);
            font-size: 14px;
            margin-top: 8px;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 8px;
            font-weight: 500;
        }

        /* Map Related Styles */
        #map-container {
            height: 300px;
            width: 100%;
            border-radius: 12px;
            border: 2px solid #eee;
            margin-top: 15px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .search-container {
            position: relative;
            margin-bottom: 20px;
        }

        .search-results {
            position: absolute;
            left: 0;
            right: 0;
            top: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            max-height: 250px;
            overflow-y: auto;
            z-index: 10;
            display: none;
            border: 1px solid #eee;
        }

        .search-result-item {
            padding: 15px 20px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: var(--transition);
            font-size: 16px;
        }

        .search-result-item:hover {
            background-color: rgba(81, 122, 91, 0.05);
        }

        .selected-location {
            background-color: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-top: 20px;
            margin-bottom: 20px;
            color: var(--text-color);
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            font-size: 16px;
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

        /* Application Status Styles */
        .application-status-container {
            max-width: 800px;
            margin: 40px auto;
        }

        .status-box {
            background: white;
            padding: 40px;
            border-radius: var(--border-radius);
            text-align: center;
            box-shadow: var(--box-shadow);
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .status-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
        }

        .status-box.pending::before {
            background: #ffc107;
        }

        .status-box.approved::before {
            background: #28a745;
        }

        .status-box.rejected::before {
            background: #dc3545;
        }

        .status-icon {
            font-size: 4rem;
            margin-bottom: 25px;
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
            margin: 30px 0;
            padding: 25px;
            background: white;
            border-radius: 12px;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .status-badge {
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
            font-size: 14px;
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
            gap: 15px;
            padding: 20px;
            background: white;
            border-radius: 12px;
            margin-top: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            font-size: 16px;
        }

        .info-message i {
            color: var(--primary-color);
            font-size: 24px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            margin-top: 25px;
            transition: var(--transition);
            font-weight: 600;
            font-size: 18px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(81, 122, 91, 0.2);
        }

        .alert {
            padding: 20px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            font-size: 16px;
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

        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
                max-width: 100%;
                padding: 20px;
            }

            .profile-header,
            .requirements,
            .seller-form {
                padding: 25px;
            }

            .profile-header h1 {
                font-size: 32px;
            }

            .requirements h3 {
                font-size: 22px;
            }

            .requirements ul {
                grid-template-columns: 1fr;
            }

            .form-group label,
            .form-input,
            .file-label,
            .submit-btn,
            .search-result-item,
            .selected-location,
            .status-details,
            .info-message,
            .alert {
                font-size: 16px;
            }
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