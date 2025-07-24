<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management - Recyclo Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Add SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: var(--hoockers-green);
            padding: 20px;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            left: 0;
            top: 0;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 290px;
            min-height: 100vh;
            width: calc(100% - 290px);
            box-sizing: border-box;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }

        .logo-section {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .logo-section img {
            width: 45px;
            height: 45px;
            margin-right: 15px;
        }

        .logo-section h2 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 600;
        }

        .products-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .products-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .products-heading h1 {
            color: var(--hoockers-green);
            margin: 0;
            font-size: 1.8rem;
        }

        .search-filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 3;
            min-width: 200px;
        }

        .category-filter {
            flex: 1;
            min-width: 180px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .table th {
            background-color: #f8f9fa;
            color: var(--hoockers-green);
            font-weight: 600;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge.metal { background-color: #B8C6DB; color: #333; }
        .badge.plastic { background-color: #A3D9CA; color: #333; }
        .badge.paper { background-color: #F9EBDE; color: #333; }
        .badge.glass { background-color: #D4F1F9; color: #333; }
        .badge.electronics { background-color: #FEE5E0; color: #333; }
        .badge.wood { background-color: #E6D7B9; color: #333; }
        .badge.fabric { background-color: #F1E3D3; color: #333; }
        .badge.rubber { background-color: #DBDBDB; color: #333; }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }

        .btn {
            padding: 6px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: var(--hoockers-green);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--hoockers-green_80);
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-warning {
            background-color: #ffc107;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
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
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 60%;
            max-width: 800px;
        }
        
        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .modal-title {
            color: var(--hoockers-green);
            font-size: 1.5rem;
            margin: 0;
        }
        
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: #333;
        }
        
        .product-details {
            display: flex;
            gap: 20px;
        }
        
        .product-image {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
        
        .product-info {
            flex: 1;
        }
        
        .info-group {
            margin-bottom: 15px;
        }
        
        .info-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 1.1rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        /* Add responsive styling for smaller screens */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .admin-container {
                flex-direction: column;
            }
            .modal-content {
                width: 90%;
            }
            .product-details {
                flex-direction: column;
            }
            .product-image {
                width: 100%;
                height: auto;
            }
        }

        /* Add styles for the edit modal */
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            padding-top: 15px;
            border-top: 1px solid #eee;
            margin-top: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        /* Category management styles */
        .category-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .category-badge {
            display: inline-block;
            background-color: #f0f0f0;
            border-radius: 20px;
            padding: 5px 12px;
            margin: 5px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .category-badge:hover {
            background-color: #e0e0e0;
        }

        .category-badge .remove-icon {
            margin-left: 5px;
            color: #dc3545;
        }

        .categories-modal {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Action buttons styling - updated for visibility */
        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 2px;
            visibility: visible !important;
            opacity: 1 !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: transparent; /* Ensure transparent background */
        }
        
        /* Specific color styling for each button type */
        .action-buttons .btn-primary {
            color: var(--hoockers-green) !important;
            border: 1px solid var(--hoockers-green);
        }
        
        .action-buttons .btn-warning {
            color: #ffc107 !important;
            border: 1px solid #ffc107;
        }
        
        .action-buttons .btn-danger {
            color: #dc3545 !important;
            border: 1px solid #dc3545;
        }
        
        /* Icon styling to ensure visibility */
        .action-buttons .btn i {
            font-size: 1rem;
            color: inherit;
        }
        
        .action-buttons form {
            display: inline-block;
            margin: 0;
        }

        /* Also add this to ensure buttons are visible */
        .view-product, .edit-product, .btn-danger {
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Make tooltip text more readable */
        .tooltip-inner {
            font-size: 0.85rem;
            padding: 5px 10px;
        }

        /* Tab styling */
        .tab-container {
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
        }
        
        .tab-buttons {
            display: flex;
            gap: 10px;
        }
        
        .tab-btn {
            padding: 10px 20px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            color: #666;
            text-decoration: none;
        }
        
        .tab-btn.active {
            border-bottom: 3px solid var(--hoockers-green);
            color: var(--hoockers-green);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .badge-pending {
            background-color: #FFC107;
            color: #333;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            background: transparent;
            border: none;
            transition: transform 0.2s;
        }
        
        .btn-sm:hover {
            transform: scale(1.15);
            background: transparent;
        }
        
        .btn-sm:focus {
            box-shadow: none;
            background: transparent;
        }
        
        .d-flex {
            display: flex;
        }
        
        .gap-2 {
            gap: 0.5rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 0;
            color: #666;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        /* Add these styles to the existing <style> section */
        .category-prices-table .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center;
        }

        .category-prices-table .action-buttons .btn {
            visibility: visible;
            opacity: 1;
            padding: 5px 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .category-prices-table table {
            width: 100%;
            table-layout: fixed;
        }

        .category-prices-table th, 
        .category-prices-table td {
            padding: 10px;
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
            word-break: break-word;
        }

        .category-prices-table thead tr {
            background-color: var(--hoockers-green);
            color: white;
        }

        .category-prices-table tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <?php
    // Helper function to determine text color based on background color
    function getContrastColor($hexColor) {
        // Remove # if present
        $hexColor = str_replace('#', '', $hexColor);
        
        // Default to black if invalid hex color
        if (strlen($hexColor) != 6) {
            return '#000000';
        }
        
        // Convert hex to RGB
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        
        // Calculate luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        
        // Return black for light colors, white for dark colors
        return ($luminance > 0.5) ? '#000000' : '#ffffff';
    }
    ?>
    
    <div class="admin-container">
        <x-admin-sidebar activePage="products" />

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
            
            <div class="products-card">
                <div class="products-heading">
                    <h1><i class="bi bi-box-seam"></i> Products Management</h1>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <button id="pricesGuideBtn" class="btn btn-primary">
                            <i class="bi bi-cash-coin"></i> Manage Prices Guide
                        </button>
                        <button id="manageCategoriesBtn" class="btn btn-primary">
                            <i class="bi bi-tags"></i> Manage Categories
                        </button>
                    </div>
                </div>
                
                <div class="tab-container">
                    <div class="tab-buttons">
                        <button class="tab-btn active" data-tab="approved-products">
                            Approved Products
                        </button>
                        <button class="tab-btn" data-tab="pending-requests">
                            Pending Requests
                            @if(isset($pendingPostsCount) && $pendingPostsCount > 0)
                                <span class="badge badge-pending" style="margin-left: 5px;">
                                    {{ $pendingPostsCount }}
                                </span>
                            @endif
                        </button>
                    </div>
                </div>
                
                <!-- Approved Products Tab -->
                <div class="tab-content active" id="approved-products">
                    <div class="search-filters">
                        <div class="search-box">
                            <input type="text" id="productSearch" class="form-control" placeholder="Search products...">
                        </div>
                        <div class="category-filter">
                            <select id="categoryFilter" class="form-control">
                                <option value="">All Categories</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Price / Deal</th>
                                    <th>Quantity</th>
                                    <th>Seller</th>
                                    <th>Posted Date</th>
                                    <th>Deal Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($products) > 0)
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-img">
                                            @else
                                                <div style="width: 60px; height: 60px; background-color: #eee; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                    <i class="bi bi-image" style="font-size: 24px; color: #aaa;"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>
                                            @php
                                                // Determine if category is an object or string and set color accordingly
                                                $categoryColor = is_object($product->category) && isset($product->category->color) ? $product->category->color : '#f0f0f0';
                                                $categoryName = is_object($product->category) ? $product->category->name : $product->category;
                                            @endphp
                                            <span class="badge" style="background-color: {{ $categoryColor }}; color: {{ getContrastColor($categoryColor) }}">
                                                {{ $categoryName }}
                                            </span>
                                        </td>
                                        <td>
                                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                                <div style="font-weight: 600; color: #333;">
                                                    ₱{{ number_format($product->price, 2) }} / {{ $product->unit }}
                                                </div>
                                                @if($product->is_deal && $product->original_price && $product->original_price > $product->price)
                                                <div style="display: flex; align-items: center; gap: 6px;">
                                                    <span style="font-size: 12px; color: #999; text-decoration: line-through;">
                                                        ₱{{ number_format($product->original_price, 2) }}
                                                    </span>
                                                    <span style="background: linear-gradient(45deg, #ff416c, #ff4b2b); color: white; padding: 2px 6px; border-radius: 10px; font-size: 10px; font-weight: bold;">
                                                        {{ number_format($product->discount_percentage, 0) }}% OFF
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $product->quantity }} {{ $product->unit }}</td>
                                        <td>
                                            @if($product->user)
                                                {{ $product->user->firstname }} {{ $product->user->lastname }}
                                            @else
                                                Unknown
                                            @endif
                                        </td>
                                        <td>{{ $product->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                                @if($product->is_deal)
                                                    <span style="background: #28a745; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; text-align: center;">
                                                        🔥 DEAL
                                                    </span>
                                                    @if($product->is_featured_deal)
                                                    <span style="background: linear-gradient(45deg, #ffd700, #ffed4e); color: #333; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; text-align: center;">
                                                        ⭐ FEATURED
                                                    </span>
                                                    @endif
                                                    @if($product->deal_score > 0)
                                                    <div style="font-size: 10px; color: #666; text-align: center;">
                                                        Score: {{ number_format($product->deal_score, 1) }}
                                                    </div>
                                                    @endif
                                                @else
                                                    <span style="color: #666; font-size: 12px; text-align: center;">Regular</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-buttons" style="display: flex; flex-wrap: wrap; gap: 4px;">
                                                <button class="btn btn-sm btn-primary view-product" data-id="{{ $product->id }}" data-toggle="tooltip" title="View details" style="color: var(--hoockers-green); border: 1px solid var(--hoockers-green);">
                                                    <i class="bi bi-eye" style="color: var(--hoockers-green);"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning edit-product" data-id="{{ $product->id }}" data-toggle="tooltip" title="Edit product" style="color: #ffc107; border: 1px solid #ffc107;">
                                                    <i class="bi bi-pencil" style="color: #ffc107;"></i>
                                                </button>
                                                
                                                <!-- Deal Management Buttons -->
                                                @if($product->is_deal)
                                                    <button class="btn btn-sm btn-info toggle-featured" 
                                                            data-id="{{ $product->id }}" 
                                                            data-featured="{{ $product->is_featured_deal ? 'true' : 'false' }}"
                                                            data-toggle="tooltip" 
                                                            title="{{ $product->is_featured_deal ? 'Remove from Featured' : 'Make Featured' }}" 
                                                            style="color: #17a2b8; border: 1px solid #17a2b8;">
                                                        <i class="bi bi-star{{ $product->is_featured_deal ? '-fill' : '' }}" style="color: #17a2b8;"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-secondary remove-deal" 
                                                            data-id="{{ $product->id }}" 
                                                            data-toggle="tooltip" 
                                                            title="Remove Deal Status" 
                                                            style="color: #6c757d; border: 1px solid #6c757d;">
                                                        <i class="bi bi-x-circle" style="color: #6c757d;"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-success make-deal" 
                                                            data-id="{{ $product->id }}" 
                                                            data-toggle="tooltip" 
                                                            title="Create Deal" 
                                                            style="color: #28a745; border: 1px solid #28a745;">
                                                        <i class="bi bi-fire" style="color: #28a745;"></i>
                                                    </button>
                                                @endif
                                                
                                                <button type="button" class="btn btn-sm btn-danger delete-product" 
                                                        data-id="{{ $product->id }}" 
                                                        data-title="{{ $product->title }}"
                                                        data-toggle="tooltip" 
                                                        title="Delete product" 
                                                        style="color: #dc3545; border: 1px solid #dc3545;">
                                                    <i class="bi bi-trash" style="color: #dc3545;"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center">No products found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                
                <!-- Pending Requests Tab -->
                <div class="tab-content" id="pending-requests">
                    @if(count($pendingPosts) > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Seller</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingPosts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>
                                        @if($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="product-img">
                                        @else
                                            <div style="width: 60px; height: 60px; background-color: #eee; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                <i class="bi bi-image" style="font-size: 24px; color: #aaa;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        @php
                                            // Determine if category is an object or string and set color accordingly
                                            $categoryColor = is_object($post->category) && isset($post->category->color) ? $post->category->color : '#f0f0f0';
                                            $categoryName = is_object($post->category) ? $post->category->name : $post->category;
                                        @endphp
                                        <span class="badge" style="background-color: {{ $categoryColor }}; color: {{ getContrastColor($categoryColor) }}">
                                            {{ $categoryName }}
                                        </span>
                                    </td>
                                    <td>₱{{ number_format($post->price, 2) }} / {{ $post->unit }}</td>
                                    <td>{{ $post->quantity }} {{ $post->unit }}</td>
                                    <td>
                                        @if($post->user)
                                            {{ $post->user->firstname }} {{ $post->user->lastname }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm view-post" data-id="{{ $post->id }}" title="View Details" style="border: 1px solid var(--hoockers-green);">
                                                <i class="bi bi-eye-fill" style="color: var(--hoockers-green); font-size: 1.2rem;"></i>
                                            </button>
                                            <button class="btn btn-sm approve-post" data-id="{{ $post->id }}" data-title="{{ $post->title }}" title="Approve Post" style="border: 1px solid #28a745;">
                                                <i class="bi bi-check-circle-fill" style="color: #28a745; font-size: 1.2rem;"></i>
                                            </button>
                                            <button class="btn btn-sm reject-post" data-id="{{ $post->id }}" data-title="{{ $post->title }}" title="Reject Post" style="border: 1px solid #dc3545;">
                                                <i class="bi bi-x-circle-fill" style="color: #dc3545; font-size: 1.2rem;"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination">
                        {{ $pendingPosts->links('pagination::bootstrap-4') }}
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="bi bi-check2-circle"></i>
                        <h3>No pending post requests</h3>
                        <p>All post requests have been reviewed.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product View Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Product Details</h2>
                <span class="close">&times;</span>
            </div>
            <div class="product-details">
                <img src="" alt="Product Image" id="modalProductImage" class="product-image">
                <div class="product-info">
                    <div class="info-group">
                        <div class="info-label">Title</div>
                        <div class="info-value" id="modalProductTitle"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Category</div>
                        <div class="info-value" id="modalProductCategory"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Price</div>
                        <div class="info-value" id="modalProductPrice"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Quantity</div>
                        <div class="info-value" id="modalProductQuantity"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Seller</div>
                        <div class="info-value" id="modalProductSeller"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Location</div>
                        <div class="info-value" id="modalProductLocation"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Address</div>
                        <div class="info-value" id="modalProductAddress"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Posted Date</div>
                        <div class="info-value" id="modalProductDate"></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Description</div>
                        <div class="info-value" id="modalProductDescription"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Edit Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Product</h2>
                <span class="close" id="closeEditModal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editProductId" name="id">
                    
                    <div class="form-group">
                        <label for="editTitle">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editCategory">Category</label>
                        <select class="form-control" id="editCategory" name="category" required>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="editPrice">Price</label>
                        <div style="display: flex; align-items: center;">
                            <span style="margin-right: 5px;">₱</span>
                            <input type="number" step="0.01" class="form-control" id="editPrice" name="price" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="editUnit">Unit</label>
                        <input type="text" class="form-control" id="editUnit" name="unit" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editQuantity">Quantity</label>
                        <input type="number" class="form-control" id="editQuantity" name="quantity" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editLocation">Location</label>
                        <input type="text" class="form-control" id="editLocation" name="location" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="editAddress" name="address" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editDescription">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="4" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="editImage">Image (Leave empty to keep current image)</label>
                        <div class="mb-2">
                            <img id="currentProductImage" src="" alt="Current product image" style="max-width: 200px; max-height: 200px; display: none;">
                        </div>
                        <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelEdit">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Post View Modal -->
    <div id="postModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Post Request Details</h2>
                <span class="close" id="closePostModal">&times;</span>
            </div>
            <div class="post-details">
                <img src="" alt="Product Image" id="modalPostImage" style="max-width: 300px; max-height: 300px; object-fit: cover; border-radius: 10px; margin-bottom: 20px;">
                <div class="post-info" style="margin-bottom: 20px;">
                    <h3 id="modalPostTitle" style="color: var(--hoockers-green); margin-top: 0;"></h3>
                    <p><strong>Category:</strong> <span id="modalPostCategory"></span></p>
                    <p><strong>Price:</strong> <span id="modalPostPrice"></span></p>
                    <p><strong>Quantity:</strong> <span id="modalPostQuantity"></span></p>
                    <p><strong>Seller:</strong> <span id="modalPostSeller"></span></p>
                    <p><strong>Location:</strong> <span id="modalPostLocation"></span></p>
                    <p><strong>Address:</strong> <span id="modalPostAddress"></span></p>
                    <p><strong>Submitted on:</strong> <span id="modalPostDate"></span></p>
                    
                    <p><strong>Description:</strong></p>
                    <p id="modalPostDescription" style="background-color: #f8f9fa; padding: 10px; border-radius: 5px;"></p>
                </div>
                <div class="action-buttons" style="display: flex; gap: 10px; margin-top: 20px;">
                    <form id="approveForm" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle-fill" style="margin-right: 5px;"></i> Approve Post
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-danger" id="rejectBtn">
                        <i class="bi bi-x-circle-fill" style="margin-right: 5px;"></i> Reject Post
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Category Management Modal -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Manage Categories</h2>
                <span class="close" id="closeCategoryModal">&times;</span>
            </div>
            <div class="modal-body">
                <p>Add new categories or remove existing ones. When removing a category, you must select a replacement category for existing products.</p>
                <h3>Current Categories</h3>
                <div id="categoriesList" class="categories-modal"></div>
                <h3>Add New Category</h3>
                <div class="form-group">
                    <input type="text" id="newCategoryName" class="form-control" placeholder="Enter new category name">
                </div>
                <div class="form-group">
                    <label for="newCategoryDescription">Description (optional)</label>
                    <textarea id="newCategoryDescription" class="form-control" placeholder="Enter category description"></textarea>
                </div>
                <div class="form-group">
                    <label for="newCategoryColor">Color (optional)</label>
                    <input type="color" id="newCategoryColor" class="form-control" value="#517A5B">
                </div>
                <button id="addCategoryBtn" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Category
                </button>
                <h3>Remove Category</h3>
                <div class="form-group">
                    <label for="categoryToRemove">Select category to remove:</label>
                    <select id="categoryToRemove" class="form-control">
                        <option value="">Select a category</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="replacementCategory">Move products to:</label>
                    <select id="replacementCategory" class="form-control">
                        <option value="">Select a category</option>
                    </select>
                </div>
                <button id="removeCategoryBtn" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Remove Category
                </button>
            </div>
        </div>
    </div>
    
    <!-- Price Guide Management Modal -->
    <div id="pricesGuideModal" class="modal">
        <div class="modal-content" style="width: 80%; max-width: 1000px;">
            <div class="modal-header">
                <h2 class="modal-title">Manage Prices Guide</h2>
                <span class="close" id="closePricesGuideModal">&times;</span>
            </div>
            <div class="modal-body">
                <p>Manage price guides for different material categories. These price guides will be shown to users when they're selling items.</p>
                
                <!-- Category tabs -->
                <div style="display: flex; margin-bottom: 15px; overflow-x: auto; border-bottom: 1px solid #dee2e6;">
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
                
                <!-- Materials price tables container -->
                <div id="priceTablesContainer">
                    <!-- Plastic prices table (initially visible) -->
                    <div id="plasticPricesTable" class="category-prices-table">
                        <div class="action-buttons" style="margin-bottom: 15px; display: flex; justify-content: space-between;">
                            <h3 style="margin: 0;">Plastic Price Guide</h3>
                            <button id="addPlasticPrice" class="btn btn-primary add-price-btn">
                                <i class="bi bi-plus-circle"></i> Add New Price
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Type</th>
                                        <th style="width: 40%;">Description</th>
                                        <th style="width: 20%;">Buying Price (P/KG)</th>
                                        <th style="width: 15%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="plasticPricesTableBody">
                                    <!-- Price data will be loaded here -->
                                    <tr>
                                        <td colspan="4" class="text-center">Loading prices...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Paper prices table (initially hidden) -->
                    <div id="paperPricesTable" class="category-prices-table" style="display: none;">
                        <div class="action-buttons" style="margin-bottom: 15px; display: flex; justify-content: space-between;">
                            <h3 style="margin: 0;">Paper Price Guide</h3>
                            <button id="addPaperPrice" class="btn btn-primary add-price-btn">
                                <i class="bi bi-plus-circle"></i> Add New Price
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="background-color: var(--hoockers-green); color: white;">
                                        <th style="width: 25%;">Type</th>
                                        <th style="width: 40%;">Description</th>
                                        <th style="width: 20%;">Buying Price (P/KG)</th>
                                        <th style="width: 15%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="paperPricesTableBody">
                                    <!-- Price data will be loaded here -->
                                    <tr>
                                        <td colspan="4" class="text-center">Loading prices...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Metal prices table (initially hidden) -->
                    <div id="metalPricesTable" class="category-prices-table" style="display: none;">
                        <div class="action-buttons" style="margin-bottom: 15px; display: flex; justify-content: space-between;">
                            <h3 style="margin: 0;">Metal Price Guide</h3>
                            <button id="addMetalPrice" class="btn btn-primary add-price-btn">
                                <i class="bi bi-plus-circle"></i> Add New Price
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="background-color: var(--hoockers-green); color: white;">
                                        <th style="width: 25%;">Type</th>
                                        <th style="width: 40%;">Description</th>
                                        <th style="width: 20%;">Buying Price (P/KG)</th>
                                        <th style="width: 15%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="metalPricesTableBody">
                                    <!-- Price data will be loaded here -->
                                    <tr>
                                        <td colspan="4" class="text-center">Loading prices...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Batteries prices table (initially hidden) -->
                    <div id="batteriesPricesTable" class="category-prices-table" style="display: none;">
                        <div class="action-buttons" style="margin-bottom: 15px; display: flex; justify-content: space-between;">
                            <h3 style="margin: 0;">Batteries Price Guide</h3>
                            <button id="addBatteriesPrice" class="btn btn-primary add-price-btn">
                                <i class="bi bi-plus-circle"></i> Add New Price
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="background-color: var(--hoockers-green); color: white;">
                                        <th style="width: 25%;">Type</th>
                                        <th style="width: 40%;">Description</th>
                                        <th style="width: 20%;">Buying Price (P/UNIT)</th>
                                        <th style="width: 15%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="batteriesPricesTableBody">
                                    <!-- Price data will be loaded here -->
                                    <tr>
                                        <td colspan="4" class="text-center">Loading prices...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Glass prices table (initially hidden) -->
                    <div id="glassPricesTable" class="category-prices-table" style="display: none;">
                        <div class="action-buttons" style="margin-bottom: 15px; display: flex; justify-content: space-between;">
                            <h3 style="margin: 0;">Glass Price Guide</h3>
                            <button id="addGlassPrice" class="btn btn-primary add-price-btn">
                                <i class="bi bi-plus-circle"></i> Add New Price
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="background-color: var(--hoockers-green); color: white;">
                                        <th style="width: 25%;">Type</th>
                                        <th style="width: 40%;">Description</th>
                                        <th style="width: 20%;">Buying Price (KG/PC)</th>
                                        <th style="width: 15%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="glassPricesTableBody">
                                    <!-- Price data will be loaded here -->
                                    <tr>
                                        <td colspan="4" class="text-center">Loading prices...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- E-waste prices table (initially hidden) -->
                    <div id="ewastePricesTable" class="category-prices-table" style="display: none;">
                        <div class="action-buttons" style="margin-bottom: 15px; display: flex; justify-content: space-between;">
                            <h3 style="margin: 0;">E-waste Price Guide</h3>
                            <button id="addEwastePrice" class="btn btn-primary add-price-btn">
                                <i class="bi bi-plus-circle"></i> Add New Price
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="background-color: var(--hoockers-green); color: white;">
                                        <th style="width: 25%;">Type</th>
                                        <th style="width: 40%;">Description</th>
                                        <th style="width: 20%;">Buying Price (UNIT/KG)</th>
                                        <th style="width: 15%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="ewastePricesTableBody">
                                    <!-- Price data will be loaded here -->
                                    <tr>
                                        <td colspan="4" class="text-center">Loading prices...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add/Edit Price Item Modal -->
    <div id="priceItemModal" class="modal">
        <div class="modal-content" style="width: 50%; max-width: 600px;">
            <div class="modal-header">
                <h2 class="modal-title" id="priceItemModalTitle">Add New Price</h2>
                <span class="close" id="closePriceItemModal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="priceItemForm">
                    <input type="hidden" id="priceItemId" name="id">
                    <input type="hidden" id="priceItemCategory" name="category">
                    
                    <div class="form-group">
                        <label for="priceItemType">Material Type</label>
                        <input type="text" class="form-control" id="priceItemType" name="type" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="priceItemDescription">Description</label>
                        <textarea class="form-control" id="priceItemDescription" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="priceItemPrice">Buying Price</label>
                        <div style="display: flex; align-items: center;">
                            <span style="margin-right: 5px;">₱</span>
                            <input type="text" class="form-control" id="priceItemPrice" name="price" required>
                        </div>
                        <small class="form-text text-muted">Enter a specific price (e.g., 10.50) or a range (e.g., 10.00-15.00)</small>
                    </div>
                    
                    <div class="modal-footer" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                        <button type="button" class="btn btn-secondary" id="cancelPriceItem">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Price</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Search functionality for products table
        document.getElementById('productSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            filterProducts(searchTerm, document.getElementById('categoryFilter').value);
        });

        // Category filter functionality
        document.getElementById('categoryFilter').addEventListener('change', function() {
            const categoryTerm = this.value;
            filterProducts(document.getElementById('productSearch').value.toLowerCase(), categoryTerm);
        });

        // JavaScript version of getContrastColor function
        function getContrastColor(hexColor) {
            // Remove # if present
            hexColor = hexColor.replace('#', '');
            
            // Default to black if invalid hex color
            if (hexColor.length !== 6) {
                return '#000000';
            }
            
            // Convert hex to RGB
            const r = parseInt(hexColor.substr(0, 2), 16);
            const g = parseInt(hexColor.substr(2, 2), 16);
            const b = parseInt(hexColor.substr(4, 2), 16);
            
            // Calculate luminance
            const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
            
            // Return black for light colors, white for dark colors
            return (luminance > 0.5) ? '#000000' : '#ffffff';
        }

        function filterProducts(searchTerm, categoryTerm) {
            const tableRows = document.querySelectorAll('.table tbody tr');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const categoryCell = row.children[3].textContent.trim();
                const matchesSearch = text.includes(searchTerm);
                const matchesCategory = categoryTerm === '' || categoryCell === categoryTerm;
                if (matchesSearch && matchesCategory) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Initialize all functionality when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM loaded - initializing functionality");
            
            // Tab functionality
            initTabs();
            
            // Product view modal functionality
            initProductViewModal();
            
            // Post view modal functionality
            initPostViewModal();
            
            // Category management modal
            initCategoryModal();
            
            // Price guide modal
            initPriceGuideModal();
            
            // Initialize SweetAlert2 success messages
            initSweetAlertMessages();
            
            // Initialize product deletion functionality
            initProductDeletion();
            
            // Initialize deal management functionality
            initDealManagement();
        });

        // Initialize tab navigation functionality
        function initTabs() {
            console.log("Initializing tabs");
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    console.log("Tab clicked:", this.getAttribute('data-tab'));
                    
                    // Remove active class from all buttons and contents
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    
                    // Add active class to clicked button and corresponding content
                    this.classList.add('active');
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
        }

        // Initialize Product View Modal functionality
        function initProductViewModal() {
            console.log("Initializing product view modal");
            const productModal = document.getElementById('productModal');
            const closeProductBtn = productModal.querySelector('.close');
            
            // Product view buttons
            document.querySelectorAll('.view-product').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    console.log("View product button clicked for ID:", productId);
                    fetchProductDetails(productId);
                });
            });
            
            // Edit product buttons
            document.querySelectorAll('.edit-product').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    console.log("Edit product button clicked for ID:", productId);
                    openEditProductModal(productId);
                });
            });
            
            // Close product modal when clicking X button
            if (closeProductBtn) {
                closeProductBtn.addEventListener('click', function() {
                    productModal.style.display = 'none';
                });
            }
            
            // Close product modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target == productModal) {
                    productModal.style.display = 'none';
                }
            });
            
            // Setup Edit Modal Event Handlers
            setupEditModalHandlers();
        }
        
        // Function to set up Edit Modal Event Handlers
        function setupEditModalHandlers() {
            const editModal = document.getElementById('editProductModal');
            const closeEditBtn = document.getElementById('closeEditModal');
            const cancelEditBtn = document.getElementById('cancelEdit');
            const editProductForm = document.getElementById('editProductForm');
            
            // Close edit modal when clicking X button
            if (closeEditBtn) {
                closeEditBtn.addEventListener('click', function() {
                    editModal.style.display = 'none';
                });
            }
            
            // Close edit modal when clicking cancel button
            if (cancelEditBtn) {
                cancelEditBtn.addEventListener('click', function() {
                    editModal.style.display = 'none';
                });
            }
            
            // Close edit modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target == editModal) {
                    editModal.style.display = 'none';
                }
            });
            
            // Handle form submission
            if (editProductForm) {
                editProductForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitEditProductForm();
                });
            }
        }
        
        // Function to open the edit product modal
        function openEditProductModal(productId) {
            console.log("Opening edit product modal for ID:", productId);
            const editModal = document.getElementById('editProductModal');
            
            // Show loading in the form
            document.getElementById('editTitle').value = 'Loading...';
            document.getElementById('editPrice').value = '';
            document.getElementById('editUnit').value = '';
            document.getElementById('editQuantity').value = '';
            document.getElementById('editLocation').value = '';
            document.getElementById('editAddress').value = '';
            document.getElementById('editDescription').value = 'Loading...';
            document.getElementById('currentProductImage').style.display = 'none';
            
            // Show the modal
            editModal.style.display = 'block';
            
            // Fetch product details
            fetch(`/admin/products/${productId}/details`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Server responded with ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const product = data.product;
                        
                        // Set the form action
                        const form = document.getElementById('editProductForm');
                        form.action = `/admin/products/${productId}/update`;
                        
                        // Set the product ID
                        document.getElementById('editProductId').value = productId;
                        
                        // Fill in the form fields
                        document.getElementById('editTitle').value = product.title;
                        document.getElementById('editCategory').value = typeof product.category === 'object' ? product.category.name : product.category;
                        document.getElementById('editPrice').value = product.price;
                        document.getElementById('editUnit').value = product.unit;
                        document.getElementById('editQuantity').value = product.quantity;
                        document.getElementById('editLocation').value = product.location || '';
                        document.getElementById('editAddress').value = product.address || '';
                        document.getElementById('editDescription').value = product.description || '';
                        
                        // Show current image if available
                        const currentImageElement = document.getElementById('currentProductImage');
                        if (product.image) {
                            currentImageElement.src = `/storage/${product.image}`;
                            currentImageElement.style.display = 'block';
                        } else {
                            currentImageElement.style.display = 'none';
                        }
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Failed to load product details',
                            icon: 'error'
                        });
                        // Close the modal
                        document.getElementById('editProductModal').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching product details:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to load product details: ' + error.message,
                        icon: 'error'
                    });
                    // Close the modal
                    document.getElementById('editProductModal').style.display = 'none';
                });
        }
        
        // Function to submit the edit product form
        function submitEditProductForm() {
            const form = document.getElementById('editProductForm');
            const productId = document.getElementById('editProductId').value;
            const formData = new FormData(form);
            
            // Show loading state
            Swal.fire({
                title: 'Saving...',
                text: 'Please wait while we update the product',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Send the form data
            fetch(`/admin/products/${productId}/update`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    const contentType = response.headers.get('content-type');
                    
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || `Error ${response.status}: ${response.statusText}`);
                        });
                    } else {
                        throw new Error(`Server responded with ${response.status}: ${response.statusText}`);
                    }
                }
                
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    return { success: true, message: 'Product updated successfully' };
                }
            })
            .then(data => {
                document.getElementById('editProductModal').style.display = 'none';
                
                Swal.fire({
                    title: 'Success!',
                    text: data.message || 'Product updated successfully',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    window.location.reload();
                });
            })
            .catch(error => {
                console.error('Error updating product:', error);
                
                Swal.close();
                
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to update product: ' + error.message,
                    icon: 'error'
                });
            });
        }

        // Function to fetch product details
        function fetchProductDetails(productId) {
            console.log(`Fetching product details for ID: ${productId}`);
            fetch(`/admin/products/${productId}/details`)
                .then(response => {
                    if (!response.ok) {
                        console.error(`Response not OK: ${response.status} ${response.statusText}`);
                        throw new Error(`Server responded with ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Product details response:", data);
                    if (data.success) {
                        const product = data.product;
                        const productModal = document.getElementById('productModal');
                        
                        // Update modal content
                        document.getElementById('modalProductTitle').textContent = product.title;
                        document.getElementById('modalProductCategory').textContent = 
                            typeof product.category === 'object' ? product.category.name : product.category;
                        document.getElementById('modalProductPrice').textContent = `₱${parseFloat(product.price).toFixed(2)} / ${product.unit}`;
                        document.getElementById('modalProductQuantity').textContent = `${product.quantity} ${product.unit}`;
                        document.getElementById('modalProductSeller').textContent = 
                            product.user ? `${product.user.firstname} ${product.user.lastname}` : 'Unknown';
                        document.getElementById('modalProductLocation').textContent = product.location || 'Not specified';
                        document.getElementById('modalProductAddress').textContent = product.address || 'Not specified';
                        document.getElementById('modalProductDescription').textContent = product.description || 'No description provided';
                        document.getElementById('modalProductDate').textContent = new Date(product.created_at).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        
                        // Set image or placeholder
                        const imageElement = document.getElementById('modalProductImage');
                        if (product.image) {
                            imageElement.src = `/storage/${product.image}`;
                            imageElement.alt = product.title;
                            imageElement.style.display = 'block';
                        } else {
                            imageElement.style.display = 'none';
                        }
                        
                        // Show modal
                        productModal.style.display = 'block';
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Failed to load product details',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching product details:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while loading product details: ' + error.message,
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
        }

        // Initialize Post View Modal functionality
        function initPostViewModal() {
            console.log("Initializing post view modal");
            const postModal = document.getElementById('postModal');
            const closePostBtn = document.getElementById('closePostModal');
            
            // Post view buttons
            document.querySelectorAll('.view-post').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-id');
                    console.log("View post button clicked for ID:", postId);
                    fetchPostDetails(postId);
                });
            });
            
            // Post approval buttons
            document.querySelectorAll('.approve-post').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const postId = this.getAttribute('data-id');
                    const postTitle = this.getAttribute('data-title');
                    console.log("Approve post button clicked for ID:", postId);
                    
                    approvePost(postId, postTitle);
                });
            });
            
            // Post rejection buttons
            document.querySelectorAll('.reject-post').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const postId = this.getAttribute('data-id');
                    const postTitle = this.getAttribute('data-title');
                    console.log("Reject post button clicked for ID:", postId);
                    
                    rejectPost(postId, postTitle);
                });
            });
            
            // Close post modal when clicking X button
            if (closePostBtn) {
                closePostBtn.addEventListener('click', function() {
                    postModal.style.display = 'none';
                });
            }
            
            // Close post modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target == postModal) {
                    postModal.style.display = 'none';
                }
            });
        }

        // Initialize Category Management Modal functionality
        function initCategoryModal() {
            console.log("Initializing category management modal");
            const categoryModal = document.getElementById('categoryModal');
            const closeCategoryModal = document.getElementById('closeCategoryModal');
            const manageCategoriesBtn = document.getElementById('manageCategoriesBtn');
            
            // Setup Manage Categories button click handler
            if (manageCategoriesBtn) {
                manageCategoriesBtn.addEventListener('click', function() {
                    console.log("Manage categories button clicked");
                    // Fetch categories before opening modal
                    loadCategories();
                    // Show the modal
                    categoryModal.style.display = 'block';
                });
            } else {
                console.error("Manage categories button not found");
            }
            
            // Close modal when clicking the X button
            if (closeCategoryModal) {
                closeCategoryModal.addEventListener('click', function() {
                    categoryModal.style.display = 'none';
                });
            }
            
            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target == categoryModal) {
                    categoryModal.style.display = 'none';
                }
            });
            
            // Add Category button
            const addCategoryBtn = document.getElementById('addCategoryBtn');
            if (addCategoryBtn) {
                addCategoryBtn.addEventListener('click', function() {
                    addCategory();
                });
            }
            
            // Remove Category button
            const removeCategoryBtn = document.getElementById('removeCategoryBtn');
            if (removeCategoryBtn) {
                removeCategoryBtn.addEventListener('click', function() {
                    removeCategory();
                });
            }
        }

        // Function to load categories
        function loadCategories() {
            console.log("Loading categories for modal");
            
            fetch('/admin/categories')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Network response was not ok: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Categories loaded:", data);
                    
                    if (data.success) {
                        const categoriesList = document.getElementById('categoriesList');
                        const categoryToRemove = document.getElementById('categoryToRemove');
                        const replacementCategory = document.getElementById('replacementCategory');
                        
                        // Clear existing options
                        categoriesList.innerHTML = '';
                        categoryToRemove.innerHTML = '<option value="">Select a category</option>';
                        replacementCategory.innerHTML = '<option value="">Select a category</option>';
                        
                        // Add categories to displays
                        data.categories.forEach(category => {
                            if (category.is_active) {
                                // Add to badge list
                                const badge = document.createElement('span');
                                badge.className = 'category-badge';
                                badge.style.backgroundColor = category.color || '#f0f0f0';
                                badge.style.color = getContrastColor(category.color.replace('#', ''));
                                badge.textContent = category.name;
                                categoriesList.appendChild(badge);
                                
                                // Add to dropdown options
                                const option = document.createElement('option');
                                option.value = category.id;
                                option.textContent = category.name;
                                categoryToRemove.appendChild(option.cloneNode(true));
                                replacementCategory.appendChild(option.cloneNode(true));
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Failed to load categories',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to load categories: ' + error.message,
                        icon: 'error'
                    });
                });
        }

        // Function to add a category
        function addCategory() {
            console.log("Adding new category");
            const name = document.getElementById('newCategoryName').value.trim();
            const description = document.getElementById('newCategoryDescription').value.trim();
            const color = document.getElementById('newCategoryColor').value;
            
            if (!name) {
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please enter a category name',
                    icon: 'warning'
                });
                return;
            }
            
            // Show loading state on button
            const addCategoryBtn = document.getElementById('addCategoryBtn');
            const originalBtnText = addCategoryBtn.innerHTML;
            addCategoryBtn.disabled = true;
            addCategoryBtn.innerHTML = '<i class="bi bi-hourglass"></i> Adding...';
            
            // Send request to add category
            fetch('/admin/categories/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: name,
                    description: description,
                    color: color
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Reset button state
                addCategoryBtn.disabled = false;
                addCategoryBtn.innerHTML = originalBtnText;
                
                if (data.success) {
                    // Clear input fields
                    document.getElementById('newCategoryName').value = '';
                    document.getElementById('newCategoryDescription').value = '';
                    document.getElementById('newCategoryColor').value = '#517A5B';
                    
                    // Reload categories
                    loadCategories();
                    
                    Swal.fire({
                        title: 'Success',
                        text: data.message,
                        icon: 'success'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Failed to add category',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                // Reset button state
                addCategoryBtn.disabled = false;
                addCategoryBtn.innerHTML = originalBtnText;
                
                console.error('Error adding category:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to add category: ' + error.message,
                    icon: 'error'
                });
            });
        }

        // Function to remove a category
        function removeCategory() {
            console.log("Removing category");
            const categoryId = document.getElementById('categoryToRemove').value;
            const replacementId = document.getElementById('replacementCategory').value;
            const categoryName = document.getElementById('categoryToRemove').options[document.getElementById('categoryToRemove').selectedIndex]?.text || 'Unknown';
            const replacementName = document.getElementById('replacementCategory').options[document.getElementById('replacementCategory').selectedIndex]?.text || 'Unknown';
            
            if (!categoryId || !replacementId) {
                Swal.fire({
                    title: 'Missing Selection',
                    text: 'Please select both a category to remove and a replacement category',
                    icon: 'warning'
                });
                return;
            }
            
            if (categoryId === replacementId) {
                Swal.fire({
                    title: 'Invalid Selection',
                    text: 'The replacement category cannot be the same as the category to remove',
                    icon: 'warning'
                });
                return;
            }
            
            // Confirm removal
            Swal.fire({
                title: 'Remove Category?',
                text: `All products in "${categoryName}" will be moved to "${replacementName}". This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, remove it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    const removeCategoryBtn = document.getElementById('removeCategoryBtn');
                    const originalBtnText = removeCategoryBtn.innerHTML;
                    removeCategoryBtn.disabled = true;
                    removeCategoryBtn.innerHTML = '<i class="bi bi-hourglass"></i> Processing...';
                    
                    // Send request to remove category
                    fetch('/admin/categories/remove', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            category_id: categoryId,
                            replacement_category_id: replacementId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Network response was not ok: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Reset button state
                        removeCategoryBtn.disabled = false;
                        removeCategoryBtn.innerHTML = originalBtnText;
                        
                        if (data.success) {
                            // Reset dropdowns
                            document.getElementById('categoryToRemove').value = '';
                            document.getElementById('replacementCategory').value = '';
                            
                            // Reload categories
                            loadCategories();
                            
                            Swal.fire({
                                title: 'Category Removed',
                                text: data.message,
                                icon: 'success'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message || 'Failed to remove category',
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        // Reset button state
                        removeCategoryBtn.disabled = false;
                        removeCategoryBtn.innerHTML = originalBtnText;
                        
                        console.error('Error removing category:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to remove category: ' + error.message,
                            icon: 'error'
                        });
                    });
                }
            });
        }

        // Initialize Price Guide Modal functionality
        function initPriceGuideModal() {
            console.log("Initializing price guide modal");
            const pricesGuideModal = document.getElementById('pricesGuideModal');
            const pricesGuideBtn = document.getElementById('pricesGuideBtn');
            const closePricesGuideModal = document.getElementById('closePricesGuideModal');
            
            // Price Item Modal elements
            const priceItemModal = document.getElementById('priceItemModal');
            const closePriceItemModal = document.getElementById('closePriceItemModal');
            const cancelPriceItemBtn = document.getElementById('cancelPriceItem');
            const priceItemForm = document.getElementById('priceItemForm');
            
            // Current active category
            let currentCategory = 'plastic';
            
            if (pricesGuideBtn) {
                pricesGuideBtn.addEventListener('click', function() {
                    console.log("Prices guide button clicked");
                    pricesGuideModal.style.display = 'block';
                    loadPriceGuides('plastic'); // Load initial category prices
                });
            } else {
                console.error("Prices guide button not found");
            }
            
            // Close Price Guide Modal
            if (closePricesGuideModal) {
                closePricesGuideModal.addEventListener('click', function() {
                    pricesGuideModal.style.display = 'none';
                });
            }
            
            // Close Price Item Modal
            if (closePriceItemModal) {
                closePriceItemModal.addEventListener('click', function() {
                    priceItemModal.style.display = 'none';
                });
            }
            
            // Cancel Button in Price Item Modal
            if (cancelPriceItemBtn) {
                cancelPriceItemBtn.addEventListener('click', function() {
                    priceItemModal.style.display = 'none';
                });
            }
            
            // Handle Price Form Submission
            if (priceItemForm) {
                priceItemForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    savePrice();
                });
            }
            
            // Tab buttons handlers
            initPriceTabButtons();
            
            // Add price buttons handlers
            initAddPriceButtons();
        }

        // Initialize Price Tab Buttons
        function initPriceTabButtons() {
            const plasticTabBtn = document.getElementById('plasticTabBtn');
            const paperTabBtn = document.getElementById('paperTabBtn');
            const metalTabBtn = document.getElementById('metalTabBtn');
            const batteriesTabBtn = document.getElementById('batteriesTabBtn');
            const glassTabBtn = document.getElementById('glassTabBtn');
            const ewasteTabBtn = document.getElementById('ewasteTabBtn');
            
            // Table containers
            const plasticPricesTable = document.getElementById('plasticPricesTable');
            const paperPricesTable = document.getElementById('paperPricesTable');
            const metalPricesTable = document.getElementById('metalPricesTable');
            const batteriesPricesTable = document.getElementById('batteriesPricesTable');
            const glassPricesTable = document.getElementById('glassPricesTable');
            const ewastePricesTable = document.getElementById('ewastePricesTable');
            
            // Add click handlers to tab buttons
            if (plasticTabBtn) {
                plasticTabBtn.addEventListener('click', function() {
                    console.log("Plastic tab clicked");
                    switchPricesTab('plastic', plasticPricesTable, plasticTabBtn);
                });
            }
            
            if (paperTabBtn) {
                paperTabBtn.addEventListener('click', function() {
                    console.log("Paper tab clicked");
                    switchPricesTab('paper', paperPricesTable, paperTabBtn);
                });
            }
            
            if (metalTabBtn) {
                metalTabBtn.addEventListener('click', function() {
                    console.log("Metal tab clicked");
                    switchPricesTab('metal', metalPricesTable, metalTabBtn);
                });
            }
            
            if (batteriesTabBtn) {
                batteriesTabBtn.addEventListener('click', function() {
                    console.log("Batteries tab clicked");
                    switchPricesTab('batteries', batteriesPricesTable, batteriesTabBtn);
                });
            }
            
            if (glassTabBtn) {
                glassTabBtn.addEventListener('click', function() {
                    console.log("Glass tab clicked");
                    switchPricesTab('glass', glassPricesTable, glassTabBtn);
                });
            }
            
            if (ewasteTabBtn) {
                ewasteTabBtn.addEventListener('click', function() {
                    console.log("E-waste tab clicked");
                    switchPricesTab('ewaste', ewastePricesTable, ewasteTabBtn);
                });
            }
        }
        
        // Initialize Add Price Buttons
        function initAddPriceButtons() {
            // Add Price buttons
            const addPlasticPrice = document.getElementById('addPlasticPrice');
            const addPaperPrice = document.getElementById('addPaperPrice');
            const addMetalPrice = document.getElementById('addMetalPrice');
            const addBatteriesPrice = document.getElementById('addBatteriesPrice');
            const addGlassPrice = document.getElementById('addGlassPrice');
            const addEwastePrice = document.getElementById('addEwastePrice');
            
            if (addPlasticPrice) {
                addPlasticPrice.addEventListener('click', function() {
                    console.log("Add plastic price button clicked");
                    openAddPriceModal('plastic');
                });
            }
            
            if (addPaperPrice) {
                addPaperPrice.addEventListener('click', function() {
                    console.log("Add paper price button clicked");
                    openAddPriceModal('paper');
                });
            }
            
            if (addMetalPrice) {
                addMetalPrice.addEventListener('click', function() {
                    console.log("Add metal price button clicked");
                    openAddPriceModal('metal');
                });
            }
            
            if (addBatteriesPrice) {
                addBatteriesPrice.addEventListener('click', function() {
                    console.log("Add batteries price button clicked");
                    openAddPriceModal('batteries');
                });
            }
            
            if (addGlassPrice) {
                addGlassPrice.addEventListener('click', function() {
                    console.log("Add glass price button clicked");
                    openAddPriceModal('glass');
                });
            }
            
            if (addEwastePrice) {
                addEwastePrice.addEventListener('click', function() {
                    console.log("Add e-waste price button clicked");
                    openAddPriceModal('ewaste');
                });
            }
        }

        // Switch between price guide tabs
        function switchPricesTab(category, tableDiv, tabBtn) {
            // Get all tables
            const tables = {
                'plastic': document.getElementById('plasticPricesTable'),
                'paper': document.getElementById('paperPricesTable'),
                'metal': document.getElementById('metalPricesTable'),
                'batteries': document.getElementById('batteriesPricesTable'),
                'glass': document.getElementById('glassPricesTable'),
                'ewaste': document.getElementById('ewastePricesTable')
            };
            
            // Get all tab buttons
            const tabButtons = {
                'plastic': document.getElementById('plasticTabBtn'),
                'paper': document.getElementById('paperTabBtn'),
                'metal': document.getElementById('metalTabBtn'), 
                'batteries': document.getElementById('batteriesTabBtn'),
                'glass': document.getElementById('glassTabBtn'),
                'ewaste': document.getElementById('ewasteTabBtn')
            };
            
            // Hide all tables
            Object.values(tables).forEach(table => {
                if (table) table.style.display = 'none';
            });
            
            // Show the selected table
            if (tableDiv) tableDiv.style.display = 'block';
            
            // Reset all tab button styles
            Object.values(tabButtons).forEach(btn => {
                if (btn) btn.innerHTML = btn.textContent.trim();
            });
            
            // Add indicator to selected tab
            if (tabBtn) {
                tabBtn.innerHTML = `${tabBtn.textContent.trim()} <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>`;
            }
            
            // Set current category
            window.currentCategory = category;
            
            // Load prices for this category
            loadPriceGuides(category);
        }

        // Function to load price guides for a category
        function loadPriceGuides(category) {
            console.log(`Loading price guides for category: ${category}`);
            const tableBodyId = `${category}PricesTableBody`;
            const tableBody = document.getElementById(tableBodyId);
            
            if (!tableBody) {
                console.error(`Table body not found: ${tableBodyId}`);
                return;
            }
            
            // Show loading state
            tableBody.innerHTML = '<tr><td colspan="4" class="text-center">Loading prices...</td></tr>';
            
            // Fetch price guides from the server
            fetch(`/admin/price-guides/${category}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(`Price guides loaded for ${category}:`, data);
                    if (data.success) {
                        if (!data.priceGuides || data.priceGuides.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="4" class="text-center">No price guides found for this category. Add one to get started.</td></tr>';
                            return;
                        }
                        
                        // Render price guides
                        tableBody.innerHTML = '';
                        data.priceGuides.forEach(guide => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${guide.type || 'N/A'}</td>
                                <td>${guide.description || 'N/A'}</td>
                                <td>₱${guide.price || '0.00'}</td>
                                <td>
                                    <div class="action-buttons" style="display: flex; gap: 5px; justify-content: center;">
                                        <button class="btn btn-sm btn-warning edit-price-btn" data-id="${guide.id}" title="Edit price" style="visibility: visible; opacity: 1;">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-price-btn" data-id="${guide.id}" data-type="${guide.type}" title="Delete price" style="visibility: visible; opacity: 1;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                        
                        // Add event listeners to edit/delete buttons
                        addPriceButtonEventListeners();
                    } else {
                        tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-danger">${data.message || 'Failed to load prices'}</td></tr>`;
                    }
                })
                .catch(error => {
                    console.error('Error loading price guides:', error);
                    tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-danger">Error loading prices: ${error.message}</td></tr>`;
                });
        }

        // Add this new helper function to attach event listeners to the buttons
        function addPriceButtonEventListeners() {
            // Add event listeners to edit buttons
            document.querySelectorAll('.edit-price-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const priceId = this.getAttribute('data-id');
                    console.log(`Edit price button clicked for ID: ${priceId}`);
                    openEditPriceModal(priceId);
                });
            });
            
            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-price-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const priceId = this.getAttribute('data-id');
                    const priceType = this.getAttribute('data-type');
                    console.log(`Delete price button clicked for ID: ${priceId}, Type: ${priceType}`);
                    deletePrice(priceId, priceType);
                });
            });
        }

        // Function to open the add price modal
        function openAddPriceModal(category) {
            console.log(`Opening add price modal for category: ${category}`);
            const priceItemModal = document.getElementById('priceItemModal');
            
            // Set modal title
            document.getElementById('priceItemModalTitle').textContent = `Add New ${category.charAt(0).toUpperCase() + category.slice(1)} Price`;
            
            // Clear form fields
            document.getElementById('priceItemId').value = '';
            document.getElementById('priceItemCategory').value = category;
            document.getElementById('priceItemType').value = '';
            document.getElementById('priceItemDescription').value = '';
            document.getElementById('priceItemPrice').value = '';
            
            // Show modal
            priceItemModal.style.display = 'block';
        }

        // Function to open the edit price modal
        function openEditPriceModal(priceId) {
            console.log(`Opening edit price modal for ID: ${priceId}`);
            // Check if the required data is available
            if (!priceId) {
                console.error("Missing price ID for editing");
                Swal.fire({
                    title: 'Error',
                    text: 'Cannot edit price: Missing price ID',
                    icon: 'error'
                });
                return;
            }
            
            const priceItemModal = document.getElementById('priceItemModal');
            if (!priceItemModal) {
                console.error("Price item modal element not found");
                return;
            }
            
            // Fetch price details
            fetch(`/admin/price-guides/item/${priceId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Price guide item details:", data);
                    if (data.success) {
                        const price = data.priceGuide;
                        
                        // Set modal title
                        document.getElementById('priceItemModalTitle').textContent = 'Edit Price';
                        
                        // Fill form fields
                        document.getElementById('priceItemId').value = price.id;
                        document.getElementById('priceItemCategory').value = price.category;
                        document.getElementById('priceItemType').value = price.type;
                        document.getElementById('priceItemDescription').value = price.description || '';
                        document.getElementById('priceItemPrice').value = price.price;
                        
                        // Show modal
                        priceItemModal.style.display = 'block';
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Failed to load price details',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading price details:', error);
                    Swal.fire({
                        title: 'Error',
                        text: `Error loading price details: ${error.message}`,
                        icon: 'error'
                    });
                });
        }

        // Function to save a price (add or update)
        function savePrice() {
            console.log("Saving price data");
            // Get form data
            const id = document.getElementById('priceItemId').value;
            const category = document.getElementById('priceItemCategory').value;
            const type = document.getElementById('priceItemType').value;
            const description = document.getElementById('priceItemDescription').value;
            const price = document.getElementById('priceItemPrice').value;
            
            // Validate form data
            if (!type || !price) {
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please fill in all required fields',
                    icon: 'warning'
                });
                return;
            }
            
            // Prepare request data
            const data = {
                id: id,
                category: category,
                type: type,
                description: description,
                price: price
            };
            
            console.log("Sending price data:", data);
            
            // Send request to server
            fetch('/admin/price-guides/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    console.error("Error response:", response.status, response.statusText);
                    throw new Error(`Server returned ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Price save response:", data);
                if (data.success) {
                    // Close modal
                    document.getElementById('priceItemModal').style.display = 'none';
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success',
                        text: data.message,
                        icon: 'success'
                    });
                    
                    // Reload price guides
                    loadPriceGuides(window.currentCategory);
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Failed to save price',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error saving price:', error);
                Swal.fire({
                    title: 'Error',
                    text: `Error saving price: ${error.message}`,
                    icon: 'error'
                });
            });
        }

        // Function to delete a price
        function deletePrice(priceId, priceType) {
            console.log(`Deleting price ID: ${priceId}, Type: ${priceType}`);
            // Check if the required data is available
            if (!priceId) {
                console.error("Missing price ID for deletion");
                Swal.fire({
                    title: 'Error',
                    text: 'Cannot delete price: Missing price ID',
                    icon: 'error'
                });
                return;
            }
            
            Swal.fire({
                title: 'Delete Price',
                text: `Are you sure you want to delete the price for "${priceType}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send delete request to server
                    fetch(`/admin/price-guides/delete/${priceId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Price delete response:", data);
                        if (data.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: data.message,
                                icon: 'success'
                            });
                            
                            // Reload price guides
                            loadPriceGuides(window.currentCategory);
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message || 'Failed to delete price',
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting price:', error);
                        Swal.fire({
                            title: 'Error',
                            text: `Error deleting price: ${error.message}`,
                            icon: 'error'
                        });
                    });
                }
            });
        }

        // Function to fetch post details
        function fetchPostDetails(postId) {
            console.log(`Fetching post details for ID: ${postId}`);
            
            fetch(`/admin/post-request/${postId}`)
                .then(response => {
                    if (!response.ok) {
                        console.error('Response not OK:', response.status);
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Post details response:', data);
                    
                    if (data.success) {
                        const post = data.product;
                        const modal = document.getElementById('postModal');
                           
                        // Update modal content
                        document.getElementById('modalPostTitle').textContent = post.title;
                        document.getElementById('modalPostCategory').textContent = post.category.name || post.category;
                        document.getElementById('modalPostPrice').textContent = `₱${parseFloat(post.price).toFixed(2)} / ${post.unit}`;
                        document.getElementById('modalPostQuantity').textContent = `${post.quantity} ${post.unit}`;
                        document.getElementById('modalPostSeller').textContent = post.user ? `${post.user.firstname} ${post.user.lastname}` : 'Unknown';
                        document.getElementById('modalPostLocation').textContent = post.location || 'Not specified';
                        document.getElementById('modalPostAddress').textContent = post.address || 'Not specified';
                        document.getElementById('modalPostDescription').textContent = post.description || 'No description provided';
                        document.getElementById('modalPostDate').textContent = new Date(post.created_at).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        
                        // Set image or placeholder
                        if (post.image) {
                            document.getElementById('modalPostImage').src = `/storage/${post.image}`;
                            document.getElementById('modalPostImage').style.display = 'block';
                        } else {
                            document.getElementById('modalPostImage').style.display = 'none';
                        }
                        
                        // Set up the forms for approval/rejection from the detail view
                        document.getElementById('approveForm').action = `{{ url('admin/post-requests') }}/${postId}/approve`;
                        document.getElementById('rejectBtn').onclick = function() {
                            modal.style.display = 'none';
                            
                            // Use SweetAlert2 for rejection
                            Swal.fire({
                                title: 'Reject Post?',
                                text: `Are you sure you want to reject this post?`,
                                input: 'text',
                                inputPlaceholder: 'Enter reason for rejection (optional)',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#dc3545',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Yes, reject it!',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Create and submit form for rejection
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = `{{ url('admin/post-requests') }}/${postId}/reject`;
                                    form.style.display = 'none';
                                    
                                    const csrfToken = document.createElement('input');
                                    csrfToken.type = 'hidden';
                                    csrfToken.name = '_token';
                                    csrfToken.value = '{{ csrf_token() }}';
                                    
                                    const remarks = document.createElement('input');
                                    remarks.type = 'hidden';
                                    remarks.name = 'remarks';
                                    remarks.value = result.value || 'Post rejected by admin';
                                    
                                    form.appendChild(csrfToken);
                                    form.appendChild(remarks);
                                    document.body.appendChild(form);
                                    form.submit();
                                }
                            });
                        };
                        
                        // Show modal
                        modal.style.display = 'block';
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Failed to load post details',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error details:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while loading post details: ' + error.message,
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
        }

        // Function to approve a post
        function approvePost(postId, postTitle) {
            // Show SweetAlert2 confirmation
            Swal.fire({
                title: 'Approve Post?',
                text: `Are you sure you want to approve "${postTitle}"? This will make it visible in the marketplace.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Approving the post request',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Create and submit form for approval
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('admin/post-requests') }}/${postId}/approve`;
                    form.style.display = 'none';
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Function to reject a post
        function rejectPost(postId, postTitle) {
            Swal.fire({
                title: 'Reject Post?',
                text: `Are you sure you want to reject "${postTitle}"?`,
                input: 'text',
                inputPlaceholder: 'Enter reason for rejection (optional)',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit form for rejection
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('admin/post-requests') }}/${postId}/reject`;
                    form.style.display = 'none';
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const remarks = document.createElement('input');
                    remarks.type = 'hidden';
                    remarks.name = 'remarks';
                    remarks.value = result.value || 'Post rejected by admin';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(remarks);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Function to initialize SweetAlert2 success messages
        function initSweetAlertMessages() {
            // Do not include general success messages, only specific ones
            
            // Success messages for approval
            @if(session('success') && str_contains(session('success'), 'approved successfully'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#28a745',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
               
            // Success messages for rejection
            @if(session('success') && str_contains(session('success'), 'rejected'))
                Swal.fire({
                    title: 'Post Rejected',
                    text: "{{ session('success') }}",
                    icon: 'warning',
                    confirmButtonColor: '#dc3545',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
        }

        // Add this function for product deletion with SweetAlert2
        function initProductDeletion() {
            // Find all delete product buttons
            document.querySelectorAll('.delete-product').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const productTitle = this.getAttribute('data-title');
                    
                    console.log(`Delete product button clicked for ID: ${productId}, Title: ${productTitle}`);
                    
                    // Show SweetAlert2 confirmation
                    Swal.fire({
                        title: 'Delete Product?',
                        text: `Are you sure you want to delete "${productTitle}"? This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Please wait while we delete the product',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            
                            // Send DELETE request using fetch API
                            fetch(`/admin/products/${productId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`Server responded with ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: data.message || 'Product deleted successfully',
                                        icon: 'success',
                                        timer: 1500,
                                        timerProgressBar: true
                                    }).then(() => {
                                        // Remove the product row from the table or reload the page
                                        const productRow = button.closest('tr');
                                        if (productRow) {
                                            productRow.remove();
                                        } else {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: data.message || 'Failed to delete product',
                                        icon: 'error'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting product:', error);
                                
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Failed to delete product: ' + error.message,
                                    icon: 'error'
                                });
                            });
                        }
                    });
                });
            });
        }

        // Deal Management Functions
        function initDealManagement() {
            // Toggle Featured Deal Status
            document.querySelectorAll('.toggle-featured').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const isFeatured = this.getAttribute('data-featured') === 'true';
                    const action = isFeatured ? 'remove from featured' : 'make featured';
                    
                    Swal.fire({
                        title: `${isFeatured ? 'Remove Featured Status?' : 'Make Featured Deal?'}`,
                        text: `Are you sure you want to ${action} this deal?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#17a2b8',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: `Yes, ${action}!`,
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            toggleFeaturedStatus(productId);
                        }
                    });
                });
            });

            // Remove Deal Status
            document.querySelectorAll('.remove-deal').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    
                    Swal.fire({
                        title: 'Remove Deal Status?',
                        text: 'This will remove the deal status and reset pricing to current price.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#6c757d',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: 'Yes, remove deal',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            removeDealStatus(productId);
                        }
                    });
                });
            });

            // Create New Deal
            document.querySelectorAll('.make-deal').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    showCreateDealModal(productId);
                });
            });
        }

        function toggleFeaturedStatus(productId) {
            fetch(`/admin/deals/${productId}/toggle-featured`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to update featured status',
                    icon: 'error'
                });
            });
        }

        function removeDealStatus(productId) {
            fetch(`/admin/deals/${productId}/remove`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Deal Removed!',
                        text: data.message,
                        icon: 'success',
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to remove deal status',
                    icon: 'error'
                });
            });
        }

        function showCreateDealModal(productId) {
            Swal.fire({
                title: 'Create Deal',
                html: `
                    <div style="text-align: left;">
                        <div style="margin-bottom: 15px;">
                            <label for="original_price" style="display: block; margin-bottom: 5px; font-weight: 600;">Original Price (₱)</label>
                            <input type="number" id="original_price" class="swal2-input" step="0.01" min="0" placeholder="Enter original price" style="margin: 0; width: 100%;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label for="discount_percentage" style="display: block; margin-bottom: 5px; font-weight: 600;">Discount Percentage (%)</label>
                            <input type="number" id="discount_percentage" class="swal2-input" step="1" min="15" max="90" placeholder="Minimum 15%" style="margin: 0; width: 100%;">
                        </div>
                        <div id="deal_preview" style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-top: 10px; display: none;">
                            <strong>Deal Preview:</strong>
                            <div id="preview_content"></div>
                        </div>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Create Deal',
                cancelButtonText: 'Cancel',
                didOpen: () => {
                    const originalPriceInput = document.getElementById('original_price');
                    const discountInput = document.getElementById('discount_percentage');
                    const preview = document.getElementById('deal_preview');
                    const previewContent = document.getElementById('preview_content');

                    function updatePreview() {
                        const originalPrice = parseFloat(originalPriceInput.value) || 0;
                        const discount = parseFloat(discountInput.value) || 0;
                        
                        if (originalPrice > 0 && discount >= 15) {
                            const discountedPrice = originalPrice * (1 - discount / 100);
                            const savings = originalPrice - discountedPrice;
                            
                            previewContent.innerHTML = `
                                <div style="color: #28a745; font-weight: bold;">
                                    New Price: ₱${discountedPrice.toFixed(2)}
                                </div>
                                <div style="color: #dc3545; text-decoration: line-through;">
                                    Original: ₱${originalPrice.toFixed(2)}
                                </div>
                                <div style="color: #ff6b35; font-weight: bold;">
                                    Customers Save: ₱${savings.toFixed(2)} (${discount}% OFF)
                                </div>
                            `;
                            preview.style.display = 'block';
                        } else {
                            preview.style.display = 'none';
                        }
                    }

                    originalPriceInput.addEventListener('input', updatePreview);
                    discountInput.addEventListener('input', updatePreview);
                },
                preConfirm: () => {
                    const originalPrice = parseFloat(document.getElementById('original_price').value);
                    const discountPercentage = parseFloat(document.getElementById('discount_percentage').value);
                    
                    if (!originalPrice || originalPrice <= 0) {
                        Swal.showValidationMessage('Please enter a valid original price');
                        return false;
                    }
                    
                    if (!discountPercentage || discountPercentage < 15) {
                        Swal.showValidationMessage('Discount must be at least 15%');
                        return false;
                    }
                    
                    return { originalPrice, discountPercentage };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    createDeal(productId, result.value.originalPrice, result.value.discountPercentage);
                }
            });
        }

        function createDeal(productId, originalPrice, discountPercentage) {
            fetch(`/admin/deals/${productId}/create`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    original_price: originalPrice,
                    discount_percentage: discountPercentage
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '🔥 Deal Created!',
                        text: `Successfully created deal with ${discountPercentage}% discount!`,
                        icon: 'success',
                        timer: 2000
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to create deal',
                    icon: 'error'
                });
            });
        }

        // Make sure the window object has a currentCategory property
        window.currentCategory = 'plastic';
    </script>
</body>
</html>
