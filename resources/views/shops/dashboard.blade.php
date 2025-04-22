<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shop->shop_name }} - Shop Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        .shop-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .shop-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .shop-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background-color: #517A5B !important; /* Explicit color instead of variable */
            color: white !important;
            border-radius: 10px;
            text-align: center;
            height: 100px; /* Ensure minimum height */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin: -5px 0;
            min-height: 2.5rem; /* Ensure height even when empty */
            color: white !important; /* Ensure number is visible */
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .action-btn {
            background: var(--hoockers-green);
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: var(--hoockers-green_80);
            transform: translateY(-2px);
        }

        .recent-products {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-top: 30px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .product-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }

        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        /* Navbar styles */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--hoockers-green);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .navbar-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 20px;
        }

        .nav-item a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-item a:hover {
            color: var(--hoockers-green);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        @media (max-width: 768px) {
            .shop-stats {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                grid-template-columns: 1fr 1fr;
            }
            
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }

        /* Profile container and main content styles */
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

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 50px auto;
            padding: 20px; /* Reduced padding */
            width: 90%; /* Increased width from 80% */
            max-width: 900px; /* Increased from 800px */
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            padding-left: 5px; /* Added smaller padding */
            padding-right: 5px; /* Added smaller padding */
        }

        .modal-title {
            color: var(--hoockers-green);
            font-size: 32px; /* Increased from 24px */
            font-weight: 600;
            margin: 0;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 36px; /* Increased from 28px */
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 24px; /* Increased from 20px */
            padding: 0 5px; /* Reduced horizontal padding */
            width: 100%; /* Ensure full width */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .form-label {
            display: block;
            margin-bottom: 10px; /* Increased from 8px */
            font-weight: 600;
            color: #333;
            font-size: 18px; /* Increased from ~16px */
        }

        .form-control {
            width: 100%; /* Full width */
            padding: 12px; /* Increased from 10px */
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 18px; /* Increased from 16px */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .form-control:focus {
            border-color: var(--hoockers-green);
            outline: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 16px; /* Increased from 14px */
            margin-top: 5px;
        }

        .submit-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 16px 25px; /* Increased height */
            border-radius: 8px;
            cursor: pointer;
            font-size: 20px; /* Increased from 16px */
            width: calc(100% - 10px); /* Adjusted width with padding consideration */
            margin: 0 5px; /* Centered with small margin */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .submit-btn:hover {
            background: var(--hoockers-green_80);
        }
        
        /* Modal body content text size */
        .modal-body p {
            font-size: 18px; /* Added larger text size for paragraphs */
            line-height: 28px; /* Added for better readability */
            margin-bottom: 10px;
        }
        
        /* Modal dialog text */
        #orderDetailsContent p {
            font-size: 18px; /* Larger text for order details */
        }
        
        #orderDetailsContent h4 {
            font-size: 22px; /* Larger heading in order details */
        }

        /* Specific styles for add/edit product forms */
        #addProductModal form, #editProductModal form {
            width: 100%;
        }

        #addProductModal .form-group, #editProductModal .form-group {
            width: 100%;
        }

        /* Ensure textareas expand fully */
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Loading spinner animation */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .pagination-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .pagination-btn {
            background-color: var(--hoockers-green);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            cursor: pointer;
        }
        
        .pagination-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
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
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Use the sidebar component instead of hardcoded sidebar -->
        <x-sidebar activePage="shop" />

        <!-- Main Content -->
        <div class="main-content">
            <div class="shop-container">
                <div class="shop-header">
                    <h1>{{ $shop->shop_name }}</h1>
                    <p>{{ $shop->shop_address }}</p>
                    
                    <div class="shop-stats">
                        <div class="stat-card" id="productsStatCard" style="background-color: #517A5B; color: white; cursor: pointer;">
                            <i class="bi bi-box-seam"></i>
                            <div class="stat-number" style="color: white;">
                                @php
                                    try {
                                        // Use direct DB query for reliable count
                                        $productsCount = \App\Models\Post::where('user_id', Auth::id())->count();
                                        echo $productsCount;
                                    } catch (\Exception $e) {
                                        echo '0';
                                    }
                                @endphp
                            </div>
                            <div style="color: white;">Products</div>
                        </div>
                        <div class="stat-card" id="ordersStatCard" style="background-color: #517A5B; color: white; cursor: pointer;">
                            <i class="bi bi-cart-check"></i>
                            <div class="stat-number" style="color: white;">
                                @php
                                    try {
                                        // Use direct DB query for reliable count
                                        $ordersCount = \App\Models\Order::where('seller_id', Auth::id())->count();
                                        echo $ordersCount;
                                    } catch (\Exception $e) {
                                        echo '0';
                                    }
                                @endphp
                            </div>
                            <div style="color: white;">Orders</div>
                        </div>
                        <div class="stat-card" style="background-color: #517A5B; color: white;">
                            <i class="bi bi-currency-dollar"></i>
                            <div class="stat-number" style="color: white;">
                                @php
                                    try {
                                        // Only count earnings from completed orders
                                        // Apply 10% commission fee deduction (multiply by 0.9)
                                        $totalEarnings = \App\Models\Order::where('seller_id', Auth::id())
                                                    ->where('status', 'completed')
                                                    ->sum('total_amount');
                                        $netEarnings = $totalEarnings * 0.9; // Deduct 10% commission fee
                                        echo '₱' . number_format($netEarnings ?? 0, 2);
                                    } catch (\Exception $e) {
                                        echo '₱0.00';
                                    }
                                @endphp
                            </div>
                            <div style="color: white;">Earnings (after 10% fee)</div>
                        </div>
                    </div>
                </div>

                <div class="quick-actions">
                    <a href="#" class="action-btn" id="addProductBtn">
                        <i class="bi bi-plus-circle"></i> Add Product
                    </a>
                    <button id="manageOrdersBtn" class="action-btn" style="border: none; display: block; width: 100%; text-align: center; cursor: pointer;">
                        <i class="bi bi-list-check"></i> Manage Orders
                    </button>
                    <button id="shopSettingsBtn" class="action-btn" style="border: none; display: block; width: 100%; text-align: center; cursor: pointer;">
                        <i class="bi bi-gear"></i> Shop Settings
                    </button>
                    <button id="allProductsBtn" class="action-btn" style="border: none; display: block; width: 100%; text-align: center; cursor: pointer;">
                        <i class="bi bi-grid"></i> All Products
                    </button>
                </div>

                <div class="recent-products">
                    <h2>Recent Products</h2>
                    <div class="product-grid">
                        @php
                            try {
                                $recentProducts = \App\Models\Post::where('user_id', Auth::id())
                                    ->latest()
                                    ->take(4) // Changed from 5 to 4
                                    ->get();
                            } catch (\Exception $e) {
                                $recentProducts = collect([]);
                            }
                        @endphp
                        
                        @if(count($recentProducts) > 0)
                            @foreach($recentProducts as $product)
                                <div class="product-card">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
                                    @else
                                        <img src="{{ asset('images/placeholder.png') }}" alt="No image">
                                    @endif
                                    <h3>{{ $product->title }}</h3>
                                    <p>₱{{ number_format($product->price, 2) }}</p>
                                    <p>Stock: {{ $product->quantity ?? 'N/A' }}</p>
                                    
                                    <!-- Updated action buttons with larger size -->
                                    <div class="product-actions" style="margin-top: 15px; display: flex; justify-content: space-between;">
                                        <button class="action-btn edit-product-btn" 
                                                style="flex: 1; margin-right: 5px; font-size: 16px; padding: 12px 10px; height: 48px;"
                                                data-product-id="{{ $product->id }}"
                                                data-product-title="{{ $product->title }}"
                                                data-product-category-id="{{ $product->category_id }}"
                                                data-product-location="{{ $product->location }}"
                                                data-product-unit="{{ $product->unit }}"
                                                data-product-quantity="{{ $product->quantity }}"
                                                data-product-price="{{ $product->price }}"
                                                data-product-description="{{ $product->description }}">
                                            <i class="bi bi-pencil" style="font-size: 18px;"></i> Edit
                                        </button>
                                        <button class="action-btn delete-product-btn" 
                                                style="flex: 1; margin-left: 5px; font-size: 16px; padding: 12px 10px; height: 48px; background-color: #dc3545;"
                                                data-product-id="{{ $product->id }}"
                                                data-product-title="{{ $product->title }}">
                                            <i class="bi bi-trash" style="font-size: 18px;"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="bi bi-box"></i>
                                <h3>No products yet</h3>
                                <p>Start selling by adding your first product</p>
                                <a href="{{ route('posts.create') }}" class="action-btn" style="display: inline-block; margin-top: 15px;">
                                    <i class="bi bi-plus-circle"></i> Add Product
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Form Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add New Product</h2>
                <span class="close">&times;</span>
            </div>
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="title">Product Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter product title..." required>
                    @error('title')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">--Select--</option>
                        @foreach(\App\Models\Category::where('is_active', true)->orderBy('name')->get() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control" placeholder="Enter location..." required>
                    @error('location')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="unit">Unit</label>
                    <select name="unit" id="unit" class="form-control" required>
                        <option value="">--Select--</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="g">Gram (g)</option>
                        <option value="lb">Pound (lb)</option>
                        <option value="L">Liter (L)</option>
                        <option value="m3">Cubic Meter (m3)</option>
                        <option value="gal">Gallon (gal)</option>
                        <option value="pc">Per Piece (pc)</option>
                        <option value="dz">Per Dozen (dz)</option>
                        <option value="bndl">Per Bundle (bndl)</option>
                        <option value="sack">Per Sack (sack)</option>
                        <option value="bale">Per Bale (bale)</option>
                        <option value="roll">Per Roll (roll)</option>
                        <option value="drum">Per Drum (drum)</option>
                        <option value="box">Per Box (box)</option>
                        <option value="pallet">Per Pallet (pallet)</option>
                    </select>
                    @error('unit')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity..." required>
                    @error('quantity')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="price">Price per unit</label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="Enter price..." required>
                    <button type="button" id="pricesGuideBtn" class="btn btn-link" style="padding: 0; margin-top: 5px; color: var(--hoockers-green); display: block; text-decoration: none; font-weight: 500;">
                        <i class="bi bi-info-circle"></i> Prices Guide
                    </button>
                    @error('price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter description..."></textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="image">Photo</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    @error('image')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">Add Product</button>
            </form>
        </div>
    </div>

    <!-- Edit Product Form Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Product</h2>
                <span class="close">&times;</span>
            </div>
            
            <form id="editProductForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="edit-title">Product Title</label>
                    <input type="text" name="title" id="edit-title" class="form-control" placeholder="Enter product title..." required>
                    @error('title')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit-category_id">Category</label>
                    <select name="category_id" id="edit-category_id" class="form-control" required>
                        <option value="">--Select--</option>
                        @foreach(\App\Models\Category::where('is_active', true)->orderBy('name')->get() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit-location">Location</label>
                    <input type="text" name="location" id="edit-location" class="form-control" placeholder="Enter location..." required>
                    @error('location')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit-unit">Unit</label>
                    <select name="unit" id="edit-unit" class="form-control" required>
                        <option value="">--Select--</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="g">Gram (g)</option>
                        <option value="lb">Pound (lb)</option>
                        <option value="L">Liter (L)</option>
                        <option value="m3">Cubic Meter (m3)</option>
                        <option value="gal">Gallon (gal)</option>
                        <option value="pc">Per Piece (pc)</option>
                        <option value="dz">Per Dozen (dz)</option>
                        <option value="bndl">Per Bundle (bndl)</option>
                        <option value="sack">Per Sack (sack)</option>
                        <option value="bale">Per Bale (bale)</option>
                        <option value="roll">Per Roll (roll)</option>
                        <option value="drum">Per Drum (drum)</option>
                        <option value="box">Per Box (box)</option>
                        <option value="pallet">Per Pallet (pallet)</option>
                    </select>
                    @error('unit')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit-quantity">Quantity</label>
                    <input type="number" name="quantity" id="edit-quantity" class="form-control" placeholder="Enter quantity..." required>
                    @error('quantity')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit-price">Price per unit</label>
                    <input type="text" name="price" id="edit-price" class="form-control" placeholder="Enter price..." required>
                    <button type="button" id="editPricesGuideBtn" class="btn btn-link" style="padding: 0; margin-top: 5px; color: var(--hoockers-green); display: block; text-decoration: none; font-weight: 500;">
                        <i class="bi bi-info-circle"></i> Prices Guide
                    </button>
                    @error('price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit-description">Description</label>
                    <textarea name="description" id="edit-description" class="form-control" rows="4" placeholder="Enter description..."></textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit-image">Photo (leave blank to keep current image)</label>
                    <input type="file" name="image" id="edit-image" class="form-control" accept="image/*">
                    <small style="display: block; margin-top: 5px; color: #666;">Upload a new image only if you want to change the current one</small>
                    @error('image')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">Update Product</button>
            </form>
        </div>
    </div>

    <!-- Prices Guide Modal -->
    <div id="pricesGuideModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Materials Price Guide</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <p>This guide provides current market prices for different types of recyclable materials.</p>
                
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

    <script>
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

    // Product Modal Functionality
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

        // Check for delete message in session and show popup
        @if(session('delete'))
            Swal.fire({
                title: 'Deleted!',
                text: "{{ session('delete') }}",
                icon: 'warning',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'bigger-modal'
                }
            });
        @endif

        // Get modal elements
        const modal = document.getElementById('addProductModal');
        const btn = document.getElementById('addProductBtn');
        const closeBtn = modal.querySelector('.close');

        // Open modal when Add Product button is clicked
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'block';
        });

        // Close modal when X is clicked
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Close modal when clicking outside the modal
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Get modal elements for edit modal
        const editModal = document.getElementById('editProductModal');
        const editCloseBtn = editModal.querySelector('.close');
        const editProductForm = document.getElementById('editProductForm');
        
        // Edit Product Button Click
        document.querySelectorAll('.edit-product-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productTitle = this.getAttribute('data-product-title');
                const productCategoryId = this.getAttribute('data-product-category-id');
                const productLocation = this.getAttribute('data-product-location');
                const productUnit = this.getAttribute('data-product-unit');
                const productQuantity = this.getAttribute('data-product-quantity');
                const productPrice = this.getAttribute('data-product-price');
                const productDescription = this.getAttribute('data-product-description');
                
                // Set form action - Fix the route name from posts.index to posts
                editProductForm.action = `{{ route('posts') }}/${productId}`;
                
                // Populate form fields
                document.getElementById('edit-title').value = productTitle;
                document.getElementById('edit-category_id').value = productCategoryId;
                document.getElementById('edit-location').value = productLocation;
                document.getElementById('edit-unit').value = productUnit;
                document.getElementById('edit-quantity').value = productQuantity;
                document.getElementById('edit-price').value = productPrice;
                document.getElementById('edit-description').value = productDescription;
                
                // Reset the file input field to ensure it's empty
                document.getElementById('edit-image').value = '';
                
                // Show the modal
                editModal.style.display = 'block';
            });
        });
        
        // Close edit modal when X is clicked
        editCloseBtn.addEventListener('click', function() {
            editModal.style.display = 'none';
        });
        
        // Close edit modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === editModal) {
                editModal.style.display = 'none';
            }
        });
        
        // Delete Product Button Click
        document.querySelectorAll('.delete-product-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productTitle = this.getAttribute('data-product-title');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you really want to delete "${productTitle}"? This cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it',
                    customClass: {
                        popup: 'bigger-modal'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create form and submit for DELETE request
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('posts') }}/${productId}`; // Fix the route name
                        form.style.display = 'none';
                        
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        
                        form.submit();
                    }
                });
            });
        });

        // Prices Guide Modal Functionality
        const pricesGuideModal = document.getElementById('pricesGuideModal');
        const pricesGuideBtn = document.getElementById('pricesGuideBtn');
        const editPricesGuideBtn = document.getElementById('editPricesGuideBtn');
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
        
        // Open prices guide modal when any of the buttons are clicked
        pricesGuideBtn.addEventListener('click', function() {
            pricesGuideModal.style.display = 'block';
        });
        
        editPricesGuideBtn.addEventListener('click', function() {
            pricesGuideModal.style.display = 'block';
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
    });
    </script>
</body>
</html>
