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

        /* Enhanced Earnings Card */
        .earnings-card {
            background: linear-gradient(135deg, #517A5B 0%, #3a5c42 100%) !important;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(81, 122, 91, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .earnings-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(81, 122, 91, 0.4);
        }
        
        .earnings-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }
        
        .earnings-card::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: -40px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.05);
            z-index: 0;
        }
        
        .earnings-card i {
            margin-bottom: 5px;
            font-size: 24px;
            position: relative;
            z-index: 1;
        }
        
        .earnings-card .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin: -3px 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .earnings-card .stat-label {
            font-weight: 500;
            position: relative;
            z-index: 1;
            font-size: 0.95rem;
            opacity: 0.9;
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

        /* Enhanced Inventory UI Styles */
        .inventory-table-container {
            max-height: 450px;
            overflow-y: auto;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inventory-table thead {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .inventory-table tbody tr {
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s ease;
        }

        .inventory-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .inventory-table tbody tr:last-child {
            border-bottom: none;
        }

        /* Stock indicator styles */
        .stock-indicator {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .in-stock {
            background-color: #d4edda;
            color: #155724;
        }

        .low-stock {
            background-color: #fff3cd;
            color: #856404;
        }

        .out-of-stock {
            background-color: #f8d7da;
            color: #721c24;
        }

        .inventory-action-btn {
            background: none;
            border: none;
            padding: 6px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #6c757d;
        }

        .inventory-action-btn:hover {
            background-color: #f8f9fa;
            color: var(--hoockers-green);
        }

        .inventory-action-btn i {
            font-size: 1.1rem;
        }

        .inventory-action-btn.edit-btn {
            color: #0d6efd;
        }

        .inventory-action-btn.edit-btn:hover {
            background-color: #e7f1ff;
        }

        .inventory-action-btn.delete-btn {
            color: #dc3545;
        }

        .inventory-action-btn.delete-btn:hover {
            background-color: #fff5f5;
        }

        .inventory-table input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            border: 2px solid #dee2e6;
            border-radius: 3px;
        }

        .inventory-actions .action-btn {
            flex: 1;
            padding: 12px 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
        }

        .inventory-actions .action-btn:hover:not(:disabled) {
            transform: translateY(-2px);
        }

        .inventory-actions .action-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn-secondary:hover {
            background-color: #e8e8e8;
        }

        .btn-primary:hover {
            background-color: var(--hoockers-green_80);
        }

        /* Modal animation */
        .modal {
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Close button hover effect */
        .close:hover {
            color: var(--hoockers-green);
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
                        <div class="stat-card earnings-card" style="cursor: pointer;">
                            <i class="bi bi-currency-dollar"></i>
                            <div class="stat-number">
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
                            <div class="stat-label">Earnings (after 10% fee)</div>
                        </div>

                        <!-- New Inventory Stat Card -->
                        <div class="stat-card" id="inventoryStatCard" style="background-color: #517A5B; color: white; cursor: pointer;">
                            <i class="bi bi-box-seam"></i>
                            <div class="stat-number" style="color: white;">
                                @php
                                    try {
                                        // Calculate total inventory by summing up quantities
                                        $totalInventory = \App\Models\Post::where('user_id', Auth::id())->sum('quantity');
                                        echo number_format($totalInventory);
                                    } catch (\Exception $e) {
                                        echo '0';
                                    }
                                @endphp
                            </div>
                            <div style="color: white;">Total Items</div>
                        </div>

                        <!-- New Total Inventory Value Card -->
                        <div class="stat-card" id="inventoryValueCard" style="background-color: #517A5B; color: white; cursor: pointer;">
                            <i class="bi bi-cash-stack"></i>
                            <div class="stat-number" style="color: white;">
                                @php
                                    try {
                                        // Calculate total inventory value (price * quantity for each product)
                                        $inventoryValue = \App\Models\Post::where('user_id', Auth::id())
                                            ->selectRaw('SUM(price * quantity) as total_value')
                                            ->first();
                                        echo '₱' . number_format($inventoryValue->total_value ?? 0, 2);
                                    } catch (\Exception $e) {
                                        echo '₱0.00';
                                    }
                                @endphp
                            </div>
                            <div style="color: white;">Inventory Value</div>
                        </div>
                    </div>
                </div>

                <div class="quick-actions">
                    <a href="{{ route('sell.item') }}" class="action-btn">
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
                                                data-product-category="{{ $product->category_name }}"
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
                                <a href="{{ route('sell.item') }}" class="action-btn" style="display: inline-block; margin-top: 15px;">
                                    <i class="bi bi-plus-circle"></i> Add Product
                                </a>
                            </div>
                        @endif
                    </div>
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

        // Update the products stat card click handler
        document.getElementById('productsStatCard').addEventListener('click', function() {
            window.location.href = "{{ route('sell.item') }}";
        });

        // Inventory Management
        const inventoryModal = document.getElementById('inventoryModal');
        const updateStockModal = document.getElementById('updateStockModal');
        const inventoryHistoryModal = document.getElementById('inventoryHistoryModal');
        const inventoryTableBody = document.getElementById('inventory-table-body');
        const inventorySearch = document.getElementById('inventory-search');
        const categoryFilter = document.getElementById('inventory-category-filter');
        const stockFilter = document.getElementById('inventory-stock-filter');
        const selectAllCheckbox = document.getElementById('select-all-inventory');
        const batchUpdateBtn = document.getElementById('batch-update-btn');
        const exportInventoryBtn = document.getElementById('export-inventory-btn');
        const updateStockForm = document.getElementById('updateStockForm');
        const exportHistoryBtn = document.getElementById('export-history-btn');

        let currentPage = 1;
        let totalPages = 1;
        let selectedItems = new Set();

        // Open inventory modal when clicking inventory stat cards
        document.getElementById('inventoryStatCard').addEventListener('click', () => {
            inventoryModal.style.display = 'block';
            loadInventory();
        });

        document.getElementById('inventoryValueCard').addEventListener('click', () => {
            inventoryModal.style.display = 'block';
            loadInventory();
        });

        // Close modals when clicking the X or outside the modal
        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.addEventListener('click', () => {
                inventoryModal.style.display = 'none';
                updateStockModal.style.display = 'none';
                inventoryHistoryModal.style.display = 'none';
            });
        });

        window.addEventListener('click', (e) => {
            if (e.target === inventoryModal) inventoryModal.style.display = 'none';
            if (e.target === updateStockModal) updateStockModal.style.display = 'none';
            if (e.target === inventoryHistoryModal) inventoryHistoryModal.style.display = 'none';
        });

        // Load inventory data
        function loadInventory() {
            const searchTerm = inventorySearch.value;
            const categoryId = categoryFilter.value;
            const stockLevel = stockFilter.value;

            fetch(`/api/inventory?page=${currentPage}&search=${searchTerm}&category=${categoryId}&stock=${stockLevel}`)
                .then(response => response.json())
                .then(data => {
                    updateInventoryTable(data.products);
                    updateInventoryStats(data.stats);
                    totalPages = data.total_pages;
                    updatePagination();
                })
                .catch(error => {
                    console.error('Error loading inventory:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to load inventory data.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
        }

        // Update inventory table with data
        function updateInventoryTable(products) {
            inventoryTableBody.innerHTML = '';
            selectedItems.clear();
            updateSelectedItemsCount();

            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="padding: 12px; text-align: center;">
                        <input type="checkbox" class="product-checkbox" data-id="${product.id}">
                    </td>
                    <td style="padding: 12px;">${product.title}</td>
                    <td style="padding: 12px;">${product.category_name}</td>
                    <td style="padding: 12px; text-align: center;">
                        <span class="stock-indicator ${getStockClass(product.quantity)}">
                            ${product.quantity}
                        </span>
                    </td>
                    <td style="padding: 12px; text-align: right;">₱${product.price}</td>
                    <td style="padding: 12px; text-align: center;">
                        <button class="inventory-action-btn edit-btn" 
                            onclick="editProduct(${product.id})"
                            data-product-id="${product.id}"
                            data-product-title="${product.title}"
                            data-product-category-id="${product.category_id}"
                            data-product-category="${product.category_name}"
                            data-product-location="${product.location}"
                            data-product-unit="${product.unit}"
                            data-product-quantity="${product.quantity}"
                            data-product-price="${product.price}"
                            data-product-description="${product.description}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="inventory-action-btn" onclick="viewHistory(${product.id})">
                            <i class="bi bi-clock-history"></i>
                        </button>
                    </td>
                `;
                inventoryTableBody.appendChild(row);
            });

            // Add event listeners to checkboxes
            document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', (e) => {
                    const productId = e.target.dataset.id;
                    if (e.target.checked) {
                        selectedItems.add(productId);
                    } else {
                        selectedItems.delete(productId);
                    }
                    updateSelectedItemsCount();
                });
            });
        }

        // Update inventory statistics
        function updateInventoryStats(stats) {
            document.getElementById('dashboard-inventory-value').textContent = `₱${stats.total_value}`;
            document.getElementById('low-stock-count').textContent = stats.low_stock;
            document.getElementById('out-stock-count').textContent = stats.out_of_stock;
        }

        // Get stock level class
        function getStockClass(quantity) {
            if (quantity <= 0) return 'out-of-stock';
            if (quantity < 10) return 'low-stock';
            return 'in-stock';
        }

        // Update pagination controls
        function updatePagination() {
            const prevBtn = document.getElementById('inventory-prev-page-btn');
            const nextBtn = document.getElementById('inventory-next-page-btn');
            const pageInfo = document.getElementById('inventory-pagination-info');

            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;
            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
        }

        // Update selected items count
        function updateSelectedItemsCount() {
            const count = selectedItems.size;
            document.getElementById('selected-items-count').textContent = `${count} items selected`;
            batchUpdateBtn.disabled = count === 0;
        }

        // Event listeners for filters and search
        inventorySearch.addEventListener('input', debounce(loadInventory, 300));
        categoryFilter.addEventListener('change', loadInventory);
        stockFilter.addEventListener('change', loadInventory);

        // Select all checkbox
        selectAllCheckbox.addEventListener('change', (e) => {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
                const productId = checkbox.dataset.id;
                if (e.target.checked) {
                    selectedItems.add(productId);
                } else {
                    selectedItems.delete(productId);
                }
            });
            updateSelectedItemsCount();
        });

        // Pagination buttons
        document.getElementById('inventory-prev-page-btn').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                loadInventory();
            }
        });

        document.getElementById('inventory-next-page-btn').addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                loadInventory();
            }
        });

        // Batch update button
        batchUpdateBtn.addEventListener('click', () => {
            if (selectedItems.size === 0) return;

            Swal.fire({
                title: 'Batch Update Stock',
                html: `
                    <div class="form-group">
                        <label class="form-label">Action</label>
                        <select id="batch-stock-action" class="form-control">
                            <option value="add">Add Stock</option>
                            <option value="remove">Remove Stock</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number" id="batch-stock-quantity" class="form-control" min="1" value="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notes (Optional)</label>
                        <textarea id="batch-stock-notes" class="form-control" rows="3"></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonColor: '#517A5B',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Update',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const action = document.getElementById('batch-stock-action').value;
                    const quantity = document.getElementById('batch-stock-quantity').value;
                    const notes = document.getElementById('batch-stock-notes').value;

                    if (!quantity || quantity < 1) {
                        Swal.showValidationMessage('Please enter a valid quantity');
                        return false;
                    }

                    return { action, quantity, notes };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { action, quantity, notes } = result.value;
                    updateBatchStock(action, quantity, notes);
                }
            });
        });

        // Export inventory button
        exportInventoryBtn.addEventListener('click', () => {
            const searchTerm = inventorySearch.value;
            const categoryId = categoryFilter.value;
            const stockLevel = stockFilter.value;

            window.location.href = `/api/inventory/export?search=${searchTerm}&category=${categoryId}&stock=${stockLevel}`;
        });

        // Export history button
        exportHistoryBtn.addEventListener('click', () => {
            const productId = document.getElementById('inventory-history-body').dataset.productId;
            window.location.href = `/api/inventory/history/export?product_id=${productId}`;
        });

        // Helper function for debouncing
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

        // Update stock function
        window.updateStock = function(productId, currentStock) {
            document.getElementById('update-product-id').value = productId;
            document.getElementById('update-current-stock').textContent = currentStock;
            updateStockModal.style.display = 'block';
        };

        // View history function
        window.viewHistory = function(productId) {
            fetch(`/api/inventory/history?product_id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    const historyBody = document.getElementById('inventory-history-body');
                    historyBody.dataset.productId = productId;
                    historyBody.innerHTML = '';

                    data.forEach(record => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td style="padding: 12px;">${record.date}</td>
                            <td style="padding: 12px;">${record.product_name}</td>
                            <td style="padding: 12px; text-align: center;">
                                <span class="stock-indicator ${record.action === 'add' ? 'in-stock' : 'out-of-stock'}">
                                    ${record.action}
                                </span>
                            </td>
                            <td style="padding: 12px; text-align: center;">${record.quantity}</td>
                            <td style="padding: 12px;">${record.notes || '-'}</td>
                        `;
                        historyBody.appendChild(row);
                    });

                    inventoryHistoryModal.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error loading history:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to load inventory history.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
        };

        // Update batch stock function
        function updateBatchStock(action, quantity, notes) {
            const productIds = Array.from(selectedItems);
            
            fetch('/api/inventory/batch-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_ids: productIds,
                    action,
                    quantity,
                    notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Stock updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#517A5B'
                    });
                    loadInventory();
                } else {
                    throw new Error(data.message || 'Failed to update stock');
                }
            })
            .catch(error => {
                console.error('Error updating stock:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Failed to update stock.',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
            });
        }

        // Update stock form submission
        updateStockForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(updateStockForm);
            const productId = formData.get('product_id');
            const action = formData.get('stock_action');
            const quantity = formData.get('quantity');
            const notes = formData.get('notes');

            fetch('/api/inventory/update-stock', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    action,
                    quantity,
                    notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Stock updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#517A5B'
                    });
                    updateStockModal.style.display = 'none';
                    loadInventory();
                } else {
                    throw new Error(data.message || 'Failed to update stock');
                }
            })
            .catch(error => {
                console.error('Error updating stock:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Failed to update stock.',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
            });
        });
    });
    </script>

    <!-- Add new Inventory Management Modal -->
    <div id="inventoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Inventory Management</h2>
                <span class="close">&times;</span>
            </div>

            <!-- Inventory Dashboard Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <div class="dashboard-card inventory-value">
                    <div class="dashboard-card-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h3>Total Value</h3>
                    <p id="dashboard-inventory-value">-</p>
                </div>
                <div class="dashboard-card inventory-status">
                    <div class="dashboard-card-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h3>Stock Alerts</h3>
                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                        <span id="low-stock-count" class="badge badge-warning">0</span>
                        <span id="out-stock-count" class="badge badge-danger">0</span>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div>
                    <label for="inventory-category-filter" style="display: block; font-weight: 600; margin-bottom: 5px;">Category</label>
                    <select id="inventory-category-filter" class="form-control" style="padding: 8px; min-width: 150px;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="inventory-stock-filter" style="display: block; font-weight: 600; margin-bottom: 5px;">Stock Level</label>
                    <select id="inventory-stock-filter" class="form-control" style="padding: 8px; min-width: 150px;">
                        <option value="">All Stock Levels</option>
                        <option value="in-stock">In Stock</option>
                        <option value="low-stock">Low Stock (<10)</option>
                        <option value="out-of-stock">Out of Stock</option>
                    </select>
                </div>
                <div>
                    <label for="inventory-search" style="display: block; font-weight: 600; margin-bottom: 5px;">Search</label>
                    <div style="position: relative;">
                        <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                        <input type="text" id="inventory-search" class="form-control" placeholder="Search products..." style="padding: 8px; padding-left: 35px;">
                    </div>
                </div>
            </div>

            <!-- Inventory Table -->
            <div class="inventory-table-container">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th style="padding: 12px; text-align: left;">
                                <input type="checkbox" id="select-all-inventory">
                            </th>
                            <th style="padding: 12px; text-align: left;">Product</th>
                            <th style="padding: 12px; text-align: left;">Category</th>
                            <th style="padding: 12px; text-align: center; white-space: nowrap;">Stock</th>
                            <th style="padding: 12px; text-align: right;">Price</th>
                            <th style="padding: 12px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="inventory-table-body">
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px;">
                                <p>Loading inventory...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="inventory-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <div class="inventory-summary">
                    <span id="selected-items-count">0 items selected</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <button id="inventory-prev-page-btn" class="pagination-btn" disabled>
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <span id="inventory-pagination-info">Page 1 of 1</span>
                    <button id="inventory-next-page-btn" class="pagination-btn">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Inventory Action Buttons -->
            <div class="inventory-actions">
                <button id="batch-update-btn" class="action-btn" disabled>
                    <i class="bi bi-layers"></i> Batch Update
                </button>
                <button id="export-inventory-btn" class="action-btn">
                    <i class="bi bi-download"></i> Export Inventory
                </button>
            </div>
        </div>
    </div>

    <!-- Update Stock Modal -->
    <div id="updateStockModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Update Stock</h2>
                <span class="close">&times;</span>
            </div>
            <form id="updateStockForm">
                <input type="hidden" name="product_id" id="update-product-id">
                <div class="form-group">
                    <label class="form-label">Current Stock</label>
                    <p id="update-current-stock" style="font-size: 1.2rem; margin-bottom: 10px; padding: 8px; background-color: #f8f9fa; border-radius: 4px;"></p>
                </div>
                <div class="form-group">
                    <label class="form-label" for="stock-action">Action</label>
                    <select name="stock_action" id="stock-action" class="form-control" required>
                        <option value="add">Add Stock</option>
                        <option value="remove">Remove Stock</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="stock-quantity">Quantity</label>
                    <input type="number" name="quantity" id="stock-quantity" class="form-control" min="1" value="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="stock-notes">Notes (Optional)</label>
                    <textarea name="notes" id="stock-notes" class="form-control" rows="3" placeholder="Enter notes about this stock update..."></textarea>
                </div>
                <button type="submit" class="submit-btn">Update Stock</button>
            </form>
        </div>
    </div>

    <!-- Inventory History Modal -->
    <div id="inventoryHistoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Inventory History</h2>
                <span class="close">&times;</span>
            </div>
            <div class="inventory-table-container">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th style="padding: 12px; text-align: left;">Date</th>
                            <th style="padding: 12px; text-align: left;">Product</th>
                            <th style="padding: 12px; text-align: center;">Action</th>
                            <th style="padding: 12px; text-align: center;">Quantity</th>
                            <th style="padding: 12px; text-align: left;">Notes</th>
                        </tr>
                    </thead>
                    <tbody id="inventory-history-body">
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">
                                <p>Loading history...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Export History Button -->
            <div style="margin-top: 20px; text-align: right;">
                <button id="export-history-btn" class="action-btn">
                    <i class="bi bi-download"></i> Export History
                </button>
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
                </div>

                <!-- Price tables -->
                <div id="plasticPricesTable" style="display: block;">
                    <table class="price-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Material</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Price Range (₱/kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">PET Bottles</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱15 - ₱25</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">HDPE Containers</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱20 - ₱30</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">PVC Pipes</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱18 - ₱28</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="paperPricesTable" style="display: none;">
                    <table class="price-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Material</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Price Range (₱/kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Newspaper</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱8 - ₱12</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Cardboard</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱10 - ₱15</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Office Paper</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱12 - ₱18</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="metalPricesTable" style="display: none;">
                    <table class="price-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Material</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Price Range (₱/kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Aluminum Cans</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱45 - ₱60</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Copper Wire</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱300 - ₱400</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Steel</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱25 - ₱35</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="batteriesPricesTable" style="display: none;">
                    <table class="price-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Material</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Price Range (₱/kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Car Batteries</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱80 - ₱100</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">AA/AAA Batteries</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱60 - ₱80</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="glassPricesTable" style="display: none;">
                    <table class="price-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Material</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Price Range (₱/kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Clear Glass</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱5 - ₱8</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Colored Glass</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱4 - ₱7</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Prices Guide Modal Functionality
        const pricesGuideModal = document.getElementById('pricesGuideModal');
        const pricesGuideBtn = document.getElementById('pricesGuideBtn');
        const pricesGuideCloseBtn = pricesGuideModal.querySelector('.close');
        
        // Tab buttons
        const plasticTabBtn = document.getElementById('plasticTabBtn');
        const paperTabBtn = document.getElementById('paperTabBtn');
        const metalTabBtn = document.getElementById('metalTabBtn');
        const batteriesTabBtn = document.getElementById('batteriesTabBtn');
        const glassTabBtn = document.getElementById('glassTabBtn');
        
        // Price tables
        const plasticPricesTable = document.getElementById('plasticPricesTable');
        const paperPricesTable = document.getElementById('paperPricesTable');
        const metalPricesTable = document.getElementById('metalPricesTable');
        const batteriesPricesTable = document.getElementById('batteriesPricesTable');
        const glassPricesTable = document.getElementById('glassPricesTable');
        
        // Open prices guide modal when button is clicked
        pricesGuideBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent form submission
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
        
        // Tab switching functionality
        plasticTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'block';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'none';
            
            plasticTabBtn.classList.add('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass';
        });
        
        paperTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'block';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'none';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.add('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass';
        });
        
        metalTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'block';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'none';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.add('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass';
        });
        
        batteriesTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'block';
            glassPricesTable.style.display = 'none';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.add('active-tab');
            glassTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            glassTabBtn.innerHTML = 'Glass';
        });
        
        glassTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'block';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.add('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
        });
    </script>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content" style="max-width: 900px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="padding: 25px 30px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h2 class="modal-title" style="color: var(--hoockers-green); font-size: 28px; font-weight: 700; margin: 0;">Add New Product</h2>
                <span class="close" style="color: #666; font-size: 32px; font-weight: 300; cursor: pointer; transition: color 0.3s ease;">&times;</span>
            </div>
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-container" style="padding: 30px;">
                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <!-- Left Column -->
                        <div class="form-column">
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="title" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-tag" style="color: var(--hoockers-green);"></i> Product Title
                                </label>
                                <input type="text" name="title" id="title" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter product title..." required>
                                <div class="form-helper" style="margin-top: 8px; font-size: 13px; color: #666;">Give your product a descriptive title</div>
                                @error('title')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="category" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-grid" style="color: var(--hoockers-green);"></i> Category
                                </label>
                                <select name="category" id="category" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    required>
                                    <option value="">--Select Category--</option>
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
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="location" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-geo-alt" style="color: var(--hoockers-green);"></i> Location
                                </label>
                                <input type="text" name="location" id="location" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter location..." required>
                                @error('location')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="unit" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-rulers" style="color: var(--hoockers-green);"></i> Unit
                                </label>
                                <select name="unit" id="unit" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    required>
                                    <option value="">--Select Unit--</option>
                                    <option value="kg">Per Kilogram (kg)</option>
                                    <option value="g">Per Gram (g)</option>
                                    <option value="piece">Per Piece (pc)</option>
                                    <option value="box">Per Box (box)</option>
                                    <option value="pallet">Per Pallet (pallet)</option>
                                </select>
                                @error('unit')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="form-column">
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="quantity" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-box-seam" style="color: var(--hoockers-green);"></i> Quantity
                                </label>
                                <input type="number" name="quantity" id="quantity" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter quantity..." required>
                                @error('quantity')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="price" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-currency-peso" style="color: var(--hoockers-green);"></i> Price per unit
                                </label>
                                <input type="text" name="price" id="price" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter price..." required>
                                <button type="button" id="pricesGuideBtn" class="btn btn-link" 
                                    style="padding: 8px 12px; margin-top: 10px; color: white; background-color: var(--hoockers-green); display: inline-block; text-decoration: none; font-weight: 500; border-radius: 6px; width: auto; text-align: center; transition: all 0.3s ease;">
                                    <i class="bi bi-info-circle"></i> Prices Guide
                                </button>
                                @error('price')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="description" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-text-paragraph" style="color: var(--hoockers-green);"></i> Description
                                </label>
                                <textarea name="description" id="description" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; min-height: 120px; resize: vertical;"
                                    placeholder="Enter description..."></textarea>
                                @error('description')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="image" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
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
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                        <button type="button" class="btn btn-secondary" 
                            style="padding: 12px 25px; border: none; border-radius: 8px; font-size: 15px; font-weight: 500; color: #666; background-color: #f5f5f5; cursor: pointer; transition: all 0.3s ease;"
                            onclick="document.querySelector('#addProductModal .close').click()">
                            <i class="bi bi-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" 
                            style="padding: 12px 25px; border: none; border-radius: 8px; font-size: 15px; font-weight: 500; color: white; background-color: var(--hoockers-green); cursor: pointer; transition: all 0.3s ease;">
                            <i class="bi bi-plus-circle"></i> Add Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
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
    </script>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Product</h2>
                <span class="close">&times;</span>
            </div>
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editProductId" name="id">
                <div class="form-group">
                    <label class="form-label" for="editTitle">Product Title</label>
                    <input type="text" id="editTitle" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="editCategory">Category</label>
                    <select id="editCategory" name="category_id" class="form-control" required>
                        <option value="">--Select Category--</option>
                        @foreach(\App\Models\Category::where('is_active', true)->orderBy('name')->get() as $category)
                            <option value="{{ $category->id }}" 
                                data-color="{{ $category->color }}"
                                style="background-color: {{ $category->color }}20;">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="editLocation">Location</label>
                    <input type="text" id="editLocation" name="location" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="editUnit">Unit</label>
                    <select id="editUnit" name="unit" class="form-control" required>
                        <option value="kg">Kilograms (kg)</option>
                        <option value="g">Grams (g)</option>
                        <option value="pcs">Pieces (pcs)</option>
                        <option value="box">Box</option>
                        <option value="sack">Sack</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="editQuantity">Quantity</label>
                    <input type="number" id="editQuantity" name="quantity" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="editPrice">Price (₱)</label>
                    <input type="number" id="editPrice" name="price" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="editDescription">Description</label>
                    <textarea id="editDescription" name="description" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="editImage">Photo (leave blank to keep current image)</label>
                    <input type="file" id="editImage" name="image" class="form-control" accept="image/*">
                    <div id="editImagePreview" class="mt-2">
                        <img id="editPreviewImg" src="" alt="Current image" style="max-width: 200px; display: none;">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function editProduct(id) {
        const editModal = document.getElementById('editProductModal');
        const button = document.querySelector(`[data-product-id="${id}"]`);
        
        if (!button) {
            Swal.fire({
                title: 'Error!',
                text: 'Could not find product data',
                icon: 'error',
                confirmButtonColor: '#517A5B'
            });
            return;
        }

        // Get data from button attributes
        const productData = {
            id: button.getAttribute('data-product-id'),
            title: button.getAttribute('data-product-title'),
            category_id: button.getAttribute('data-product-category-id'),
            category_name: button.getAttribute('data-product-category'),
            location: button.getAttribute('data-product-location'),
            unit: button.getAttribute('data-product-unit'),
            quantity: button.getAttribute('data-product-quantity'),
            price: button.getAttribute('data-product-price'),
            description: button.getAttribute('data-product-description')
        };

        // Update form action URL with the product ID
        const form = document.getElementById('editProductForm');
        form.action = `/posts/${productData.id}`;

        // Populate form fields
        document.getElementById('editProductId').value = productData.id;
        document.getElementById('editTitle').value = productData.title;
        document.getElementById('editCategory').value = productData.category_id;
        document.getElementById('editLocation').value = productData.location;
        document.getElementById('editUnit').value = productData.unit;
        document.getElementById('editQuantity').value = productData.quantity;
        document.getElementById('editPrice').value = productData.price;
        document.getElementById('editDescription').value = productData.description;

        // Show the modal
        editModal.style.display = 'block';
    }

    function closeEditModal() {
        const editModal = document.getElementById('editProductModal');
        editModal.style.display = 'none';
        // Reset form
        document.getElementById('editProductForm').reset();
        document.getElementById('editPreviewImg').style.display = 'none';
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        const editModal = document.getElementById('editProductModal');
        if (e.target === editModal) {
            closeEditModal();
        }
    });

    // Close modal when clicking the X button
    document.querySelector('#editProductModal .close').addEventListener('click', closeEditModal);

    // ... existing code ...
    </script>
</body>
</html>
