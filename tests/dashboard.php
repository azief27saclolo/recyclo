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
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
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
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: var(--hoockers-green);
            outline: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .submit-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .submit-btn:hover {
            background: var(--hoockers-green_80);
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
                        <div class="stat-card" id="ordersStatCard">id="ordersStatCard" style="cursor: pointer;">
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
                                    
                                    <!-- Add action buttons -->
                                    <div class="product-actions" style="margin-top: 10px; display: flex; justify-content: space-between;">
                                        <button class="action-btn edit-product-btn" 
                                                style="flex: 1; margin-right: 5px; font-size: 0.85rem; padding: 8px 5px;"
                                                data-product-id="{{ $product->id }}"
                                                data-product-title="{{ $product->title }}"
                                                data-product-category="{{ $product->category }}"
                                                data-product-location="{{ $product->location }}"
                                                data-product-unit="{{ $product->unit }}"
                                                data-product-quantity="{{ $product->quantity }}"
                                                data-product-price="{{ $product->price }}"
                                                data-product-description="{{ $product->description }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button class="action-btn delete-product-btn" 
                                                style="flex: 1; margin-left: 5px; font-size: 0.85rem; padding: 8px 5px; background-color: #dc3545;"
                                                data-product-id="{{ $product->id }}"
                                                data-product-title="{{ $product->title }}">
                                            <i class="bi bi-trash"></i> Delete
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

    <!-- Orders Modal -->ers Modal -->er Details Modal -->
    <div id="ordersModal" class="modal">dal">ss="modal">
        <div class="modal-content">nt" style="max-width: 900px;">nt">
            <div class="modal-header">ass="modal-header">ass="modal-header">
                <h2 class="modal-title">Orders</h2>ecent Orders</h2>rder Details</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">ainer">>
                <div class="form-group"> style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">ng> 12345</p>
                    <label class="form-label" for="order-status-filter">Filter by Status</label>oe</p>
                    <select id="order-status-filter" class="form-control">tus-filter" style="margin-right: 10px; font-weight: 600;">Filter by Status:</label>Example Product</p>
                        <option value="all">All</option>r-status-filter" class="form-control" style="display: inline-block; width: auto; padding: 8px;">rong> 2</p>
                        <option value="pending">Pending</option>option value="all">All Orders</option>tal Amount:</strong> ₱500.00</p>
                        <option value="processing">Processing</option>alue="pending">Pending</option>trong> Shipped</p>
                        <option value="completed">Completed</option>g</option>
                        <option value="cancelled">Cancelled</option>               <option value="shipped">Shipped</option>>
                    </select>                 <option value="delivered">Delivered</option>
                </div>                   </select>
                <div class="form-group">                    </div>    <script>
                    <label class="form-label" for="order-search">Search Orders</label>arch-box">{
                    <input type="text" id="order-search" class="form-control" placeholder="Search by customer name, order ID, etc.">lass="form-control" placeholder="Search orders..." style="padding: 8px;">
                </div>
                <table class="orders-table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr>le="max-height: 500px; overflow-y: auto;">
                            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Order ID</th>                    <table class="orders-table" style="width: 100%; border-collapse: collapse;">            showCancelButton: true,
                            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Customer</th>
                            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Date</th>olor: var(--hoockers-green); color: white;">
                            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Items</th> <th style="padding: 12px; text-align: left;">Order ID</th>'Yes, logout',
                            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Total Amount</th>"padding: 12px; text-align: left;">Customer</th>
                            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Status</th>                     <th style="padding: 12px; text-align: left;">Date</th>then((result) => {
                            <th style="border-bottom: 1px solid #ddd; padding: 10px;">Actions</th>                                <th style="padding: 12px; text-align: left;">Items</th>            if (result.isConfirmed) {
                        </tr>e="padding: 12px; text-align: right;">Total</th>'logout-form').submit();
                    </thead>x; text-align: center;">Status</th>
                    <tbody>="padding: 12px; text-align: center;">Actions</th>
                        @foreach($orders as $order)                 </tr>
                            <tr>                        </thead>
                                <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->id }}</td>
                                <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->customer_name }}</td>() {
                                <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->created_at->format('Y-m-d') }}</td>="border-bottom: 1px solid #eee;">
                                <td style="border-bottom: 1px solid #ddd; padding: 10px;">{{ $order->items_count }}</td>dding: 12px;">#ORD-2023-001</td>('addProductModal');
                                <td style="border-bottom: 1px solid #ddd; padding: 10px;">₱{{ number_format($order->total_amount, 2) }}</td>                   <td style="padding: 12px;">Juan Dela Cruz</td> btn = document.getElementById('addProductBtn');
                                <td style="border-bottom: 1px solid #ddd; padding: 10px;">                     <td style="padding: 12px;">May 15, 2023</td>st closeBtn = modal.querySelector('.close');
                                    <span class="status-badge" style="padding: 5px 10px; border-radius: 5px; background-color: {{ $order->status_color }}; color: white;">{{ ucfirst($order->status) }}</span>                                <td style="padding: 12px;">Aluminum Cans (20kg)</td>
                                </td>adding: 12px; text-align: right;">₱1,600.00</td>n is clicked
                                <td style="border-bottom: 1px solid #ddd; padding: 10px;">center;">
                                    <button class="action-btn view-order-btn" style="font-size: 0.85rem; padding: 8px 5px;">style="background-color: #ffc107; color: #212529; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;">Pending</span>
                                        <i class="bi bi-eye"></i> View
                                    </button>                        <td style="padding: 12px; text-align: center;">});
                                </td><button class="view-order-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;">View</button>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>>

    <script>board (10kg)</td>
    function confirmLogout(event) {>
        event.preventDefault();                <td style="padding: 12px; text-align: center;">
        Swal.fire({color: #17a2b8; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;">Processing</span>
            title: 'Logout Confirmation',
            text: "Do you really want to logout?",                <td style="padding: 12px; text-align: center;">itModal = document.getElementById('editProductModal');
            icon: 'question',tton class="view-order-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;">View</button>querySelector('.close');
            showCancelButton: true,
            confirmButtonColor: '#517A5B',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'No, stay'
        }).then((result) => {d>
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();                <td style="padding: 12px;">May 20, 2023</td>const productCategory = this.getAttribute('data-product-category');
            }td style="padding: 12px;">PET Bottles (30kg)</td>tion = this.getAttribute('data-product-location');
        });: 12px; text-align: right;">₱2,250.00</td>ute('data-product-unit');
    }                 <td style="padding: 12px; text-align: center;"> const productQuantity = this.getAttribute('data-product-quantity');
                         <span class="status-badge" style="background-color: #007bff; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;">Shipped</span>     const productPrice = this.getAttribute('data-product-price');
    // Product Modal Functionality                        </td>        const productDescription = this.getAttribute('data-product-description');
    document.addEventListener('DOMContentLoaded', function() {dding: 12px; text-align: center;">
        // Get modal elementser-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;">View</button>m posts.index to posts
        const modal = document.getElementById('addProductModal');osts') }}/${productId}`;
        const btn = document.getElementById('addProductBtn');                 </tr>     
        const closeBtn = modal.querySelector('.close');                            // Populate form fields
>le').value = productTitle;
        // Orders Modal1px solid #eee;">').value = productCategory;
        const ordersModal = document.getElementById('ordersModal');="padding: 12px;">#ORD-2023-004</td>edit-location').value = productLocation;
        const ordersStatCard = document.getElementById('ordersStatCard');g: 12px;">Elena Gonzales</td>t').value = productUnit;
        const ordersCloseBtn = ordersModal.querySelector('.close');                   <td style="padding: 12px;">May 22, 2023</td>   document.getElementById('edit-quantity').value = productQuantity;
                     <td style="padding: 12px;">Scrap Metal (50kg), Electronic Waste (5kg)</td>     document.getElementById('edit-price').value = productPrice;
        // Open orders modal when Orders stat card is clicked                        <td style="padding: 12px; text-align: right;">₱4,250.00</td>        document.getElementById('edit-description').value = productDescription;
        ordersStatCard.addEventListener('click', function() {yle="padding: 12px; text-align: center;">
            ordersModal.style.display = 'block';ound-color: #28a745; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;">Delivered</span>
        });
enter;">
        // Close orders modal when X is clickedkground-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;">View</button>
        ordersCloseBtn.addEventListener('click', function() {                </td>
            ordersModal.style.display = 'none'; </tr> when X is clicked
        });{

        // Close orders modal when clicking outsidee="border-bottom: 1px solid #eee;">
        window.addEventListener('click', function(e) {padding: 12px;">#ORD-2023-005</td>
            if (e.target === ordersModal) {: 12px;">Roberto Mendoza</td>
                ordersModal.style.display = 'none';g: 12px;">May 25, 2023</td>(e) {
            }">Glass Bottles (25kg)</td>
        }); 12px; text-align: right;">₱1,875.00</td>
tyle="padding: 12px; text-align: center;">
        // View order button handlerss="status-badge" style="background-color: #ffc107; color: #212529; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;">Pending</span>
        document.querySelectorAll('.view-order-btn').forEach(button => {
            button.addEventListener('click', function() {: center;">
                Swal.fire({lass="view-order-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;">View</button>oduct-btn').forEach(button => {
                    title: 'Order Details',
                    html: `
                        <div style="text-align: left;"></tbody>oductTitle = this.getAttribute('data-product-title');
                            <p><strong>Order ID:</strong> ${this.closest('tr').cells[0].textContent}</p>
                            <p><strong>Customer:</strong> ${this.closest('tr').cells[1].textContent}</p>
                            <p><strong>Date:</strong> ${this.closest('tr').cells[2].textContent}</p>
                            <p><strong>Items:</strong> ${this.closest('tr').cells[3].textContent}</p>p: 20px; text-align: center;">uctTitle}"? This cannot be undone.`,
                            <p><strong>Total Amount:</strong> ${this.closest('tr').cells[4].textContent}</p>ton class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; margin: 0 5px; cursor: pointer;">Previous</button>: 'warning',
                            <p><strong>Status:</strong> ${this.closest('tr').cells[5].textContent.trim()}</p>
                            <hr>tyle="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; margin: 0 5px; cursor: pointer;">Next</button>
                            <p><strong>Shipping Address:</strong> 123 Sample Street, Barangay Sample, City Sample, 1234</p>
                            <p><strong>Contact Number:</strong> +63 912 345 6789</p>
                            <p><strong>Payment Method:</strong> Cash on Delivery</p>xt: 'No, keep it'
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#517A5B',ut(event) {const form = document.createElement('form');
                    confirmButtonText: 'Close'
                }); form.action = `{{ route('posts') }}/${productId}`; // Fix the route name
            });'Logout Confirmation',     form.style.display = 'none';
            text: "Do you really want to logout?",     
            icon: 'question',  const csrfToken = document.createElement('input');
            showCancelButton: true, // Filter functionality                 csrfToken.type = 'hidden';
            confirmButtonColor: '#517A5B', statusFilter = document.getElementById('order-status-filter');           csrfToken.name = '_token';
            cancelButtonColor: '#6c757d', const searchInput = document.getElementById('order-search');                 csrfToken.value = '{{ csrf_token() }}';
            confirmButtonText: 'Yes, logout', const orderRows = document.querySelectorAll('.orders-table tbody tr');                 
            cancelButtonText: 'No, stay'                        const methodField = document.createElement('input');





































































































































</html></body>    </script>    });        });            });                });                    }                        form.submit();                                                document.body.appendChild(form);                        form.appendChild(methodField);                        form.appendChild(csrfToken);                                                methodField.value = 'DELETE';                        methodField.name = '_method';                        methodField.type = 'hidden';                        const methodField = document.createElement('input');                                                csrfToken.value = '{{ csrf_token() }}';                        csrfToken.name = '_token';                        csrfToken.type = 'hidden';                        const csrfToken = document.createElement('input');                                                form.style.display = 'none';                        form.action = `{{ route('posts') }}/${productId}`; // Fix the route name                        form.method = 'POST';                        const form = document.createElement('form');                        // Create form and submit for DELETE request                    if (result.isConfirmed) {                }).then((result) => {                    cancelButtonText: 'No, keep it'                    confirmButtonText: 'Yes, delete it!',                    cancelButtonColor: '#6c757d',                    confirmButtonColor: '#dc3545',                    showCancelButton: true,                    icon: 'warning',                    text: `Do you really want to delete "${productTitle}"? This cannot be undone.`,                    title: 'Are you sure?',                Swal.fire({                                const productTitle = this.getAttribute('data-product-title');                const productId = this.getAttribute('data-product-id');            button.addEventListener('click', function() {        document.querySelectorAll('.delete-product-btn').forEach(button => {        // Delete Product Button Click                });            }                editModal.style.display = 'none';            if (e.target === editModal) {        window.addEventListener('click', function(e) {        // Close edit modal when clicking outside                });            editModal.style.display = 'none';        editCloseBtn.addEventListener('click', function() {        // Close edit modal when X is clicked                });            });                editModal.style.display = 'block';                // Show the modal                                document.getElementById('edit-description').value = productDescription;                document.getElementById('edit-price').value = productPrice;                document.getElementById('edit-quantity').value = productQuantity;                document.getElementById('edit-unit').value = productUnit;                document.getElementById('edit-location').value = productLocation;                document.getElementById('edit-category').value = productCategory;                document.getElementById('edit-title').value = productTitle;                // Populate form fields                                editProductForm.action = `{{ route('posts') }}/${productId}`;                // Set form action - Fix the route name from posts.index to posts                                const productDescription = this.getAttribute('data-product-description');                const productPrice = this.getAttribute('data-product-price');                const productQuantity = this.getAttribute('data-product-quantity');                const productUnit = this.getAttribute('data-product-unit');                const productLocation = this.getAttribute('data-product-location');                const productCategory = this.getAttribute('data-product-category');                const productTitle = this.getAttribute('data-product-title');                const productId = this.getAttribute('data-product-id');            button.addEventListener('click', function() {        document.querySelectorAll('.edit-product-btn').forEach(button => {        // Edit Product Button Click                const editProductForm = document.getElementById('editProductForm');        const editCloseBtn = editModal.querySelector('.close');        const editModal = document.getElementById('editProductModal');        // Get modal elements for edit modal        });            }                modal.style.display = 'none';            if (e.target === modal) {        window.addEventListener('click', function(e) {        // Close modal when clicking outside the modal        });            modal.style.display = 'none';        closeBtn.addEventListener('click', function() {        // Close modal when X is clicked        });            modal.style.display = 'block';            e.preventDefault();        btn.addEventListener('click', function(e) {        // Open modal when Add Product button is clicked        }            });                }                    row.style.display = 'none';                } else {                    row.style.display = '';                if (statusMatch && searchMatch) {                                const searchMatch = rowText.includes(searchValue);                const statusMatch = statusValue === 'all' || statusText === statusValue;                                const rowText = row.textContent.toLowerCase();                const statusText = row.querySelector('.status-badge').textContent.toLowerCase();            orderRows.forEach(row => {            const searchValue = searchInput.value.toLowerCase();            const statusValue = statusFilter.value.toLowerCase();        function filterOrders() {        searchInput.addEventListener('input', filterOrders);        statusFilter.addEventListener('change', filterOrders);




























































































































