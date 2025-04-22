<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Reports - Recyclo Admin</title>
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

        .reports-header {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .header-title {
            color: var(--hoockers-green);
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .filters-section {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: flex-end;
            flex-wrap: nowrap;
        }

        .filter-group {
            flex: 1;
            min-width: 0;
        }

        .filter-group.date-filter {
            flex: 0.8;
        }

        .filter-group.button-group {
            flex: 1.2;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .filter-label {
            display: block;
            margin-bottom: 8px;
            color: #666;
            font-size: 0.9rem;
        }

        .filter-input {
            width: 100%;
            padding: 10px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 0.9rem;
            height: 42px;
            box-sizing: border-box;
        }

        .btn-filter {
            height: 42px;
            background-color: var(--hoockers-green);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0 15px;
            cursor: pointer;
            white-space: nowrap;
        }

        .export-btn {
            height: 42px;
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 0 15px;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .reports-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #f8f9fa;
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        .table td {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-completed { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-approved { background: #d1e7dd; color: #0f5132; }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .card-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .card-value {
            font-size: 1.8rem;
            color: var(--hoockers-green);
            font-weight: 600;
        }

        .pagination {
            display: flex;
            justify-content: flex-end;
            padding: 20px;
            gap: 10px;
        }

        .page-btn {
            padding: 8px 15px;
            border: 2px solid var(--hoockers-green);
            border-radius: 5px;
            background: white;
            color: var(--hoockers-green);
            cursor: pointer;
        }

        .page-btn.active {
            background: var(--hoockers-green);
            color: white;
        }

        .view-btn {
            padding: 6px 15px;
            background: var(--hoockers-green);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .view-btn:hover {
            background: var(--hoockers-green_80);
            transform: translateY(-2px);
        }

        .view-btn i {
            font-size: 1rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal-content {
            position: relative;
            background: white;
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            border-radius: 15px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 20px;
            background: var(--hoockers-green);
            color: white;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-modal {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        .modal-body {
            padding: 25px;
        }

        /* Transaction Modal Specific Styles */
        .transaction-details {
            padding: 30px;
        }

        .details-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .section-title {
            color: var(--hoockers-green);
            font-size: 1.2rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            font-size: 1.4rem;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .detail-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .detail-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .detail-value {
            color: #333;
            font-size: 1.1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-value i {
            color: var(--hoockers-green);
            font-size: 1.1rem;
        }

        .transaction-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 500;
        }

        .price-value {
            color: var(--hoockers-green);
            font-weight: 600;
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
                <a href="{{ route('admin.post.requests') }}" class="nav-link">
                    <i class="bi bi-file-earmark-plus"></i> Post Requests
                    @if(App\Models\Post::where('status', App\Models\Post::STATUS_PENDING)->count() > 0)
                        <span class="badge" style="background-color: #FF6B6B; color: white; margin-left: 5px; border-radius: 50%; padding: 3px 8px;">
                            {{ App\Models\Post::where('status', App\Models\Post::STATUS_PENDING)->count() }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.products') }}" class="nav-link">
                    <i class="bi bi-box-seam"></i> Products
                </a>
                <a href="{{ route('admin.shops') }}" class="nav-link">
                    <i class="bi bi-shop"></i> Shops
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-link active">
                    <i class="bi bi-file-earmark-text"></i> Reports
                </a>
                <!-- Change to use SweetAlert2 for logout -->
                <a href="javascript:void(0)" class="nav-link" onclick="confirmLogout()">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="reports-header">
                <h1 class="header-title">Transaction Reports</h1>
                <form action="{{ route('admin.reports') }}" method="GET">
                    <div class="filters-section">
                        <div class="filter-group date-filter">
                            <label class="filter-label">From Date</label>
                            <input type="date" name="from_date" class="filter-input" value="{{ request('from_date') }}">
                        </div>
                        <div class="filter-group date-filter">
                            <label class="filter-label">To Date</label>
                            <input type="date" name="to_date" class="filter-input" value="{{ request('to_date') }}">
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Status</label>
                            <select class="filter-input" id="statusFilter" name="status">
                                <option value="all" @if(request('status') == 'all' || !request('status')) selected @endif>All Status</option>
                                <option value="completed" @if(request('status') == 'completed') selected @endif>Completed</option>
                                <option value="pending" @if(request('status') == 'pending') selected @endif>Pending</option>
                                <option value="approved" @if(request('status') == 'approved') selected @endif>Approved</option>
                                <option value="cancelled" @if(request('status') == 'cancelled') selected @endif>Cancelled</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Search</label>
                            <input type="text" name="search" class="filter-input" placeholder="Search transactions..." value="{{ request('search') }}">
                        </div>
                        <div class="filter-group button-group">
                            <button type="submit" class="btn-filter">Filter</button>
                            <a href="{{ route('admin.reports.export', request()->all()) }}" class="export-btn">
                                <i class="bi bi-download"></i> Export
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="summary-cards">
                <div class="summary-card">
                    <div class="card-label">Total Transactions</div>
                    <div class="card-value">{{ $totalTransactions }}</div>
                </div>
                <div class="summary-card">
                    <div class="card-label">Total Revenue</div>
                    <div class="card-value">₱{{ number_format($totalRevenue, 2) }}</div>
                </div>
                <div class="summary-card">
                    <div class="card-label">Average Order Value</div>
                    <div class="card-value">₱{{ number_format($averageOrderValue, 2) }}</div>
                </div>
            </div>

            <div class="reports-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Date</th>
                            <th>Buyer</th>
                            <th>Seller</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($transactions) > 0)
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($transaction->buyer)
                                        {{ $transaction->buyer->firstname }} {{ $transaction->buyer->lastname }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->seller)
                                        {{ $transaction->seller->firstname }} {{ $transaction->seller->lastname }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->post)
                                        {{ $transaction->post->title }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $transaction->quantity }} {{ $transaction->post->unit ?? '' }}</td>
                                <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                                <td><span class="status-badge status-{{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span></td>
                                <td>
                                    <button class="view-btn" onclick="viewTransactionDetails({{ $transaction->id }})">
                                        <i class="bi bi-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center">No transactions found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $transactions->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>

            <!-- Sellers Table Section -->
            <div class="reports-header" style="margin-top: 40px;">
                <h1 class="header-title">Sellers Overview</h1>
                <div class="filters-section">
                    <div class="filter-group" style="flex-basis: 100%;">
                        <label class="filter-label">Search Seller</label>
                        <input type="text" id="sellerSearch" class="filter-input" placeholder="Search sellers...">
                    </div>
                </div>
            </div>

            <div class="reports-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Seller ID</th>
                            <th>Shop Name</th>
                            <th>Owner Name</th>
                            <th>Total Products</th>
                            <th>Total Sales</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sellersTableBody">
                        @foreach($sellers as $seller)
                        <tr>
                            <td>#{{ $seller->id }}</td>
                            <td>{{ $seller->shop ? $seller->shop->shop_name : 'N/A' }}</td>
                            <td>{{ $seller->firstname }} {{ $seller->lastname }}</td>
                            <td>{{ $seller->posts_count }}</td>
                            <td>₱{{ number_format($seller->total_sales, 2) }}</td>
                            <td><span class="status-badge status-{{ $seller->shop ? $seller->shop->status : 'pending' }}">{{ ucfirst($seller->shop ? $seller->shop->status : 'pending') }}</span></td>
                            <td>
                                <button class="view-btn" onclick="viewSellerDetails({{ $seller->id }})">
                                    <i class="bi bi-eye"></i> View
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if(count($sellers) == 0)
                        <tr>
                            <td colspan="7" class="text-center">No sellers found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $sellers->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Seller Modal -->
    <div id="sellerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Seller Details</h2>
                <button class="close-modal" id="closeSellerModal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="sellerDetailsContent">
                    <!-- This will be filled with AJAX response -->
                    <div class="text-center">Loading seller details...</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Modal -->
    <div id="transactionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="bi bi-receipt"></i> Transaction Details</h2>
                <button class="close-modal" id="closeTransactionModal">&times;</button>
            </div>
            <div id="transactionDetailsContent" class="transaction-details">
                <!-- This will be filled with AJAX response -->
                <div class="text-center">Loading transaction details...</div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality for seller table
        document.getElementById('sellerSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#sellersTableBody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if(text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Function to view seller details
        function viewSellerDetails(sellerId) {
            const modal = document.getElementById('sellerModal');
            const content = document.getElementById('sellerDetailsContent');
            
            // Show loading message
            content.innerHTML = '<div class="text-center"><i class="bi bi-hourglass-split"></i> Loading seller details...</div>';
            modal.style.display = 'block';
            
            // Fetch seller details
            fetch(`{{ url('admin/reports/seller') }}/${sellerId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        content.innerHTML = data.html;
                    } else {
                        content.innerHTML = '<div class="text-center">Error loading seller details.</div>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching seller details:', error);
                    content.innerHTML = '<div class="text-center">Error loading seller details.</div>';
                });
        }

        // Function to view transaction details
        function viewTransactionDetails(transactionId) {
            const modal = document.getElementById('transactionModal');
            const content = document.getElementById('transactionDetailsContent');
            
            // Show loading message
            content.innerHTML = '<div class="text-center"><i class="bi bi-hourglass-split"></i> Loading transaction details...</div>';
            modal.style.display = 'block';
            
            // Fetch transaction details
            fetch(`{{ url('admin/reports/transaction') }}/${transactionId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        content.innerHTML = data.html;
                    } else {
                        content.innerHTML = '<div class="text-center">Error loading transaction details.</div>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching transaction details:', error);
                    content.innerHTML = '<div class="text-center">Error loading transaction details.</div>';
                });
        }

        // Close seller modal
        document.getElementById('closeSellerModal').addEventListener('click', function() {
            document.getElementById('sellerModal').style.display = 'none';
        });

        // Close transaction modal
        document.getElementById('closeTransactionModal').addEventListener('click', function() {
            document.getElementById('transactionModal').style.display = 'none';
        });

        // Close modals when clicking outside
        window.onclick = function(event) {
            const sellerModal = document.getElementById('sellerModal');
            const transactionModal = document.getElementById('transactionModal');
            
            if (event.target == sellerModal) {
                sellerModal.style.display = 'none';
            }
            if (event.target == transactionModal) {
                transactionModal.style.display = 'none';
            }
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
    </script>
</body>
</html>
