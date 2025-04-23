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
        <div class="sidebar">
            <div class="logo-section">
                <img src="{{ asset('images/mainlogo.png') }}" alt="Recyclo Logo">
                <h2>Recyclo Admin</h2>
            </div>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-link">
                    <i class="bi bi-cart"></i> Orders
                </a>
                <a href="{{ route('admin.users') }}" class="nav-link">
                    <i class="bi bi-people"></i> Users
                </a>
                <a href="{{ route('admin.post.requests') }}" class="nav-link">
                    <i class="bi bi-file-earmark-plus"></i> Post Requests
                    @if(App\Models\Post::where('status', App\Models\Post::STATUS_PENDING)->count() > 0)
                        <span class="badge" style="background-color: #FF6B6B; color: white; margin-left: 5px; border-radius: 50%; padding: 3px 8px;">
                            {{ App\Models\Post::where('status', App\Models\Post::STATUS_PENDING)->count() }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.products') }}" class="nav-link active">
                    <i class="bi bi-box-seam"></i> Products
                </a>
                <a href="{{ route('admin.shops') }}" class="nav-link">
                    <i class="bi bi-shop"></i> Shops
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-link">
                    <i class="bi bi-file-earmark-text"></i> Reports
                </a>
                <a href="javascript:void(0)" class="nav-link" onclick="confirmLogout()">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </nav>
        </div>

        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="products-card">
                <div class="products-heading">
                    <h1><i class="bi bi-box-seam"></i> Products Management</h1>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <a href="{{ route('admin.post.requests') }}" class="btn btn-primary">
                            <i class="bi bi-file-earmark-plus"></i> 
                            Post Requests 
                            @if(isset($pendingPostsCount) && $pendingPostsCount > 0)
                                <span class="badge" style="background-color: #FF6B6B; color: white; margin-left: 5px; border-radius: 50%; padding: 3px 8px;">
                                    {{ $pendingPostsCount }}
                                </span>
                            @endif
                        </a>
                        <button id="manageCategoriesBtn" class="btn btn-primary">
                            <i class="bi bi-tags"></i> Manage Categories
                        </button>
                    </div>
                </div>
                
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
            <form id="editProductForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit_title">Title</label>
                    <input type="text" class="form-control" id="edit_title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="edit_category_id">Category</label>
                    <select class="form-control" id="edit_category_id" name="category_id" required>
                        @foreach(\App\Models\Category::where('is_active', true)->orderBy('name')->get() as $category)
                            <option value="{{ $category->id }}" data-color="{{ $category->color }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_price">Price</label>
                    <input type="number" step="0.01" class="form-control" id="edit_price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="edit_unit">Unit</label>
                    <input type="text" class="form-control" id="edit_unit" name="unit" required>
                </div>
                <div class="form-group">
                    <label for="edit_quantity">Quantity</label>
                    <input type="number" step="0.01" class="form-control" id="edit_quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="edit_location">Location</label>
                    <input type="text" class="form-control" id="edit_location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="edit_address">Address</label>
                    <input type="text" class="form-control" id="edit_address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea class="form-control" id="edit_description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_image">Image</label>
                    <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                    <small class="text-muted">Leave empty to keep current image</small>
                    <div id="currentImageContainer" class="mt-2">
                        <p>Current Image:</p>
                        <img id="currentImage" src="" alt="Current Product Image" style="max-width: 200px; max-height: 200px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
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
    </script>
</body>
</html>
