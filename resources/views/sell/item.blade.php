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
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .form-column {
            display: flex;
            flex-direction: column;
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

        /* Enhanced form controls */
        .form-control.enhanced:focus {
            border-color: var(--hoockers-green);
            box-shadow: 0 0 0 3px rgba(81, 122, 91, 0.1);
            outline: none;
        }

        /* Image upload hover effect */
        .image-upload-container:hover {
            border-color: var(--hoockers-green);
            background-color: rgba(81, 122, 91, 0.02);
        }

        /* Button hover effects */
        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            background-color: var(--hoockers-green_80);
        }

        /* Form group hover effect */
        .form-group:hover .form-label {
            color: var(--hoockers-green);
        }

        /* Search results styling */
        .search-results {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            margin-top: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .search-result-item {
            padding: 12px 15px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
            color: var(--hoockers-green);
        }

        /* Products Modal Styles */
        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table th,
        .products-table td {
            border-bottom: 1px solid #eee;
        }

        .products-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .product-status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-sold {
            background-color: #f8d7da;
            color: #721c24;
        }

        .product-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .edit-btn {
            background-color: var(--hoockers-green);
            color: white;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .pagination-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .pagination-btn:not(:disabled):hover {
            background-color: var(--hoockers-green_80);
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
                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <!-- Left Column -->
                        <div class="form-column">
                            <div class="form-group">
                                <label class="form-label" for="title" style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-tag" style="color: var(--hoockers-green);"></i> Product Title
                                </label>
                                <input type="text" name="title" id="title" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter product title..." value="{{ old('title') }}" required>
                                @error('title')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category Selection -->
                            <div class="form-group">
                                <label class="form-label" for="category_id" style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-grid" style="color: var(--hoockers-green);"></i> Category
                                </label>
                                <select name="category_id" id="category_id" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    required>
                                    <option value="">--Select Category--</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                                            data-color="{{ $category->color }}"
                                            style="background-color: {{ $category->color }}20;">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="location" style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-geo-alt" style="color: var(--hoockers-green);"></i> City/Area
                                </label>
                                <input type="text" name="location" id="location" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter city or area..." value="{{ old('location', 'Zamboanga City') }}" required>
                                @error('location')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="address" style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-pin-map" style="color: var(--hoockers-green);"></i> Full Address
                                </label>
                                <div class="search-container">
                                    <input type="text" id="address-search" placeholder="Search for your address..." 
                                           class="form-control enhanced" value="{{ old('address', auth()->user()->location ?? '') }}"
                                           style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;">
                                    <div class="loader" id="search-loader"></div>
                                    <div class="search-results" id="search-results"></div>
                                </div>
                                <div id="map-container" style="margin-top: 15px; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></div>
                                <div class="selected-location" id="selected-location" style="margin-top: 15px; padding: 15px; background-color: #f8f9fa; border-radius: 10px; border-left: 4px solid var(--hoockers-green);">
                                    <strong>Selected address:</strong> <span id="address-display">{{ old('address', auth()->user()->location ?? 'No address selected') }}</span>
                                </div>
                                <input type="hidden" name="address" id="address-input" value="{{ old('address', auth()->user()->location ?? '') }}">
                                @error('address')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="form-column">
                            <div class="form-group">
                                <label class="form-label" for="unit" style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-rulers" style="color: var(--hoockers-green);"></i> Unit
                                </label>
                                <select name="unit" id="unit" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    required>
                                    <option value="">--Select Unit--</option>
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
                                <label class="form-label" for="quantity" style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-box-seam" style="color: var(--hoockers-green);"></i> Quantity
                                </label>
                                <input type="number" name="quantity" id="quantity" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter quantity..." value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="price" style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-currency-peso" style="color: var(--hoockers-green);"></i> Price per unit
                                </label>
                                <input type="text" name="price" id="price" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter price..." value="{{ old('price') }}" required>
                                <button type="button" id="pricesGuideBtn" class="btn btn-link" 
                                    style="padding: 8px 12px; margin-top: 10px; color: white; background-color: var(--hoockers-green); display: inline-block; text-decoration: none; font-weight: 500; border-radius: 6px; width: auto; text-align: center; transition: all 0.3s ease;">
                                    <i class="bi bi-info-circle"></i> Prices Guide
                                </button>
                                @error('price')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="description" style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-text-paragraph" style="color: var(--hoockers-green);"></i> Description
                                </label>
                                <textarea name="description" id="description" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; min-height: 120px; resize: vertical;"
                                    placeholder="Enter description...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="image" style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-image" style="color: var(--hoockers-green);"></i> Photo
                                </label>
                                <div class="image-upload-container" style="border: 2px dashed #e0e0e0; border-radius: 10px; padding: 20px; text-align: center; transition: all 0.3s ease;">
                                    <input type="file" name="image" id="image" class="image-upload-input" 
                                        style="display: none;" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                                    <label for="image" class="image-upload-label" 
                                        style="cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                        <i class="bi bi-cloud-upload" style="font-size: 32px; color: var(--hoockers-green);"></i>
                                        <span style="font-size: 15px; color: #666;">Click to upload image</span>
                                        <small style="color: #999;">or drag and drop</small>
                                    </label>
                                    <div id="imagePreview" class="image-preview" style="margin-top: 15px;">
                                        <span class="placeholder-text" style="color: #999;">No image selected</span>
                                    </div>
                                </div>
                                @error('image')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                        <button type="submit" class="submit-btn" style="padding: 12px 25px; border: none; border-radius: 8px; font-size: 15px; font-weight: 500; color: white; background-color: var(--hoockers-green); cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-plus-circle"></i> Post Item for Sale
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Prices Guide Modal -->
    <div id="pricesGuideModal" class="modal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
        <div class="modal-content" style="background-color: white; margin: 50px auto; padding: 20px; width: 90%; max-width: 900px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h2 class="modal-title" style="color: var(--hoockers-green); font-size: 32px; font-weight: 600; margin: 0;">Materials Price Guide</h2>
                <span class="close" style="color: #aaa; float: right; font-size: 36px; font-weight: bold; cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <p style="font-size: 18px; line-height: 28px; margin-bottom: 10px;">This guide provides current market prices for different types of recyclable materials.</p>
                
                <!-- Category tabs -->
                <div style="display: flex; margin-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                    <button id="plasticTabBtn" class="category-tab active-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        Plastic
                        <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>
                    </button>
                    <button id="paperTabBtn" class="category-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        Paper
                    </button>
                    <button id="metalTabBtn" class="category-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        Metal
                    </button>
                    <button id="batteriesTabBtn" class="category-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        Batteries
                    </button>
                    <button id="glassTabBtn" class="category-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        Glass
                    </button>
                    <button id="ewasteTabBtn" class="category-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        E-waste
                    </button>
                </div>
                
                <!-- Plastic prices table -->
                <div id="plasticPricesTable" class="prices-table" style="overflow-x: auto; margin-top: 15px;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white;">
                                <th style="padding: 12px; border: 1px solid #ddd;">Type</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Description</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Buying Price (P/KG)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">PET (e.g., water bottled)</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Common beverages containers</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱6.40-₱10.00</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">HDPE</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Detergent bottles, milk jugs</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱16.90</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">LDPE</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Plastic bags, film wraps</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱2.60-₱3.50</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">PP</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Food containers, bottle caps</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱15.22</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">PS</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Styrofoam, disposable utensils</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱10.25</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">Hard Plastic (Sibak)</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Toys, basins, containers</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱14.00-₱15.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Mixed Plastics</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Assorted plastic waste</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱5.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paper prices table (initially hidden) -->
                <div id="paperPricesTable" class="prices-table" style="overflow-x: auto; margin-top: 15px; display: none;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white;">
                                <th style="padding: 12px; border: 1px solid #ddd;">Type</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Description</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Buying Price (P/KG)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Newspaper</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Old news paper</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱7.33-₱10.00</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">White/Bond paper</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Office documents</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱2.50-11.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Cartons/Cardboard</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Packaging materials</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱3.91-₱6.00</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">Magazines</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Glossy paper materials</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱5.00-₱8.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Assorted/Mixed Papers</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Various paper types</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱1.43-₱8.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Metal prices table (initially hidden) -->
                <div id="metalPricesTable" class="prices-table" style="overflow-x: auto; margin-top: 15px; display: none;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white;">
                                <th style="padding: 12px; border: 1px solid #ddd;">Type</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Description</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Buying Price (P/KG)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Copper</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Electrical wires, plumbing wires</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱70.00-₱323.81</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">Aluminum</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Cans, window frames</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱30.00-₱47.76</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Brass</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Fixtures, decorative items</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱30.00-₱170.94</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">Steel/Bakal</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Construction materials</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱11.00-₱14.79</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Tin Cans</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Food containers</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱8.00-₱11.94</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">GI Sheets/Yero</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Roofing materials</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱0.25-₱11.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Zinc</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Galvanized products</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱8.00-₱15.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Batteries prices table (initially hidden) -->
                <div id="batteriesPricesTable" class="prices-table" style="overflow-x: auto; margin-top: 15px; display: none;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white;">
                                <th style="padding: 12px; border: 1px solid #ddd;">Type</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Description</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Buying Price (P/UNIT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Car Batteries (1SMF)</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Standard vehicle batteries</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱150.00-₱400.00</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">Small Batteries (1SNF)</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Motorcycle or small vehicle batteries</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱50.00-₱70.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Glass prices table (initially hidden) -->
                <div id="glassPricesTable" class="prices-table" style="overflow-x: auto; margin-top: 15px; display: none;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white;">
                                <th style="padding: 12px; border: 1px solid #ddd;">Type</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Description</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Buying Price (KG/PC)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Whole Glass Bottles</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Beverage containers</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱0.50-₱1.50 per pc.</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">Broken Glass (Bubog)</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Shards or cullets</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱0.50-₱1.00 per kg</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Colored Glass</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Tinted bottles</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱0.10-₱0.20 per pc.</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">White/Clear Glass</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Transparent bottles</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱0.50-₱1.00 per pc.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- E-waste prices table (initially hidden) -->
                <div id="ewastePricesTable" class="prices-table" style="overflow-x: auto; margin-top: 15px; display: none;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white;">
                                <th style="padding: 12px; border: 1px solid #ddd;">Type</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Description</th>
                                <th style="padding: 12px; border: 1px solid #ddd;">Buying Price (UNIT/KG)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Computer Motherboards</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Circuit boards from computers</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱250.00 per kg</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">Old Refrigerators</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Non-functional units</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱700.00 per unit</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Washing Machines</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Non-functional units</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱300.00 per unit</td>
                            </tr>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 12px; border: 1px solid #ddd;">Electric Fans</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Non-functional units</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱80.00 per unit</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border: 1px solid #ddd;">Televisions</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">Non-functional units</td>
                                <td style="padding: 12px; border: 1px solid #ddd;">₱120.00 per unit</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 20px; font-style: italic; color: #666;">
                    <p><small>Note: Prices are subject to change based on market conditions and quality of materials.</small></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Modal -->
    <div id="productsModal" class="modal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
        <div class="modal-content" style="background-color: white; margin: 50px auto; padding: 20px; width: 90%; max-width: 900px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h2 class="modal-title" style="color: var(--hoockers-green); font-size: 32px; font-weight: 600; margin: 0;">My Products</h2>
                <span class="close" style="color: #aaa; float: right; font-size: 36px; font-weight: bold; cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Filters -->
                <div class="filters" style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div class="category-filter" style="flex: 1;">
                        <select id="category-filter" class="form-control enhanced" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;">
                            <option value="all">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-box" style="flex: 2;">
                        <input type="text" id="product-search" class="form-control enhanced" 
                            style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;"
                            placeholder="Search products...">
                    </div>
                </div>

                <!-- Products Table -->
                <div class="products-table-container" style="max-height: 500px; overflow-y: auto; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <table class="products-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white; position: sticky; top: 0; z-index: 10;">
                                <th style="padding: 15px; text-align: left;">Image</th>
                                <th style="padding: 15px; text-align: left;">Title</th>
                                <th style="padding: 15px; text-align: center;">Category</th>
                                <th style="padding: 15px; text-align: right;">Price</th>
                                <th style="padding: 15px; text-align: center;">Stock</th>
                                <th style="padding: 15px; text-align: center;">Status</th>
                                <th style="padding: 15px; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="products-table-body">
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 30px;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
                                        <i class="bi bi-arrow-repeat" style="font-size: 48px; animation: spin 1s linear infinite;"></i>
                                        <p>Loading products...</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination" style="display: flex; justify-content: center; margin-top: 20px; gap: 10px;">
                    <button id="prev-page" class="pagination-btn" style="padding: 8px 15px; border: none; border-radius: 5px; background-color: var(--hoockers-green); color: white; cursor: pointer;">
                        <i class="bi bi-chevron-left"></i> Previous
                    </button>
                    <span id="page-info" style="display: flex; align-items: center; padding: 8px 15px;">Page 1 of 1</span>
                    <button id="next-page" class="pagination-btn" style="padding: 8px 15px; border: none; border-radius: 5px; background-color: var(--hoockers-green); color: white; cursor: pointer;">
                        Next <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
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
        
        // Prices Guide Modal Functionality
        const pricesGuideModal = document.getElementById('pricesGuideModal');
        const pricesGuideBtn = document.getElementById('pricesGuideBtn');
        const pricesGuideCloseBtn = pricesGuideModal.querySelector('.close');
        
        // Tab functionality for prices guide
        const plasticTabBtn = document.getElementById('plasticTabBtn');
        const paperTabBtn = document.getElementById('paperTabBtn');
        const metalTabBtn = document.getElementById('metalTabBtn');
        const batteriesTabBtn = document.getElementById('batteriesTabBtn');
        const glassTabBtn = document.getElementById('glassTabBtn');
        const ewasteTabBtn = document.getElementById('ewasteTabBtn');
        const plasticPricesTable = document.getElementById('plasticPricesTable');
        const paperPricesTable = document.getElementById('paperPricesTable');
        const metalPricesTable = document.getElementById('metalPricesTable');
        const batteriesPricesTable = document.getElementById('batteriesPricesTable');
        const glassPricesTable = document.getElementById('glassPricesTable');
        const ewastePricesTable = document.getElementById('ewastePricesTable');
        
        plasticTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'block';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'none';
            ewastePricesTable.style.display = 'none';
            
            plasticTabBtn.classList.add('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.remove('active-tab');
            ewasteTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass';
            ewasteTabBtn.innerHTML = 'E-waste';
        });
        
        paperTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'block';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'none';
            ewastePricesTable.style.display = 'none';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.add('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.remove('active-tab');
            ewasteTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass';
            ewasteTabBtn.innerHTML = 'E-waste';
        });
        
        metalTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'block';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'none';
            ewastePricesTable.style.display = 'none';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.add('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.remove('active-tab');
            ewasteTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass';
            ewasteTabBtn.innerHTML = 'E-waste';
        });
        
        batteriesTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'block';
            glassPricesTable.style.display = 'none';
            ewastePricesTable.style.display = 'none';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.add('active-tab');
            glassTabBtn.classList.remove('active-tab');
            ewasteTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            glassTabBtn.innerHTML = 'Glass';
            ewasteTabBtn.innerHTML = 'E-waste';
        });
        
        glassTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'block';
            ewastePricesTable.style.display = 'none';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.add('active-tab');
            ewasteTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            ewasteTabBtn.innerHTML = 'E-waste';
        });
        
        ewasteTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'none';
            ewastePricesTable.style.display = 'block';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.remove('active-tab');
            ewasteTabBtn.classList.add('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass';
            ewasteTabBtn.innerHTML = 'E-waste <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
        });
        
        // Open prices guide modal when button is clicked
        pricesGuideBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent form submission
            pricesGuideModal.style.display = 'block';
            console.log('Price guide button clicked'); // Debug log
        });
        
        // Close prices guide modal when X is clicked
        pricesGuideCloseBtn.addEventListener('click', function() {
            pricesGuideModal.style.display = 'none';
        });
        
        // Close prices guide modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === pricesGuideModal) {
                pricesGuideModal.style.display = 'none';
            }
        });

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

    // Image preview functionality
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" 
                        style="max-width: 100%; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                `;
            }
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '<span class="placeholder-text" style="color: #999;">No image selected</span>';
        }
    }

    // Form control focus effects
    document.querySelectorAll('.form-control.enhanced').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });

    // Products Modal Functionality
    const productsModal = document.getElementById('productsModal');
    const productsTableBody = document.getElementById('products-table-body');
    const categoryFilter = document.getElementById('category-filter');
    const productSearch = document.getElementById('product-search');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const pageInfo = document.getElementById('page-info');
    let currentPage = 1;
    let totalPages = 1;

    // Function to load products
    function loadProducts(page = 1) {
        const category = categoryFilter.value;
        const search = productSearch.value;

        // Show loading state
        productsTableBody.innerHTML = `
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px;">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
                        <i class="bi bi-arrow-repeat" style="font-size: 48px; animation: spin 1s linear infinite;"></i>
                        <p>Loading products...</p>
                    </div>
                </td>
            </tr>
        `;

        // Fetch products from the server
        fetch(`/api/products?page=${page}&category=${category}&search=${search}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            credentials: 'same-origin'
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok (Status: ${response.status})`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.products || data.products.length === 0) {
                    productsTableBody.innerHTML = `
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
                                    <i class="bi bi-box" style="font-size: 48px; color: #ddd;"></i>
                                    <h3 style="margin: 0; color: #666;">No products found</h3>
                                    <p style="margin: 0; color: #888;">Try adjusting your filters or add a new product</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                // Update pagination
                currentPage = data.current_page;
                totalPages = data.last_page;
                pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
                prevPageBtn.disabled = currentPage === 1;
                nextPageBtn.disabled = currentPage === totalPages;

                // Populate table
                productsTableBody.innerHTML = data.products.map(product => `
                    <tr>
                        <td style="padding: 15px;">
                            <img src="${product.image ? '/storage/' + product.image : '/images/placeholder.png'}" 
                                 alt="${product.title}" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td style="padding: 15px; font-weight: 500;">${product.title}</td>
                        <td style="padding: 15px; text-align: center;">
                            <span class="badge" style="background-color: ${product.category_color}; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                                ${product.category_name}
                            </span>
                        </td>
                        <td style="padding: 15px; text-align: right; font-weight: 600;">
                            ₱${parseFloat(product.price).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            ${product.quantity} ${product.unit}
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <span class="product-status status-${product.status.toLowerCase()}">
                                ${product.status}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <div class="product-actions">
                                <button class="action-btn edit-btn" onclick="editProduct(${product.id})">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="action-btn delete-btn" onclick="deleteProduct(${product.id})">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            })
            .catch(error => {
                console.error('Error loading products:', error);
                productsTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
                                <i class="bi bi-exclamation-circle" style="font-size: 48px; color: #dc3545;"></i>
                                <h3 style="margin: 0; color: #666;">Error loading products</h3>
                                <p style="margin: 0; color: #888;">${error.message}</p>
                            </div>
                        </td>
                    </tr>
                `;
            });
    }

    // Event Listeners for modal close
    const closeButtons = document.querySelectorAll('.close');
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            productsModal.style.display = 'none';
        });
    });

    window.addEventListener('click', (e) => {
        if (e.target === productsModal) {
            productsModal.style.display = 'none';
        }
    });

    // Add escape key listener to close modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && productsModal.style.display === 'block') {
            productsModal.style.display = 'none';
        }
    });

    categoryFilter.addEventListener('change', () => {
        currentPage = 1;
        loadProducts(currentPage);
    });

    productSearch.addEventListener('input', debounce(() => {
        currentPage = 1;
        loadProducts(currentPage);
    }, 500));

    prevPageBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            loadProducts(currentPage - 1);
        }
    });

    nextPageBtn.addEventListener('click', () => {
        if (currentPage < totalPages) {
            loadProducts(currentPage + 1);
        }
    });

    // Utility function for debouncing
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Function to edit product
    function editProduct(id) {
        // Implement edit functionality
        console.log('Edit product:', id);
    }

    // Function to delete product
    function deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            // Implement delete functionality
            console.log('Delete product:', id);
        }
    }

    // Add button to open products modal
    const openProductsBtn = document.createElement('button');
    openProductsBtn.className = 'action-btn';
    openProductsBtn.style.cssText = 'position: fixed; bottom: 20px; right: 20px; padding: 12px 20px; background-color: var(--hoockers-green); color: white; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);';
    openProductsBtn.innerHTML = '<i class="bi bi-box"></i> View My Products';
    openProductsBtn.onclick = () => {
        productsModal.style.display = 'block';
        loadProducts();
    };
    document.body.appendChild(openProductsBtn);

    // Add this script to enhance the category selection
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category_id');
        
        // Function to update the select's background color based on the selected option
        function updateSelectColor() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const color = selectedOption.getAttribute('data-color');
            if (color) {
                categorySelect.style.backgroundColor = color + '20';
            } else {
                categorySelect.style.backgroundColor = '';
            }
        }
        
        // Update color when selection changes
        categorySelect.addEventListener('change', updateSelectColor);
        
        // Initial color update
        updateSelectColor();
    });
    </script>
</body>
</html>
