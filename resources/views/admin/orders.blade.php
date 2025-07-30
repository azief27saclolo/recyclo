<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Orders Management - Recyclo Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Add SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- External CSS file -->
    <link href="{{ asset('css/admin-styles.css') }}" rel="stylesheet">
    <style>
        .icon-btn-transfer {
            background-color: #28a745;
            color: white;
        }
        .icon-btn-transfer:hover {
            background-color: #218838;
        }
        .order-info-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .transfer-form-section .form-group {
            margin-bottom: 15px;
        }
        .transfer-form-section label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }
        .transfer-form-section .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .transfer-form-section .form-control:focus {
            border-color: #28a745;
            outline: none;
            box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25);
        }
        .payment-breakdown {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
            margin: 10px 0;
        }
        .payment-breakdown .breakdown-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .payment-breakdown .breakdown-row:last-child {
            margin-bottom: 0;
            font-weight: bold;
            border-top: 1px solid #dee2e6;
            padding-top: 8px;
        }
        .text-success { color: #28a745 !important; }
        .text-danger { color: #dc3545 !important; }
        .text-muted { color: #6c757d !important; }
    </style>
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

                                            @if($order->status == 'processing' || $order->status == 'approved')
                                                <button type="button" class="icon-btn icon-btn-transfer transfer-money-btn" data-order-id="{{ $order->id }}" title="Transfer Money to Seller">
                                                    <i class="bi bi-cash-coin"></i>
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

    <!-- Transfer Money Modal -->
    <div id="transferModal" class="modal">
        <div class="modal-content" style="width: 90%; max-width: 600px;">
            <div class="modal-header">
                <h4><i class="bi bi-cash-coin"></i> Transfer Money to Seller</h4>
                <span class="modal-close" id="closeTransferModal">&times;</span>
            </div>
            <form id="transferForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="transferOrderInfo" class="order-info-section">
                        <!-- Order information will be loaded here -->
                    </div>
                    
                    <div class="transfer-form-section">
                        <div class="form-group">
                            <label for="payment_method">Payment Method *</label>
                            <select id="payment_method" name="payment_method" class="form-control" required>
                                <option value="gcash">GCash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recipient_contact">Recipient Contact (GCash Number/Bank Details) *</label>
                            <input type="text" id="recipient_contact" name="recipient_contact" class="form-control" 
                                   placeholder="09XXXXXXXXX or Bank Account Details" required>
                        </div>

                        <div class="form-group">
                            <label for="reference_number">Reference Number *</label>
                            <input type="text" id="reference_number" name="reference_number" class="form-control" 
                                   placeholder="GCash Reference or Bank Transaction ID" required>
                        </div>

                        <div class="form-group">
                            <label for="payment_proof">Payment Proof (Screenshot)</label>
                            <input type="file" id="payment_proof" name="payment_proof" class="form-control" 
                                   accept="image/*">
                            <small class="text-muted">Upload screenshot of payment confirmation</small>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes (Optional)</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3" 
                                      placeholder="Additional notes about the transfer..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelTransferBtn">Cancel</button>
                    <button type="submit" class="btn btn-success" id="confirmTransferBtn">
                        <i class="bi bi-check-circle"></i> Confirm Transfer
                    </button>
                </div>
            </form>
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

            // Receipt Modal Functionality
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

            // Transfer Money Modal Functionality
            const transferModal = document.getElementById('transferModal');
            const closeTransferModal = document.getElementById('closeTransferModal');
            const cancelTransferBtn = document.getElementById('cancelTransferBtn');
            const transferForm = document.getElementById('transferForm');
            const transferMoneyBtns = document.querySelectorAll('.transfer-money-btn');
            let currentOrderId = null;

            transferMoneyBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    currentOrderId = this.getAttribute('data-order-id');
                    loadTransferModal(currentOrderId);
                });
            });

            closeTransferModal.addEventListener('click', function() {
                transferModal.style.display = 'none';
                transferForm.reset();
            });

            cancelTransferBtn.addEventListener('click', function() {
                transferModal.style.display = 'none';
                transferForm.reset();
            });

            // Transfer form submission
            transferForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitTransfer();
            });
            
            window.addEventListener('click', function(event) {
                if (event.target == receiptModal) {
                    receiptModal.style.display = 'none';
                }
                if (event.target == transferModal) {
                    transferModal.style.display = 'none';
                    transferForm.reset();
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

        function loadTransferModal(orderId) {
            fetch(`/admin/orders/${orderId}/transfer-modal`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const order = data.order;
                        const payment = order.payment_distribution;
                        
                        document.getElementById('transferOrderInfo').innerHTML = `
                            <h5>Order #${order.id}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Buyer:</strong> ${order.buyer_name}</p>
                                    <p><strong>Seller:</strong> ${order.seller_name}</p>
                                    <p><strong>Product:</strong> ${order.product_name}</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="payment-breakdown">
                                        <div class="breakdown-row">
                                            <span>Order Amount:</span>
                                            <span>₱${Number(payment?.order_amount || order.total_amount).toLocaleString('en-US', {minimumFractionDigits: 2})}</span>
                                        </div>
                                        <div class="breakdown-row">
                                            <span>Platform Fee (5%):</span>
                                            <span class="text-danger">-₱${Number(payment?.platform_fee || (order.total_amount * 0.05)).toLocaleString('en-US', {minimumFractionDigits: 2})}</span>
                                        </div>
                                        <div class="breakdown-row">
                                            <span>Amount to Transfer:</span>
                                            <span class="text-success">₱${Number(payment?.seller_amount || (order.total_amount * 0.95)).toLocaleString('en-US', {minimumFractionDigits: 2})}</span>
                                        </div>
                                    </div>
                                    ${payment?.status === 'completed' ? `
                                        <div class="alert alert-success">
                                            <i class="bi bi-check-circle"></i> Payment already transferred on ${payment.paid_at}
                                            <br><small>Reference: ${payment.reference_number}</small>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        `;

                        if (payment?.status === 'completed') {
                            document.getElementById('confirmTransferBtn').style.display = 'none';
                            document.querySelectorAll('#transferForm input, #transferForm select, #transferForm textarea').forEach(el => {
                                el.disabled = true;
                            });
                        }

                        transferModal.style.display = 'block';
                    } else {
                        Swal.fire('Error', data.message || 'Failed to load transfer details', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to load transfer details', 'error');
                });
        }

        function submitTransfer() {
            const formData = new FormData(transferForm);
            
            Swal.fire({
                title: 'Confirm Transfer',
                text: 'Are you sure you want to transfer this payment to the seller?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Transfer Now!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/orders/${currentOrderId}/transfer-payment`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Transfer Successful!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                transferModal.style.display = 'none';
                                transferForm.reset();
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Failed to transfer payment', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Failed to transfer payment', 'error');
                    });
                }
            });
        }

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