<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell an Item - Recyclo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- OpenStreetMap Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <!-- Leaflet Control Geocoder for search functionality -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
    <style>
        :root {
            --hoockers-green: #517A5B;
            --hoockers-green_80: #517A5Bcc;
        }
        
        body {
            font-family: 'Urbanist', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }

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
        
        .sell-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .page-title {
            color: var(--hoockers-green);
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
        }
        
        .form-group {
            margin-bottom: 24px;
            width: 100%;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
            font-size: 18px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 18px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: var(--hoockers-green);
            outline: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 16px;
            margin-top: 5px;
        }

        .submit-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 16px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 20px;
            width: 100%;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: var(--hoockers-green_80);
        }

        /* Loading spinner animation */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
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
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Use the sidebar component -->
        <x-sidebar activePage="sell-item" />

        <!-- Main Content -->
        <div class="main-content">
            <div class="sell-container">
                <h1 class="page-title">Sell an Item</h1>
                
                <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="title">Product Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter product title..." value="{{ old('title') }}" required>
                        @error('title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category">Category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="">--Select--</option>
                            <option value="Metal" {{ old('category') == 'Metal' ? 'selected' : '' }}>Metal</option>
                            <option value="Plastic" {{ old('category') == 'Plastic' ? 'selected' : '' }}>Plastic</option>
                            <option value="Paper" {{ old('category') == 'Paper' ? 'selected' : '' }}>Paper</option>
                            <option value="Glass" {{ old('category') == 'Glass' ? 'selected' : '' }}>Glass</option>
                            <option value="Wood" {{ old('category') == 'Wood' ? 'selected' : '' }}>Wood</option>
                            <option value="Electronics" {{ old('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="Fabric" {{ old('category') == 'Fabric' ? 'selected' : '' }}>Fabric</option>
                            <option value="Rubber" {{ old('category') == 'Rubber' ? 'selected' : '' }}>Rubber</option>
                        </select>
                        @error('category')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="location">City/Area</label>
                        <input type="text" name="location" id="location" class="form-control" placeholder="Enter city or area..." value="{{ old('location', 'Zamboanga City') }}" required>
                        @error('location')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="address">Full Address</label>
                        <div class="search-container">
                            <input type="text" id="address-search" placeholder="Search for your address..." 
                                   class="form-control" value="{{ old('address', auth()->user()->location ?? '') }}">
                            <div class="loader" id="search-loader"></div>
                            <div class="search-results" id="search-results"></div>
                        </div>
                        <div id="map-container"></div>
                        <div class="selected-location" id="selected-location">
                            <strong>Selected address:</strong> <span id="address-display">{{ old('address', auth()->user()->location ?? 'No address selected') }}</span>
                        </div>
                        <input type="hidden" name="address" id="address-input" value="{{ old('address', auth()->user()->location ?? '') }}">
                        @error('address')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="unit">Unit</label>
                        <select name="unit" id="unit" class="form-control" required>
                            <option value="">--Select--</option>
                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                            <option value="g" {{ old('unit') == 'g' ? 'selected' : '' }}>Gram (g)</option>
                            <option value="lb" {{ old('unit') == 'lb' ? 'selected' : '' }}>Pound (lb)</option>
                            <option value="L" {{ old('unit') == 'L' ? 'selected' : '' }}>Liter (L)</option>
                            <option value="m3" {{ old('unit') == 'm3' ? 'selected' : '' }}>Cubic Meter (m3)</option>
                            <option value="gal" {{ old('unit') == 'gal' ? 'selected' : '' }}>Gallon (gal)</option>
                            <option value="pc" {{ old('unit') == 'pc' ? 'selected' : '' }}>Per Piece (pc)</option>
                            <option value="dz" {{ old('unit') == 'dz' ? 'selected' : '' }}>Per Dozen (dz)</option>
                            <option value="bndl" {{ old('unit') == 'bndl' ? 'selected' : '' }}>Per Bundle (bndl)</option>
                            <option value="sack" {{ old('unit') == 'sack' ? 'selected' : '' }}>Per Sack (sack)</option>
                            <option value="bale" {{ old('unit') == 'bale' ? 'selected' : '' }}>Per Bale (bale)</option>
                            <option value="roll" {{ old('unit') == 'roll' ? 'selected' : '' }}>Per Roll (roll)</option>
                            <option value="drum" {{ old('unit') == 'drum' ? 'selected' : '' }}>Per Drum (drum)</option>
                            <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>Per Box (box)</option>
                            <option value="pallet" {{ old('unit') == 'pallet' ? 'selected' : '' }}>Per Pallet (pallet)</option>
                        </select>
                        @error('unit')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity..." value="{{ old('quantity') }}" required>
                        @error('quantity')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="price">Price per unit</label>
                        <input type="text" name="price" id="price" class="form-control" placeholder="Enter price..." value="{{ old('price') }}" required>
                        @error('price')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter description...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="image">Photo</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                        @error('image')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="submit-btn">Post Item for Sale</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
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

        // Check for error message in session and show popup
        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'bigger-modal'
                }
            });
        @endif
        
        // Initialize map functionality
        let map, marker, geocoder;
        
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
            const currentAddress = document.getElementById('address-input').value;
            if (currentAddress && currentAddress !== '') {
                // Only geocode if it doesn't already contain coordinates
                geocodeLocation(currentAddress);
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
            const searchInput = document.getElementById('address-search');
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
                            
                            // Update address input
                            document.getElementById('address-input').value = result.display_name;
                            document.getElementById('address-display').textContent = result.display_name;
                            document.getElementById('address-search').value = result.display_name;
                            
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
                        document.getElementById('address-input').value = data.display_name;
                        document.getElementById('address-display').textContent = data.display_name;
                        document.getElementById('address-search').value = data.display_name;
                        
                        // If this is the initial load and we're using default Zamboanga City coordinates,
                        // add a specific note to make it clear
                        if (isInitial) {
                            document.getElementById('address-display').textContent = data.display_name + " (Default)";
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
        
        // Initialize map when DOM is loaded
        initMap();
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
