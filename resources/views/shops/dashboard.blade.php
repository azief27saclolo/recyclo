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
                                        // Only count earnings from delivered orders
                                        // Apply 10% commission fee deduction (multiply by 0.9)
                                        $totalEarnings = \App\Models\Order::where('seller_id', Auth::id())
                                                    ->where('status', 'delivered')
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
                                                data-product-category="{{ $product->category }}"
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
                    <label class="form-label" for="category">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">--Select--</option>
                        <option value="Metal">Metal</option>
                        <option value="Plastic">Plastic</option>
                        <option value="Paper">Paper</option>
                        <option value="Glass">Glass</option>
                        <option value="Wood">Wood</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fabric">Fabric</option>
                        <option value="Rubber">Rubber</option>
                    </select>
                    @error('category')
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
                    <label class="form-label" for="edit-category">Category</label>
                    <select name="category" id="edit-category" class="form-control" required>
                        <option value="">--Select--</option>
                        <option value="Metal">Metal</option>
                        <option value="Plastic">Plastic</option>
                        <option value="Paper">Paper</option>
                        <option value="Glass">Glass</option>
                        <option value="Wood">Wood</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fabric">Fabric</option>
                        <option value="Rubber">Rubber</option>
                    </select>
                    @error('category')
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

    <!-- Orders Modal -->
    <div id="ordersModal" class="modal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h2 class="modal-title">Orders</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 15px; display: flex; align-items: center;">
                    <label for="order-status-filter" style="margin-right: 3px; font-weight: 600;">Filter by Status:</label>
                    <select id="order-status-filter" class="form-control" style="display: inline-block; width: auto; padding: 8px;">
                        <option value="all">All Orders</option>
                        <option value="processing">Processing</option>
                        <option value="delivering">Delivering</option>
                        <option value="for_pickup">For Pick Up</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    
                    <div class="search-box" style="margin-left: auto;">
                        <input type="text" id="order-search" class="form-control" placeholder="Search orders..." style="padding: 8px;">
                    </div>
                </div>
                
                <div style="max-height: 500px; overflow-y: auto;">
                    <table class="orders-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white;">
                                <th style="padding: 12px; text-align: left;">Order ID</th>
                                <th style="padding: 12px; text-align: left;">Customer</th>
                                <th style="padding: 12px; text-align: left;">Date</th>
                                <th style="padding: 12px; text-align: left;">Items</th>
                                <th style="padding: 12px; text-align: right;">Total</th>
                                <th style="padding: 12px; text-align: center;">Status</th>
                                <th style="padding: 12px; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="orders-table-body">
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 20px;">Loading orders...</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="pagination-container" style="margin-top: 20px; text-align: center; display: flex; justify-content: center; gap: 10px;">
                        <button id="prev-page-btn" class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;" disabled>Previous</button>
                        <span id="pagination-info" style="align-self: center; padding: 0 10px;">Page 1</span>
                        <button id="next-page-btn" class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Order Details</h2>
                <span class="close">&times;</span>
            </div>
            <div id="orderDetailsContent" class="modal-body">
                <!-- Order details will be injected here -->
            </div>
        </div>
    </div>

    <!-- All Products Modal -->
    <div id="allProductsModal" class="modal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h2 class="modal-title">All Products</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                    <!-- Add category filter dropdown -->
                    <div class="category-filter">
                        <select id="category-filter" class="form-control" style="padding: 8px; min-width: 150px;">
                            <option value="all">All Categories</option>
                            <option value="Metal">Metal</option>
                            <option value="Plastic">Plastic</option>
                            <option value="Paper">Paper</option>
                            <option value="Glass">Glass</option>
                            <option value="Wood">Wood</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Fabric">Fabric</option>
                            <option value="Rubber">Rubber</option>
                        </select>
                    </div>
                    
                    <div class="search-box" style="margin-left: auto;">
                        <input type="text" id="product-search" class="form-control" placeholder="Search products..." style="padding: 8px;">
                    </div>
                </div>
                
                <div id="all-products-container" style="max-height: 500px; overflow-y: auto;">
                    <div class="product-grid" id="allProductsGrid">
                        <div class="loading-spinner" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                            <i class="bi bi-arrow-repeat" style="font-size: 48px; animation: spin 1s linear infinite;"></i>
                            <p>Loading products...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Settings Modal -->
    <div id="shopSettingsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Shop Settings</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form id="shopSettingsForm" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label class="form-label" for="shop-name">Shop Name</label>
                        <input type="text" name="shop_name" id="shop-name" class="form-control" placeholder="Enter shop name..." value="{{ $shop->shop_name }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="shop-address">Shop Location</label>
                        <input type="text" name="shop_address" id="shop-address" class="form-control" placeholder="Enter shop location..." value="{{ $shop->shop_address }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="shop-image">Shop Banner Image (Optional)</label>
                        <input type="file" name="shop_image" id="shop-image" class="form-control" accept="image/*">
                        <small style="display: block; margin-top: 5px; color: #666;">Leave empty to keep current image</small>
                    </div>

                    @if($shop->image)
                    <div class="form-group">
                        <label class="form-label">Current Banner</label>
                        <div style="width: 100%; max-height: 150px; overflow: hidden; border-radius: 8px;">
                            <img src="{{ asset('storage/' . $shop->image) }}" alt="Shop Banner" style="width: 100%; object-fit: cover;">
                        </div>
                    </div>
                    @endif

                    <div class="form-group" style="margin-bottom: 0;">
                        <button type="submit" class="submit-btn">Update Shop Settings</button>
                    </div>
                </form>
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
                const productCategory = this.getAttribute('data-product-category');
                const productLocation = this.getAttribute('data-product-location');
                const productUnit = this.getAttribute('data-product-unit');
                const productQuantity = this.getAttribute('data-product-quantity');
                const productPrice = this.getAttribute('data-product-price');
                const productDescription = this.getAttribute('data-product-description');
                
                // Set form action - Fix the route name from posts.index to posts
                editProductForm.action = `{{ route('posts') }}/${productId}`;
                
                // Populate form fields
                document.getElementById('edit-title').value = productTitle;
                document.getElementById('edit-category').value = productCategory;
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

        // Orders Modal Functionality
        const ordersModal = document.getElementById('ordersModal');
        const ordersStatCard = document.getElementById('ordersStatCard');
        const manageOrdersBtn = document.getElementById('manageOrdersBtn');
        const ordersCloseBtn = ordersModal.querySelector('.close');
        
        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 5;
        let totalPages = 1;
        let statusFilter = 'all';
        let searchQuery = '';
        
        // Open orders modal when Orders stat card is clicked
        ordersStatCard.addEventListener('click', function() {
            ordersModal.style.display = 'block';
            loadOrders(1);
        });

        // Open orders modal when Manage Orders button is clicked
        manageOrdersBtn.addEventListener('click', function() {
            ordersModal.style.display = 'block';
            loadOrders(1);
        });

        // Close orders modal when X is clicked
        ordersCloseBtn.addEventListener('click', function() {
            ordersModal.style.display = 'none';
        });

        // Close orders modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === ordersModal) {
                ordersModal.style.display = 'none';
            }
        });

        // Filter functionality for orders
        const statusFilterSelect = document.getElementById('order-status-filter');
        const searchInput = document.getElementById('order-search');
        
        // Pagination buttons
        const prevPageBtn = document.getElementById('prev-page-btn');
        const nextPageBtn = document.getElementById('next-page-btn');
        const paginationInfo = document.getElementById('pagination-info');

        statusFilterSelect.addEventListener('change', function() {
            statusFilter = this.value;
            currentPage = 1; // Reset to first page when filter changes
            loadOrders(currentPage);
        });
        
        searchInput.addEventListener('input', function() {
            searchQuery = this.value;
            currentPage = 1; // Reset to first page when search changes
            loadOrders(currentPage);
        });
        
        // Handle pagination button clicks
        prevPageBtn.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                loadOrders(currentPage);
            }
        });
        
        nextPageBtn.addEventListener('click', function() {
            if (currentPage < totalPages) {
                currentPage++;
                loadOrders(currentPage);
            }
        });
        
        // Function to load orders with pagination
        function loadOrders(page) {
            const ordersTableBody = document.getElementById('orders-table-body');
            
            // Show loading state
            ordersTableBody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">
                        <i class="bi bi-arrow-repeat" style="font-size: 24px; animation: spin 1s linear infinite; display: inline-block; margin-right: 10px;"></i>
                        Loading orders...
                    </td>
                </tr>
            `;
            
            // Fetch orders from server
            fetch(`/shop/orders?page=${page}&status=${statusFilter}&search=${searchQuery}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok (Status: ${response.status})`);
                }
                return response.json();
            })
            .then(data => {
                // Update pagination state
                currentPage = data.current_page;
                totalPages = data.last_page;
                
                // Update pagination UI
                prevPageBtn.disabled = currentPage <= 1;
                nextPageBtn.disabled = currentPage >= totalPages;
                paginationInfo.textContent = `Page ${currentPage} of ${totalPages}`;
                
                // Clear table
                ordersTableBody.innerHTML = '';
                
                if (data.data.length === 0) {
                    ordersTableBody.innerHTML = `
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px;">No orders found</td>
                        </tr>
                    `;
                    return;
                }
                
                // Append orders to table
                data.data.forEach(order => {
                    const statusColor = {
                        'pending': '#ffc107',
                        'processing': '#17a2b8',
                        'delivering': '#007bff',
                        'for_pickup': '#28a745',
                        'cancelled': '#dc3545'
                    };
                    
                    const status = order.status || 'pending';
                    const color = statusColor[status] || '#ffc107';
                    const textColor = status === 'pending' ? '#212529' : 'white';
                    
                    ordersTableBody.innerHTML += `
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;">#ORD-${order.id}</td>
                            <td style="padding: 12px;">${order.customer_name || 'Customer'}</td>
                            <td style="padding: 12px;">${new Date(order.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                            <td style="padding: 12px;">${order.product_title || 'Product'} (${order.quantity} ${order.unit || 'units'})</td>
                            <td style="padding: 12px; text-align: right;">₱${parseFloat(order.total_amount).toFixed(2)}</td>
                            <td style="padding: 12px; text-align: center;">
                                <span class="status-badge" style="background-color: ${color}; color: ${textColor}; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;">
                                    ${status.charAt(0).toUpperCase() + status.slice(1)}
                                </span>
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                <button class="view-order-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;" 
                                    data-order-id="${order.id}"
                                    data-customer-name="${order.customer_name || 'Customer'}">
                                    View
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                // Add event listeners to view order buttons
                addViewOrderEventListeners();
            })
            .catch(error => {
                console.error('Error loading orders:', error);
                ordersTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #dc3545;">
                            Error loading orders. Please try again.
                        </td>
                    </tr>
                `;
            });
        }
        
        // Function to add event listeners to view order buttons
        function addViewOrderEventListeners() {
            document.querySelectorAll('.view-order-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    const customerName = this.getAttribute('data-customer-name');
                    
                    // Fetch order details
                    fetch(`/shop/orders/${orderId}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(order => {
                        // Create order details HTML
                        const orderDetailsHTML = `
                            <div style="text-align: left;">
                                <p><strong>Order ID:</strong> #ORD-${order.id}</p>
                                <p><strong>Customer:</strong> ${order.customer_name || 'Customer'}</p>
                                <p><strong>Date:</strong> ${new Date(order.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</p>
                                <p><strong>Items:</strong> ${order.product_title || 'Product'} (${order.quantity} ${order.unit || 'units'})</p>
                                <p><strong>Total Amount:</strong> ₱${parseFloat(order.total_amount).toFixed(2)}</p>
                                <p><strong>Status:</strong> ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</p>
                                <hr>
                                <p><strong>Shipping Address:</strong> ${order.address || 'Not available'}</p>
                                <p><strong>Contact Number:</strong> ${order.contact || 'Not available'}</p>
                                <p><strong>Payment Method:</strong> Cash on Delivery</p>
                                
                                <div style="margin-top: 20px;">
                                    <h4 style="font-weight: 600; margin-bottom: 10px;">Update Order Status</h4>
                                    <select id="update-status" class="form-control" style="width: 100%; padding: 8px; margin-bottom: 10px;">
                                        <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>Processing</option>
                                        <option value="delivering" ${order.status === 'delivering' ? 'selected' : ''}>Delivering</option>
                                        <option value="for_pickup" ${order.status === 'for_pickup' ? 'selected' : ''}>For Pick Up</option>
                                        <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                    </select>
                                    <button id="update-status-btn" data-order-id="${order.id}" class="submit-btn" style="width: 100%;">Update Status</button>
                                </div>
                            </div>
                        `;
                        
                        // Inject HTML into the modal
                        document.getElementById('orderDetailsContent').innerHTML = orderDetailsHTML;
                        
                        // Show the modal
                        document.getElementById('orderDetailsModal').style.display = 'block';
                        
                        // Update Status button click
                        document.getElementById('update-status-btn').addEventListener('click', function() {
                            const newStatus = document.getElementById('update-status').value;
                            const orderId = this.getAttribute('data-order-id');
                            
                            updateOrderStatus(orderId, newStatus);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching order details:', error);
                        Swal.fire({
                            title: 'Error', 
                            text: 'Failed to load order details. Please try again.', 
                            icon: 'error',
                            customClass: {
                                popup: 'bigger-modal'
                            }
                        });
                    });
                });
            });
        }
        
        // Function to update order status
        function updateOrderStatus(orderId, newStatus) {
            Swal.fire({
                title: 'Update Order Status',
                text: `Are you sure you want to change the status to ${newStatus}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#517A5B',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update it',
                customClass: {
                    popup: 'bigger-modal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to update the order status
                    fetch(`/orders/${orderId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Updated!',
                                text: 'Order status has been updated.',
                                icon: 'success',
                                customClass: {
                                    popup: 'bigger-modal'
                                }
                            }).then(() => {
                                // Close the modal after status update
                                document.getElementById('orderDetailsModal').style.display = 'none';
                                // Reload orders to reflect changes
                                loadOrders(currentPage);
                            });
                        } else {
                            Swal.fire({
                                title: 'Error', 
                                text: data.message || 'Failed to update order status', 
                                icon: 'error',
                                customClass: {
                                    popup: 'bigger-modal'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error updating status:', error);
                        Swal.fire({
                            title: 'Error', 
                            text: 'Something went wrong. Please try again.', 
                            icon: 'error',
                            customClass: {
                                popup: 'bigger-modal'
                            }
                        });
                    });
                }
            });
        }

        // View order button handlers
        // ...rest of the existing code...

        // All Products Modal Functionality
        const allProductsModal = document.getElementById('allProductsModal');
        const allProductsBtn = document.getElementById('allProductsBtn');
        const allProductsCloseBtn = allProductsModal.querySelector('.close');
        const productsStatCard = document.getElementById('productsStatCard');
        
        // Open all products modal when All Products button is clicked
        allProductsBtn.addEventListener('click', function() {
            allProductsModal.style.display = 'block';
            loadAllProducts();
        });
        
        // Open all products modal when Products stat card is clicked
        productsStatCard.addEventListener('click', function() {
            allProductsModal.style.display = 'block';
            loadAllProducts();
        });
        
        // Close all products modal when X is clicked
        allProductsCloseBtn.addEventListener('click', function() {
            allProductsModal.style.display = 'none';
        });
        
        // Close all products modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === allProductsModal) {
                allProductsModal.style.display = 'none';
            }
        });
        
        // Load all products
        function loadAllProducts() {
            const productsContainer = document.getElementById('allProductsGrid');
            
            // Show loading spinner
            productsContainer.innerHTML = `
                <div class="loading-spinner" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <i class="bi bi-arrow-repeat" style="font-size: 48px; animation: spin 1s linear infinite;"></i>
                    <p>Loading products...</p>
                </div>
            `;
            
            // Fix: Use the correct route URL with error handling
            fetch('{{ route("user.products") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok (Status: ${response.status})`);
                }
                return response.json();
            })
            .then(data => {
                // Clear loading spinner
                productsContainer.innerHTML = '';
                
                if (data.products.length === 0) {
                    productsContainer.innerHTML = `
                        <div class="empty-state" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                            <i class="bi bi-box"></i>
                            <h3>No products yet</h3>
                            <p>Start selling by adding your first product</p>
                            <button id="emptyStateAddBtn" class="action-btn" style="display: inline-block; margin-top: 15px;">
                                <i class="bi bi-plus-circle"></i> Add Product
                            </button>
                        </div>
                    `;
                    
                    document.getElementById('emptyStateAddBtn').addEventListener('click', function() {
                        allProductsModal.style.display = 'none';
                        document.getElementById('addProductBtn').click();
                    });
                    
                    return;
                }
                
                // Create product cards
                data.products.forEach(product => {
                    const productCard = document.createElement('div');
                    productCard.className = 'product-card';
                    productCard.setAttribute('data-category', product.category);
                    
                    const imagePath = product.image ? "{{ asset('storage') }}/" + product.image : "{{ asset('images/placeholder.png') }}";
                    
                    productCard.innerHTML = `
                        <img src="${imagePath}" alt="${product.title}">
                        <h3>${product.title}</h3>
                        <p>₱${parseFloat(product.price).toFixed(2)}</p>
                        <p><span class="badge" style="background-color: var(--hoockers-green); color: white; padding: 3px 8px; border-radius: 12px; font-size: 12px;">${product.category}</span></p>
                        <p>Stock: ${product.quantity ?? 'N/A'}</p>
                        
                        <div class="product-actions" style="margin-top: 15px; display: flex; justify-content: space-between;">
                            <button class="action-btn edit-product-btn" 
                                    style="flex: 1; margin-right: 5px; font-size: 16px; padding: 12px 10px; height: 48px;"
                                    data-product-id="${product.id}"
                                    data-product-title="${product.title}"
                                    data-product-category="${product.category}"
                                    data-product-location="${product.location}"
                                    data-product-unit="${product.unit}"
                                    data-product-quantity="${product.quantity}"
                                    data-product-price="${product.price}"
                                    data-product-description="${product.description || ''}">
                                <i class="bi bi-pencil" style="font-size: 18px;"></i> Edit
                            </button>
                            <button class="action-btn delete-product-btn" 
                                    style="flex: 1; margin-left: 5px; font-size: 16px; padding: 12px 10px; height: 48px; background-color: #dc3545;"
                                    data-product-id="${product.id}"
                                    data-product-title="${product.title}">
                                <i class="bi bi-trash" style="font-size: 18px;"></i> Delete
                            </button>
                        </div>
                    `;
                    
                    productsContainer.appendChild(productCard);
                });
                
                // Add event listeners to the new buttons
                addButtonEventListeners();
            })
            .catch(error => {
                console.error('Error loading products:', error);
                productsContainer.innerHTML = `
                    <div class="error-state" style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #dc3545;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 48px;"></i>
                        <h3>Error loading products</h3>
                        <p>Something went wrong. Please try again later.</p>
                        <p>Details: ${error.message}</p>
                    </div>
                `;
            });
        }
        
        // Add event listeners to edit and delete buttons
        function addButtonEventListeners() {
            // Add event listeners to edit buttons
            document.querySelectorAll('#allProductsGrid .edit-product-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productTitle = this.getAttribute('data-product-title');
                    const productCategory = this.getAttribute('data-product-category');
                    const productLocation = this.getAttribute('data-product-location');
                    const productUnit = this.getAttribute('data-product-unit');
                    const productQuantity = this.getAttribute('data-product-quantity');
                    const productPrice = this.getAttribute('data-product-price');
                    const productDescription = this.getAttribute('data-product-description');
                    
                    // Close all products modal
                    allProductsModal.style.display = 'none';
                    
                    // Set form action
                    editProductForm.action = `{{ route('posts') }}/${productId}`;
                    
                    // Populate form fields
                    document.getElementById('edit-title').value = productTitle;
                    document.getElementById('edit-category').value = productCategory;
                    document.getElementById('edit-location').value = productLocation;
                    document.getElementById('edit-unit').value = productUnit;
                    document.getElementById('edit-quantity').value = productQuantity;
                    document.getElementById('edit-price').value = productPrice;
                    document.getElementById('edit-description').value = productDescription;
                    
                    // Show the edit modal
                    document.getElementById('editProductModal').style.display = 'block';
                });
            });
            
            // Add event listeners to delete buttons
            document.querySelectorAll('#allProductsGrid .delete-product-btn').forEach(button => {
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
                            form.action = `{{ route('posts') }}/${productId}`;
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
        }
        
        // Filter products with search input and category dropdown
        const productSearchInput = document.getElementById('product-search');
        const categoryFilter = document.getElementById('category-filter');
        
        function filterProducts() {
            const searchTerm = productSearchInput.value.toLowerCase();
            const categoryValue = categoryFilter.value;
            const productCards = document.querySelectorAll('#allProductsGrid .product-card');
            
            productCards.forEach(card => {
                const productTitle = card.querySelector('h3').textContent.toLowerCase();
                const productCategory = card.getAttribute('data-category') || '';
                
                const matchesSearch = productTitle.includes(searchTerm);
                const matchesCategory = categoryValue === 'all' || productCategory === categoryValue;
                
                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        productSearchInput.addEventListener('input', filterProducts);
        categoryFilter.addEventListener('change', filterProducts);
        
        // Shop Settings Modal Functionality
        const shopSettingsModal = document.getElementById('shopSettingsModal');
        const shopSettingsBtn = document.getElementById('shopSettingsBtn');
        const shopSettingsCloseBtn = shopSettingsModal.querySelector('.close');
        const shopSettingsForm = document.getElementById('shopSettingsForm');
        
        // Open shop settings modal when Shop Settings button is clicked
        shopSettingsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            shopSettingsModal.style.display = 'block';
        });
        
        // Close shop settings modal when X is clicked
        shopSettingsCloseBtn.addEventListener('click', function() {
            shopSettingsModal.style.display = 'none';
        });
        
        // Close shop settings modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === shopSettingsModal) {
                shopSettingsModal.style.display = 'none';
            }
        });
        
        // Handle shop settings form submission
        shopSettingsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Create form data object from the form
            const formData = new FormData(shopSettingsForm);
            
            // Send AJAX request
            fetch('{{ route("shop.update") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok (Status: ${response.status})`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Close the modal
                    shopSettingsModal.style.display = 'none';
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'Shop settings updated successfully!',
                        icon: 'success',
                        confirmButtonColor: '#517A5B',
                        customClass: {
                            popup: 'bigger-modal'
                        }
                    }).then(() => {
                        // Reload the page to reflect changes
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Failed to update shop settings');
                }
            })
            .catch(error => {
                console.error('Error updating shop settings:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Something went wrong. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#517A5B',
                    customClass: {
                        popup: 'bigger-modal'
                    }
                });
            });
        });
        
        // ...existing code...
    });
    </script>
</body>
</html>
