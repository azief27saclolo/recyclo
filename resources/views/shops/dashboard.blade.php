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
            background: var(--hoockers-green);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin: 10px 0;
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

        /* Sidebar styles from profile page */
        .profile-container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .sidebar {
            width: 250px;
            background: var(--hoockers-green);
            padding: 20px;
            color: white;
            position: fixed;
            height: 100vh;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }

        .menu-item i {
            margin-right: 10px;
            font-size: 18px;
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
            padding: 30px;
            width: 80%;
            max-width: 800px;
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
        }

        .form-label {
            display: block;
            margin-bottom: 10px; /* Increased from 8px */
            font-weight: 600;
            color: #333;
            font-size: 18px; /* Increased from ~16px */
        }

        .form-control {
            width: 100%;
            padding: 12px; /* Increased from 10px */
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 18px; /* Increased from 16px */
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
            width: 100%;
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
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/mainlogo.png') }}" alt="Recyclo Logo">
                <h2>Recyclo</h2>
            </div>
            <nav>
                <a href="{{ url('/') }}" class="menu-item">
                    <i class="bi bi-house-door"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('profile') }}" class="menu-item">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('shop.dashboard') }}" class="menu-item active">
                    <i class="bi bi-shop"></i>
                    <span>My Shop</span>
                </a>
                <a href="{{ route('buy.index') }}" class="menu-item">
                    <i class="bi bi-bag"></i>
                    <span>Buy Requests</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bi bi-shield-lock"></i>
                    <span>Privacy Settings</span>
                </a>
                <form action="{{ route('logout') }}" method="GET" id="logout-form" style="display: none;">
                    <!-- Remove @csrf token since it's not needed for GET requests -->
                </form>
                <a href="#" class="menu-item" style="color: #dc3545;" onclick="confirmLogout(event)">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="shop-container">
                <div class="shop-header">
                    <h1>{{ $shop->shop_name }}</h1>
                    <p>{{ $shop->shop_address }}</p>
                    
                    <div class="shop-stats">
                        <div class="stat-card">
                            <i class="bi bi-box-seam"></i>
                            <div class="stat-number">{{ Auth::user()->posts()->count() ?? 0 }}</div>
                            <div>Products</div>
                        </div>
                        <div class="stat-card" id="ordersStatCard" style="cursor: pointer;">
                            <i class="bi bi-cart-check"></i>
                            <div class="stat-number">{{ Auth::user()->soldOrders()->count() ?? 0 }}</div>
                            <div>Orders</div>
                        </div>
                        <div class="stat-card">
                            <i class="bi bi-currency-dollar"></i>
                            <div class="stat-number">
                                @php
                                    try {
                                        $earnings = Auth::user()->soldOrders()->sum('total_amount') ?? 0;
                                        echo '₱' . number_format($earnings, 2);
                                    } catch (\Exception $e) {
                                        echo '₱0.00';
                                    }
                                @endphp
                            </div>
                            <div>Earnings</div>
                        </div>
                    </div>
                </div>

                <div class="quick-actions">
                    <a href="#" class="action-btn" id="addProductBtn">
                        <i class="bi bi-plus-circle"></i> Add Product
                    </a>
                    <a href="{{ route('orders.index') }}" class="action-btn">
                        <i class="bi bi-list-check"></i> Manage Orders
                    </a>
                    <a href="{{ route('profile') }}" class="action-btn">
                        <i class="bi bi-gear"></i> Shop Settings
                    </a>
                    <a href="{{ route('posts') }}" class="action-btn">
                        <i class="bi bi-grid"></i> All Products
                    </a>
                </div>

                <div class="recent-products">
                    <h2>Recent Products</h2>
                    <div class="product-grid">
                        @php
                            $recentProducts = Auth::user()->posts()->latest()->take(5)->get();
                        @endphp
                        
                        @if(count($recentProducts) > 0)
                            @foreach($recentProducts as $product)
                                <div class="product-card">
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}">
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
                <h2 class="modal-title">Recent Orders</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
                    <label for="order-status-filter" style="margin-right: 10px; font-weight: 600;">Filter by Status:</label>
                    <select id="order-status-filter" class="form-control" style="display: inline-block; width: auto; padding: 8px;">
                        <option value="all">All Orders</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    
                    <div class="search-box">
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
                        <tbody>
                            @php
                                $soldOrders = Auth::user()->soldOrders()->latest()->take(20)->get();
                            @endphp
                            
                            @if(count($soldOrders) > 0)
                                @foreach($soldOrders as $order)
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 12px;">#ORD-{{ $order->id }}</td>
                                        <td style="padding: 12px;">{{ $order->user->username ?? 'Customer' }}</td>
                                        <td style="padding: 12px;">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td style="padding: 12px;">{{ $order->post->title ?? 'Product' }} ({{ $order->quantity }} {{ $order->post->unit ?? 'units' }})</td>
                                        <td style="padding: 12px; text-align: right;">₱{{ number_format($order->total_amount ?? ($order->quantity * $order->post->price), 2) }}</td>
                                        <td style="padding: 12px; text-align: center;">
                                            @php
                                                $statusColor = [
                                                    'pending' => '#ffc107',
                                                    'processing' => '#17a2b8',
                                                    'shipped' => '#007bff',
                                                    'delivered' => '#28a745',
                                                    'cancelled' => '#dc3545'
                                                ];
                                                $status = $order->status ?? 'pending';
                                                $color = $statusColor[$status] ?? '#ffc107';
                                            @endphp
                                            <span class="status-badge" style="background-color: {{ $color }}; color: {{ in_array($status, ['pending']) ? '#212529' : 'white' }}; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td style="padding: 12px; text-align: center;">
                                            <button class="view-order-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;" data-order-id="{{ $order->id }}">View</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" style="padding: 20px; text-align: center;">No orders found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    
                    <div style="margin-top: 20px; text-align: center;">
                        <button class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; margin: 0 5px; cursor: pointer;">Previous</button>
                        <button class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; margin: 0 5px; cursor: pointer;">Next</button>
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
            cancelButtonText: 'No, stay'
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
                confirmButtonText: 'OK'
            });
        @endif

        // Check for delete message in session and show popup
        @if(session('delete'))
            Swal.fire({
                title: 'Deleted!',
                text: "{{ session('delete') }}",
                icon: 'warning',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'OK'
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
                    cancelButtonText: 'No, keep it'
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
        const ordersCloseBtn = ordersModal.querySelector('.close');

        // Open orders modal when Orders stat card is clicked
        ordersStatCard.addEventListener('click', function() {
            ordersModal.style.display = 'block';
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
        const statusFilter = document.getElementById('order-status-filter');
        const searchInput = document.getElementById('order-search');
        const orderRows = document.querySelectorAll('.orders-table tbody tr');

        function filterOrders() {
            const statusValue = statusFilter.value.toLowerCase();
            const searchValue = searchInput.value.toLowerCase();
            
            orderRows.forEach(row => {
                if (row.cells.length < 6) return; // Skip rows without enough cells (like "No orders found")
                
                const statusText = row.querySelector('.status-badge')?.textContent.toLowerCase() || '';
                const rowText = row.textContent.toLowerCase();
                
                const statusMatch = statusValue === 'all' || statusText === statusValue;
                const searchMatch = rowText.includes(searchValue);
                
                if (statusMatch && searchMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        statusFilter.addEventListener('change', filterOrders);
        searchInput.addEventListener('input', filterOrders);

        // View order button handlers
        document.querySelectorAll('.view-order-btn').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                const orderRow = this.closest('tr');
                
                // Get data from the row
                const orderNumber = orderRow.cells[0].textContent;
                const customer = orderRow.cells[1].textContent;
                const date = orderRow.cells[2].textContent;
                const items = orderRow.cells[3].textContent;
                const total = orderRow.cells[4].textContent;
                const status = orderRow.cells[5].textContent.trim();
                
                // Create order details HTML
                const orderDetailsHTML = `
                    <div style="text-align: left;">
                        <p><strong>Order ID:</strong> ${orderNumber}</p>
                        <p><strong>Customer:</strong> ${customer}</p>
                        <p><strong>Date:</strong> ${date}</p>
                        <p><strong>Items:</strong> ${items}</p>
                        <p><strong>Total Amount:</strong> ${total}</p>
                        <p><strong>Status:</strong> ${status}</p>
                        <hr>
                        <p><strong>Shipping Address:</strong> ${customer}'s Default Address</p>
                        <p><strong>Contact Number:</strong> Not available</p>
                        <p><strong>Payment Method:</strong> Cash on Delivery</p>
                        
                        <div style="margin-top: 20px;">
                            <h4 style="font-weight: 600; margin-bottom: 10px;">Update Order Status</h4>
                            <select id="update-status" class="form-control" style="width: 100%; padding: 8px; margin-bottom: 10px;">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <button id="update-status-btn" class="submit-btn" style="width: 100%;">Update Status</button>
                        </div>
                    </div>
                `;
                
                // Inject HTML into the modal
                document.getElementById('orderDetailsContent').innerHTML = orderDetailsHTML;
                
                // Show the modal
                document.getElementById('orderDetailsModal').style.display = 'block';
                
                // Close order details modal
                const orderDetailsCloseBtn = document.getElementById('orderDetailsModal').querySelector('.close');
                orderDetailsCloseBtn.addEventListener('click', function() {
                    document.getElementById('orderDetailsModal').style.display = 'none';
                });
                
                // Close order details modal when clicking outside
                window.addEventListener('click', function(e) {
                    if (e.target === document.getElementById('orderDetailsModal')) {
                        document.getElementById('orderDetailsModal').style.display = 'none';
                    }
                });
                
                // Update Status button click
                document.getElementById('update-status-btn').addEventListener('click', function() {
                    const newStatus = document.getElementById('update-status').value;
                    
                    Swal.fire({
                        title: 'Update Order Status',
                        text: `Are you sure you want to change the status to ${newStatus}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#517A5B',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, update it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Here you would usually make an AJAX call to update the status
                            // For now, just show a success message
                            Swal.fire(
                                'Updated!',
                                'Order status has been updated.',
                                'success'
                            ).then(() => {
                                // Close the modal after status update
                                document.getElementById('orderDetailsModal').style.display = 'none';
                            });
                        }
                    });
                });
            });
        });
    });
    </script>
</body>
</html>
