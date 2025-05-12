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

        /* Action buttons styling */
        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 2px;
        }
        
        .action-buttons form {
            display: inline-block;
            margin: 0;
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
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Seller</th>
                                    <th>Posted Date</th>
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
                                        <td>₱{{ number_format($product->price, 2) }} / {{ $product->unit }}</td>
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
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-primary view-product" data-id="{{ $product->id }}" data-toggle="tooltip" title="View details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning edit-product" data-id="{{ $product->id }}" data-toggle="tooltip" title="Edit product">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')" data-toggle="tooltip" title="Delete product">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">No products found</td>
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
                                            <button class="btn btn-sm view-post" data-id="{{ $post->id }}" title="View Details">
                                                <i class="bi bi-eye-fill" style="color: var(--hoockers-green); font-size: 1.2rem;"></i>
                                            </button>
                                            <button class="btn btn-sm approve-post" data-id="{{ $post->id }}" data-title="{{ $post->title }}" title="Approve Post">
                                                <i class="bi bi-check-circle-fill" style="color: #28a745; font-size: 1.2rem;"></i>
                                            </button>
                                            <button class="btn btn-sm reject-post" data-id="{{ $post->id }}" data-title="{{ $post->title }}" title="Reject Post">
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

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            // Enable tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                tooltipTriggerEl.title = tooltipTriggerEl.getAttribute('title');
                tooltipTriggerEl.setAttribute('data-bs-toggle', 'tooltip');
                tooltipTriggerEl.setAttribute('data-bs-placement', 'top');
            });
            // Initialize Bootstrap tooltips if Bootstrap 5
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });

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

        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons and contents
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    
                    // Add active class to clicked button and corresponding content
                    this.classList.add('active');
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            // Initialize SweetAlert2 success messages
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
        });
        
        // Function to fetch post details
        function fetchPostDetails(postId) {
            console.log('Fetching details for post ID:', postId);
            
            fetch(`/admin/post-request/${postId}`)
                .then(response => {
                    if (!response.ok) {
                        console.error('Response not OK:', response.status);
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    
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
                        text: 'An error occurred while loading post details',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
        }
        
        // Initialize event listeners for pending posts when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            const postModal = document.getElementById('postModal');
            const closePostBtn = document.getElementById('closePostModal');
            
            // View post modal functionality
            const viewButtons = document.querySelectorAll('.view-post');
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-id');
                    fetchPostDetails(postId);
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
            
            // Get all approve buttons
            const approveButtons = document.querySelectorAll('.approve-post');
            
            // Add click event for approve buttons
            approveButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const postId = this.getAttribute('data-id');
                    const postTitle = this.getAttribute('data-title');
                      
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
                });
            });
            
            // Similar event for reject buttons
            const rejectButtons = document.querySelectorAll('.reject-post');
            rejectButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const postId = this.getAttribute('data-id');
                    const postTitle = this.getAttribute('data-title');
                    
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
                });
            });
            
            // Category Management Modal
            const categoryModal = document.getElementById('categoryModal');
            const closeCategoryModal = document.getElementById('closeCategoryModal');
            const manageCategoriesBtn = document.getElementById('manageCategoriesBtn');
            
            // Setup Manage Categories button click handler
            if (manageCategoriesBtn) {
                manageCategoriesBtn.addEventListener('click', function() {
                    // Fetch categories before opening modal
                    loadCategories();
                    // Show the modal
                    categoryModal.style.display = 'block';
                });
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
            
            // Function to load categories
            function loadCategories() {
                fetch('/admin/categories')
                    .then(response => response.json())
                    .then(data => {
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
            
            // Handle Add Category button click
            const addCategoryBtn = document.getElementById('addCategoryBtn');
            if (addCategoryBtn) {
                addCategoryBtn.addEventListener('click', function() {
                    const name = document.getElementById('newCategoryName').value.trim();
                    const description = document.getElementById('newCategoryDescription').value.trim();
                    const color = document.getElementById('newCategoryColor').value;
                    
                    if (!name) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Please enter a category name',
                            icon: 'warning'
                        });
                        return;
                    }
                    
                    // Set loading state
                    addCategoryBtn.disabled = true;
                    addCategoryBtn.innerHTML = '<i class="bi bi-hourglass"></i> Adding...';
                    
                    // Send request to add category
                    fetch('/admin/categories/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name: name,
                            description: description,
                            color: color
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Reset button state
                        addCategoryBtn.disabled = false;
                        addCategoryBtn.innerHTML = '<i class="bi bi-plus-circle"></i> Add Category';
                        
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
                        addCategoryBtn.innerHTML = '<i class="bi bi-plus-circle"></i> Add Category';
                        
                        console.error('Error adding category:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to add category: ' + error.message,
                            icon: 'error'
                        });
                    });
                });
            }
            
            // Handle Remove Category button click
            const removeCategoryBtn = document.getElementById('removeCategoryBtn');
            if (removeCategoryBtn) {
                removeCategoryBtn.addEventListener('click', function() {
                    const categoryId = document.getElementById('categoryToRemove').value;
                    const replacementId = document.getElementById('replacementCategory').value;
                    
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
                        text: 'All products in this category will be moved to the replacement category',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, remove it',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Set loading state
                            removeCategoryBtn.disabled = true;
                            removeCategoryBtn.innerHTML = '<i class="bi bi-hourglass"></i> Processing...';
                            
                            // Send request to remove category
                            fetch('/admin/categories/remove', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    category_id: categoryId,
                                    replacement_category_id: replacementId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Reset button state
                                removeCategoryBtn.disabled = false;
                                removeCategoryBtn.innerHTML = '<i class="bi bi-trash"></i> Remove Category';
                                
                                if (data.success) {
                                    // Reset dropdowns
                                    document.getElementById('categoryToRemove').value = '';
                                    document.getElementById('replacementCategory').value = '';
                                    
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
                                        text: data.message || 'Failed to remove category',
                                        icon: 'error'
                                    });
                                }
                            })
                            .catch(error => {
                                // Reset button state
                                removeCategoryBtn.disabled = false;
                                removeCategoryBtn.innerHTML = '<i class="bi bi-trash"></i> Remove Category';
                                
                                console.error('Error removing category:', error);
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Failed to remove category: ' + error.message,
                                    icon: 'error'
                                });
                            });
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>
