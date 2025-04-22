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
    </style>
</head>
<body>
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
                    <button id="manageCategoriesBtn" class="btn btn-primary">
                        <i class="bi bi-tags"></i> Manage Categories
                    </button>
                </div>
                
                <div class="search-filters">
                    <div class="search-box">
                        <input type="text" id="productSearch" class="form-control" placeholder="Search products by title, seller, etc...">
                    </div>
                    <div class="category-filter">
                        <select id="categoryFilter" class="form-control">
                            <option value="">All Categories</option>
                            @php
                                $categories = \App\Models\Category::where('is_active', true)
                                                ->orderBy('name')
                                                ->get();
                            @endphp
                            
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
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
                                    <td><span class="badge" style="background-color: {{ $product->category->color ?? '#f0f0f0' }}; color: {{ $product->category->color ? getContrastColor($product->category->color) : '#333' }}">{{ $product->category->name }}</span></td>
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
                                        <button class="btn btn-primary btn-sm view-product" data-id="{{ $product->id }}">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                        <button class="btn btn-warning btn-sm edit-product" data-id="{{ $product->id }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
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
        
        // View product details modal
        const modal = document.getElementById('productModal');
        const closeBtn = document.querySelector('.close');
        const viewButtons = document.querySelectorAll('.view-product');
        
        // Click event for view buttons
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                fetchProductDetails(productId);
            });
        });
        
        // Close modal when clicking X button
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
        
        // Function to fetch product details via AJAX
        function fetchProductDetails(productId) {
            fetch(`/admin/products/${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const product = data.product;
                        
                        // Update modal content
                        document.getElementById('modalProductTitle').textContent = product.title;
                        document.getElementById('modalProductCategory').textContent = product.category.name;
                        document.getElementById('modalProductPrice').textContent = `₱${parseFloat(product.price).toFixed(2)} / ${product.unit}`;
                        document.getElementById('modalProductQuantity').textContent = `${product.quantity} ${product.unit}`;
                        document.getElementById('modalProductSeller').textContent = product.user ? `${product.user.firstname} ${product.user.lastname}` : 'Unknown';
                        document.getElementById('modalProductLocation').textContent = product.location || 'Not specified';
                        document.getElementById('modalProductAddress').textContent = product.address || 'Not specified';
                        document.getElementById('modalProductDate').textContent = new Date(product.created_at).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        document.getElementById('modalProductDescription').textContent = product.description || 'No description provided';
                        
                        // Set image or placeholder
                        if (product.image) {
                            document.getElementById('modalProductImage').src = `/storage/${product.image}`;
                            document.getElementById('modalProductImage').style.display = 'block';
                        } else {
                            document.getElementById('modalProductImage').style.display = 'none';
                        }
                        
                        // Show modal
                        modal.style.display = 'block';
                    } else {
                        alert('Error loading product details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading product details');
                });
        }

        // Edit product functionality
        const editModal = document.getElementById('editProductModal');
        const editButtons = document.querySelectorAll('.edit-product');
        const closeEditBtn = document.getElementById('closeEditModal');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editForm = document.getElementById('editProductForm');
        
        // Click event for edit buttons
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                fetchProductForEdit(productId);
            });
        });
        
        // Close edit modal when clicking X button
        closeEditBtn.addEventListener('click', function() {
            editModal.style.display = 'none';
        });
        
        // Close edit modal when clicking Cancel button
        cancelEditBtn.addEventListener('click', function() {
            editModal.style.display = 'none';
        });
        
        // Close edit modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target == editModal) {
                editModal.style.display = 'none';
            }
        });
        
        // Function to fetch product details for editing
        function fetchProductForEdit(productId) {
            fetch(`/admin/products/${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const product = data.product;
                        
                        // Set form action
                        editForm.action = `/admin/products/${productId}/update`;
                        
                        // Populate form fields
                        document.getElementById('edit_title').value = product.title;
                        document.getElementById('edit_category_id').value = product.category_id || '';
                        document.getElementById('edit_price').value = product.price;
                        document.getElementById('edit_unit').value = product.unit;
                        document.getElementById('edit_quantity').value = product.quantity;
                        document.getElementById('edit_location').value = product.location;
                        document.getElementById('edit_address').value = product.address;
                        document.getElementById('edit_description').value = product.description;
                        
                        // Display current image
                        const currentImage = document.getElementById('currentImage');
                        if (product.image) {
                            currentImage.src = `/storage/${product.image}`;
                            document.getElementById('currentImageContainer').style.display = 'block';
                        } else {
                            document.getElementById('currentImageContainer').style.display = 'none';
                        }
                        
                        // Show modal
                        editModal.style.display = 'block';
                    } else {
                        alert('Error loading product details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading product details');
                });
        }

        // Function to confirm logout with SweetAlert2
        function confirmLogout() {
            Swal.fire({
                title: 'Confirm Logout',
                text: "Are you sure you want to logout from the admin panel?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#517A5B',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.logout') }}";
                }
            });
        }

        // Category Management
        const categoryModal = document.getElementById('categoryModal');
        const manageCategoriesBtn = document.getElementById('manageCategoriesBtn');
        const closeCategoryModal = document.getElementById('closeCategoryModal');
        const categoriesList = document.getElementById('categoriesList');
        const newCategoryInput = document.getElementById('newCategoryName');
        const addCategoryBtn = document.getElementById('addCategoryBtn');
        const categoryToRemove = document.getElementById('categoryToRemove');
        const replacementCategory = document.getElementById('replacementCategory');
        const removeCategoryBtn = document.getElementById('removeCategoryBtn');
        
        // Open category management modal
        manageCategoriesBtn.addEventListener('click', function() {
            loadCategories();
            categoryModal.style.display = 'block';
        });
        
        // Close category modal
        closeCategoryModal.addEventListener('click', function() {
            categoryModal.style.display = 'none';
        });
        
        // Close category modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === categoryModal) {
                categoryModal.style.display = 'none';
            }
        });
        
        // Load categories from server - improved to display more details
        function loadCategories() {
            fetch('{{ route("admin.categories") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Populate categories list
                        categoriesList.innerHTML = '';
                        
                        // Populate dropdowns
                        categoryToRemove.innerHTML = '<option value="">Select a category</option>';
                        replacementCategory.innerHTML = '<option value="">Select a category</option>';
                        
                        // Sort categories - active first, then by name
                        const sortedCategories = data.categories.sort((a, b) => {
                            if (a.is_active !== b.is_active) {
                                return b.is_active - a.is_active; // Active categories first
                            }
                            return a.name.localeCompare(b.name); // Then alphabetically
                        });
                        
                        sortedCategories.forEach(category => {
                            // Add to visual list
                            const badge = document.createElement('span');
                            badge.className = 'category-badge';
                            badge.style.backgroundColor = category.color || '#f0f0f0';
                            badge.style.color = getContrastColor(category.color || '#f0f0f0');
                            
                            if (!category.is_active) {
                                badge.style.opacity = '0.5';
                                badge.style.textDecoration = 'line-through';
                                badge.title = 'Inactive: ' + (category.description || '');
                                badge.innerHTML = `${category.name} <small>(inactive)</small>`;
                            } else {
                                badge.title = category.description || '';
                                badge.textContent = category.name;
                                
                                // Only add active categories to the removal dropdown
                                const option1 = document.createElement('option');
                                option1.value = category.id;
                                option1.textContent = category.name;
                                option1.style.backgroundColor = category.color + '20';
                                categoryToRemove.appendChild(option1);
                                
                                // Only add active categories to the replacement dropdown
                                const option2 = document.createElement('option');
                                option2.value = category.id;
                                option2.textContent = category.name;
                                option2.style.backgroundColor = category.color + '20';
                                replacementCategory.appendChild(option2);
                            }
                            
                            categoriesList.appendChild(badge);
                        });
                        
                        // Also update the filter dropdown in the main page
                        const categoryFilter = document.getElementById('categoryFilter');
                        categoryFilter.innerHTML = '<option value="">All Categories</option>';
                        
                        // Only active categories for the filter
                        sortedCategories.filter(cat => cat.is_active).forEach(category => {
                            const option = document.createElement('option');
                            option.value = category.id;
                            option.textContent = category.name;
                            option.style.backgroundColor = category.color + '20';
                            categoryFilter.appendChild(option);
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Failed to load categories',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An unexpected error occurred while loading categories',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
        }
        
        // Helper function to determine text color based on background color
        function getContrastColor(hexColor) {
            // Remove # if present
            hexColor = hexColor.replace('#', '');
            
            // Convert to RGB
            const r = parseInt(hexColor.substr(0, 2), 16);
            const g = parseInt(hexColor.substr(2, 2), 16);
            const b = parseInt(hexColor.substr(4, 2), 16);
            
            // Calculate luminance
            const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
            
            // Return black for light colors, white for dark colors
            return luminance > 0.5 ? '#000000' : '#ffffff';
        }
        
        // Add new category
        addCategoryBtn.addEventListener('click', function() {
            const newCategoryName = document.getElementById('newCategoryName').value.trim();
            const newCategoryDescription = document.getElementById('newCategoryDescription').value.trim();
            const newCategoryColor = document.getElementById('newCategoryColor').value;
            
            if (!newCategoryName) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter a category name',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
                return;
            }
            
            fetch('{{ route("admin.categories.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: newCategoryName,
                    description: newCategoryDescription,
                    color: newCategoryColor
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'Category added successfully',
                        icon: 'success',
                        confirmButtonColor: '#517A5B'
                    });
                    
                    // Clear inputs
                    document.getElementById('newCategoryName').value = '';
                    document.getElementById('newCategoryDescription').value = '';
                    document.getElementById('newCategoryColor').value = '#517A5B';
                    
                    // Reload categories
                    loadCategories();
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to add category',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An unexpected error occurred',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
            });
        });
        
        // Remove a category
        removeCategoryBtn.addEventListener('click', function() {
            const categoryId = categoryToRemove.value;
            const replacementCategoryId = replacementCategory.value;
            
            if (!categoryId) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select a category to remove',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
                return;
            }
            
            if (!replacementCategoryId) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select a replacement category',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
                return;
            }
            
            if (categoryId === replacementCategoryId) {
                Swal.fire({
                    title: 'Error!',
                    text: 'The category to remove and replacement category cannot be the same',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
                return;
            }
            
            // Confirm before removing
            Swal.fire({
                title: 'Are you sure?',
                text: `This will remove the selected category and move all its products to the replacement category.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, remove it'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route("admin.categories.remove") }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            category_id: categoryId,
                            replacement_category_id: replacementCategoryId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: data.message || 'Category removed successfully',
                                icon: 'success',
                                confirmButtonColor: '#517A5B'
                            });
                            
                            // Reset selects
                            categoryToRemove.value = '';
                            replacementCategory.value = '';
                            
                            // Reload categories
                            loadCategories();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Failed to remove category',
                                icon: 'error',
                                confirmButtonColor: '#517A5B'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An unexpected error occurred',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    });
                }
            });
        });
    </script>
</body>
</html>
