<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management - Recyclo Admin</title>
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

        .orders-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .orders-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .orders-heading h1 {
            color: var(--hoockers-green);
            margin: 0;
            font-size: 1.8rem;
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

        .badge.pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge.approved {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .badge.completed {
            background-color: #d4edda;
            color: #155724;
        }

        .badge.cancelled {
            background-color: #f8d7da;
            color: #721c24;
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

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 120px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-option {
            padding: 8px 12px;
            display: block;
            text-decoration: none;
            color: #333;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-option:hover {
            background-color: #f1f1f1;
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

        /* Adding styles for approve/reject buttons */
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .btn-approve {
            background-color: #28a745;
            color: white;
        }
        
        .btn-approve:hover {
            background-color: #218838;
        }
        
        .btn-reject {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-reject:hover {
            background-color: #c82333;
        }

        /* Tab styling for filters */
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
            transition: all 0.3s;
        }
        
        .tab-btn:hover {
            color: var(--hoockers-green);
        }
        
        .tab-btn.active {
            color: var(--hoockers-green);
            border-bottom-color: var(--hoockers-green);
        }
        
        .pending-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #ff6b6b;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 12px;
            margin-left: 5px;
        }
        
        .highlight-row {
            background-color: #fff8e1;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { background-color: #fff8e1; }
            50% { background-color: #ffecb3; }
            100% { background-color: #fff8e1; }
        }
        
        .approval-section {
            background: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
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
            position: relative;
            background-color: #fff;
            margin: 15% auto;
            padding: 20px 25px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: modal-appear 0.3s;
        }
        
        @keyframes modal-appear {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .modal-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .modal-header h4 {
            margin: 0;
            flex: 1;
            font-size: 1.4rem;
            color: #333;
        }
        
        .modal-close {
            font-size: 24px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }
        
        .modal-body {
            margin-bottom: 20px;
            font-size: 16px;
            color: #666;
        }
        
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
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
                <a href="{{ route('admin.orders') }}" class="nav-link active">
                    <i class="bi bi-cart"></i> Orders
                </a>
                <a href="{{ route('admin.users') }}" class="nav-link">
                    <i class="bi bi-people"></i> Users
                </a>
                <a href="{{ route('admin.shops') }}" class="nav-link">
                    <i class="bi bi-shop"></i> Shops
                </a>
                <!-- Change to use SweetAlert2 directly instead of showing custom modal -->
                <a href="javascript:void(0)" class="nav-link" onclick="confirmLogout()">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </nav>
        </div>

        <div class="main-content">
            
            <div class="orders-card">
                <div class="orders-heading">
                    <h1><i class="bi bi-cart"></i> Orders Management</h1>
                </div>

                <!-- Order Requests Awaiting Approval -->
                @php
                    $pendingOrders = $orders->where('status', 'pending')->count();
                @endphp
                
                @if($pendingOrders > 0)
                <div class="approval-section">
                    <h3 style="margin-top: 0; color: #856404;"><i class="bi bi-exclamation-triangle"></i> Pending Order Requests: {{ $pendingOrders }}</h3>
                    <p>You have {{ $pendingOrders }} order request(s) waiting for your approval. Please review them below.</p>
                </div>
                @endif
                
                <!-- Tabs for filtering orders -->
                <div class="tab-container">
                    <div class="tab-buttons">
                        <button class="tab-btn active" data-tab="all">All Orders</button>
                        <button class="tab-btn" data-tab="pending">
                            Pending Approval 
                            @if($pendingOrders > 0)
                                <span class="pending-count">{{ $pendingOrders }}</span>
                            @endif
                        </button>
                        <button class="tab-btn" data-tab="approved">Approved</button>
                        <button class="tab-btn" data-tab="completed">Completed</button>
                        <button class="tab-btn" data-tab="cancelled">Cancelled</button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Buyer</th>
                                <th>Seller</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($orders) > 0)
                                @foreach($orders as $order)
                                <tr class="order-row {{ $order->status }} {{ $order->status == 'pending' ? 'highlight-row' : '' }}">
                                    <td>#{{ $order->id }}</td>
                                    <td>
                                        @if($order->buyer)
                                            {{ $order->buyer->username }}
                                        @elseif($order->user)
                                            {{ $order->user->username }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->seller)
                                            {{ $order->seller->username }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->post)
                                            {{ $order->post->title }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge {{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <div class="action-buttons">
                                                <!-- Fix the approve order form action path -->
                                                <form action="{{ route('admin.orders.approve', ['orderId' => $order->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-approve" title="Approve Order">
                                                        <i class="bi bi-check-circle"></i> Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.orders.reject', ['orderId' => $order->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-reject" title="Reject Order">
                                                        <i class="bi bi-x-circle"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="dropdown">
                                                <button class="btn btn-primary">Update Status</button>
                                                <div class="dropdown-content">
                                                    <form action="{{ url('/admin/orders/' . $order->id . '/status') }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="pending">
                                                        <button type="submit" class="dropdown-option">Pending</button>
                                                    </form>
                                                    <form action="/admin/orders/{{ $order->id }}/status" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="dropdown-option">Approved</button>
                                                    </form>
                                                    <form action="/admin/orders/{{ $order->id }}/status" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="dropdown-option">Completed</button>
                                                    </form>
                                                    <form action="/admin/orders/{{ $order->id }}/status" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="dropdown-option">Cancelled</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No orders found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple tab functionality for filtering orders
        document.addEventListener('DOMContentLoaded', function() {
            // Show SweetAlert for session messages
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#517A5B',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'OK'
                });
            @endif

            // Handle form submissions with SweetAlert confirmations
            document.querySelectorAll('.action-buttons form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const isApprove = form.action.includes('approve');
                    const actionText = isApprove ? 'approve' : 'reject';
                    const iconType = isApprove ? 'question' : 'warning';
                    const confirmBtnColor = isApprove ? '#28a745' : '#dc3545';
                    
                    Swal.fire({
                        title: `${isApprove ? 'Approve' : 'Reject'} Order?`,
                        text: `Are you sure you want to ${actionText} this order?`,
                        icon: iconType,
                        showCancelButton: true,
                        confirmButtonColor: confirmBtnColor,
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: `Yes, ${actionText} it!`,
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Handle status update dropdown actions with confirmation
            document.querySelectorAll('.dropdown-content form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const newStatus = form.querySelector('input[name="status"]').value;
                    
                    Swal.fire({
                        title: 'Update Status?',
                        text: `Are you sure you want to update the status to ${newStatus}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#517A5B',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, update it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Existing tab functionality
            const tabButtons = document.querySelectorAll('.tab-btn');
            const orderRows = document.querySelectorAll('.order-row');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Get the tab value
                    const tabValue = this.getAttribute('data-tab');
                    
                    // Show/hide rows based on selected tab
                    orderRows.forEach(row => {
                        if (tabValue === 'all') {
                            row.style.display = 'table-row';
                        } else {
                            if (row.classList.contains(tabValue)) {
                                row.style.display = 'table-row';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });
                });
            });
        });

        // New confirmLogout function using SweetAlert2
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
        
        // Remove the old logout modal functions since we're using SweetAlert2 now
        
        // Close modal when clicking outside of it
        window.onclick = function(event) {
            // ...existing code for other modals if needed...
        }
    </script>
</body>
</html>