</html></body>    </script>    });        });            });                });                    }                        form.submit();                                                document.body.appendChild(form);                        form.appendChild(methodField);                        form.appendChild(csrfToken);                                                methodField.value = 'DELETE';                        methodField.name = '_method';                        methodField.type = 'hidden';                        const methodField = document.createElement('input');                                                csrfToken.value = '{{ csrf_token() }}';                        csrfToken.name = '_token';                        csrfToken.type = 'hidden';                        const csrfToken = document.createElement('input');                                                form.style.display = 'none';                        form.action = `{{ route('posts') }}/${productId}`; // Fix the route name                        form.method = 'POST';                        const form = document.createElement('form');                        // Create form and submit for DELETE request                    if (result.isConfirmed) {                }).then((result) => {                    cancelButtonText: 'No, keep it'                    confirmButtonText: 'Yes, delete it!',                    cancelButtonColor: '#6c757d',                    confirmButtonColor: '#dc3545',                    showCancelButton: true,                    icon: 'warning',                    text: `Do you really want to delete "${productTitle}"? This cannot be undone.`,                    title: 'Are you sure?',                Swal.fire({                                const productTitle = this.getAttribute('data-product-title');                const productId = this.getAttribute('data-product-id');            button.addEventListener('click', function() {        document.querySelectorAll('.delete-product-btn').forEach(button => {        // Delete Product Button Click                });            }                editModal.style.display = 'none';            if (e.target === editModal) {        window.addEventListener('click', function(e) {        // Close edit modal when clicking outside                });            editModal.style.display = 'none';        editCloseBtn.addEventListener('click', function() {        // Close edit modal when X is clicked                });            });                editModal.style.display = 'block';                // Show the modal                                document.getElementById('edit-description').value = productDescription;                document.getElementById('edit-price').value = productPrice;                document.getElementById('edit-quantity').value = productQuantity;                document.getElementById('edit-unit').value = productUnit;                document.getElementById('edit-location').value = productLocation;                document.getElementById('edit-category').value = productCategory;                document.getElementById('edit-title').value = productTitle;                // Populate form fields                                editProductForm.action = `{{ route('posts') }}/${productId}`;                // Set form action - Fix the route name from posts.index to posts                                const productDescription = this.getAttribute('data-product-description');                const productPrice = this.getAttribute('data-product-price');                const productQuantity = this.getAttribute('data-product-quantity');                const productUnit = this.getAttribute('data-product-unit');                const productLocation = this.getAttribute('data-product-location');                const productCategory = this.getAttribute('data-product-category');                const productTitle = this.getAttribute('data-product-title');                const productId = this.getAttribute('data-product-id');            button.addEventListener('click', function() {        document.querySelectorAll('.edit-product-btn').forEach(button => {        // Edit Product Button Click                const editProductForm = document.getElementById('editProductForm');        const editCloseBtn = editModal.querySelector('.close');        const editModal = document.getElementById('editProductModal');        // Get modal elements for edit modal        });            }                modal.style.display = 'none';            if (e.target === modal) {        window.addEventListener('click', function(e) {        // Close modal when clicking outside the modal        });            modal.style.display = 'none';        closeBtn.addEventListener('click', function() {        // Close modal when X is clicked        });            modal.style.display = 'block';            e.preventDefault();        btn.addEventListener('click', function(e) {        // Open modal when Add Product button is clicked        const closeBtn = modal.querySelector('.close');        const btn = document.getElementById('addProductBtn');        const modal = document.getElementById('addProductModal');        // Get modal elements    document.addEventListener('DOMContentLoaded', function() {    // Product Modal Functionality    }        });            }                document.getElementById('logout-form').submit();            if (result.isConfirmed) {        }).then((result) => {                        methodField.type = 'hidden';
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

        // Order Details Modal Functionality
        const ordersStatCard = document.getElementById('ordersStatCard');
        const orderDetailsModal = document.getElementById('orderDetailsModal');
        const orderDetailsCloseBtn = orderDetailsModal.querySelector('.close');

        // Open order details modal when Orders stat card is clicked
        ordersStatCard.addEventListener('click', function() {
            orderDetailsModal.style.display = 'block';
        });

        // Close order details modal when X is clicked
        orderDetailsCloseBtn.addEventListener('click', function() {
            orderDetailsModal.style.display = 'none';
        });

        // Close order details modal when clicking outside the modal
        window.addEventListener('click', function(e) {
            if (e.target === orderDetailsModal) {
                orderDetailsModal.style.display = 'none';
            }
        });
    });
    </script>
</body>
</html>
