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
    <!-- External CSS file -->
    <link href="{{ asset('css/admin-styles.css') }}" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <x-admin-sidebar activePage="orders" />

        <div class="main-content">
            
            <div class="orders-card">
                <div class="orders-heading">
                    <h1><i class="bi bi-cart"></i> Orders Management</h1>
                </div>

                @php
                    $pendingOrders = $orders->where('status', 'pending')->count();
                @endphp
                
                @if($pendingOrders > 0)
                <div class="approval-section">
                    <h3 style="margin-top: 0; color: #856404;"><i class="bi bi-exclamation-triangle"></i> Pending Order Requests: {{ $pendingOrders }}</h3>
                    <p>You have {{ $pendingOrders }} order request(s) waiting for your approval. Please review them below.</p>
                </div>
                @endif
                
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
                                        <div class="action-btn-group">
                                            @if($order->receipt_image)
                                                <button type="button" class="icon-btn icon-btn-view view-receipt-btn" data-receipt="{{ asset('storage/' . $order->receipt_image) }}" title="View Receipt">
                                                    <i class="bi bi-receipt"></i>
                                                </button>
                                            @endif
                                            
                                            @if($order->status == 'pending')
                                                <form action="{{ route('admin.orders.approve', ['orderId' => $order->id]) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="icon-btn icon-btn-approve" title="Approve Order">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.orders.reject', ['orderId' => $order->id]) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="icon-btn icon-btn-reject" title="Reject Order">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <div class="dropdown">
                                                    <button class="icon-btn icon-btn-update" title="Update Status">
                                                        <i class="bi bi-arrow-repeat"></i>
                                                    </button>
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
                                            
                                            <button onclick="confirmDeleteOrder({{ $order->id }})" class="icon-btn icon-btn-delete" title="Delete Order">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
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

    <div id="receiptModal" class="modal">
        <div class="modal-content" style="width: 80%; max-width: 800px;">
            <div class="modal-header">
                <h4>Payment Receipt</h4>
                <span class="modal-close" id="closeReceiptModal">&times;</span>
            </div>
            <div class="modal-body" style="text-align: center;">
                <img id="receiptImage" src="" alt="Payment Receipt" style="max-width: 100%; max-height: 80vh;">
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="closeReceiptBtn">Close</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            const receiptModal = document.getElementById('receiptModal');
            const receiptImage = document.getElementById('receiptImage');
            const closeReceiptModal = document.getElementById('closeReceiptModal');
            const closeReceiptBtn = document.getElementById('closeReceiptBtn');
            const viewReceiptBtns = document.querySelectorAll('.view-receipt-btn');
            
            viewReceiptBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const receiptSrc = this.getAttribute('data-receipt');
                    receiptImage.src = receiptSrc;
                    receiptModal.style.display = 'block';
                });
            });
            
            closeReceiptModal.addEventListener('click', function() {
                receiptModal.style.display = 'none';
            });
            
            closeReceiptBtn.addEventListener('click', function() {
                receiptModal.style.display = 'none';
            });
            
            window.addEventListener('click', function(event) {
                if (event.target == receiptModal) {
                    receiptModal.style.display = 'none';
                }
            });

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

            const tabButtons = document.querySelectorAll('.tab-btn');
            const orderRows = document.querySelectorAll('.order-row');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const tabValue = this.getAttribute('data-tab');
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
        
        function confirmDeleteOrder(orderId) {
            Swal.fire({
                title: 'Delete Order',
                text: "Are you sure you want to delete this order? This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/orders/${orderId}/delete`;
                }
            });
        }
    </script>
</body>
</html>