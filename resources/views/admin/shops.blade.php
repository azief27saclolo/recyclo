<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shops Management - Recyclo Admin</title>
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

        .shops-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .shops-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .shops-heading h1 {
            color: var(--hoockers-green);
            margin: 0;
            font-size: 1.8rem;
        }

        .status-filters {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .status-pill {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 20px;
            padding: 6px 15px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-pill.active {
            background: var(--hoockers-green);
            color: white;
            border-color: var(--hoockers-green);
        }

        .status-pill .count {
            background: rgba(0,0,0,0.1);
            border-radius: 50%;
            min-width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            padding: 0 4px;
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
            white-space: nowrap;
        }
        
        .table td.address {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
            background-color: #d4edda;
            color: #155724;
        }

        .badge.rejected {
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
        
        .btn-view {
            padding: 4px 10px;
            background-color: #6c757d;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-block;
            margin-bottom: 5px;
        }
        
        .btn-view:hover {
            background-color: #5a6268;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 150px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden;
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
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .modal-header h2 {
            margin: 0;
            color: var(--hoockers-green);
        }
        
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: #000;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
            resize: vertical;
        }
        
        .modal-footer {
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .id-preview {
            margin-top: 10px;
        }
        
        .id-preview img {
            max-width: 100%;
            max-height: 300px;
            display: block;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 4px;
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
        }

        /* Action icons styling */
        .action-icons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .action-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .action-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .action-icon.view-id {
            background-color: #6c757d;
        }
        
        .action-icon.edit {
            background-color: var(--hoockers-green);
        }
        
        .action-icon.status {
            background-color: #007bff;
        }
        
        .action-icon.delete {
            background-color: #dc3545;
        }
        
        .action-icon i {
            font-size: 1rem;
        }
        
        /* Tooltip styling */
        [data-tooltip] {
            position: relative;
        }
        
        [data-tooltip]:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-bottom: 5px;
            padding: 5px 10px;
            border-radius: 3px;
            background-color: #333;
            color: #fff;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            font-size: 12px;
            pointer-events: none;
            z-index: 10;
        }
        
        [data-tooltip]:hover:before {
            opacity: 1;
            visibility: visible;
        }
        
        /* Status dropdown styling adjustments for icons */
        .icon-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .icon-dropdown .dropdown-content {
            left: -60px;
            top: 100%;
            margin-top: 5px;
            min-width: 180px;
        }
        
        .icon-dropdown:hover .dropdown-content {
            display: block;
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
                <a href="{{ route('admin.products') }}" class="nav-link">
                    <i class="bi bi-box-seam"></i> Products
                </a>
                <a href="{{ route('admin.shops') }}" class="nav-link active">
                    <i class="bi bi-shop"></i> Shops
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-link">
                    <i class="bi bi-file-earmark-text"></i> Reports
                </a>
                <!-- Change to use SweetAlert2 for logout -->
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
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Add SweetAlert2 success handling -->
            @if (session('swalSuccess'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: "{{ session('swalSuccess.title') }}",
                            text: "{{ session('swalSuccess.text') }}",
                            icon: "{{ session('swalSuccess.icon') }}",
                            confirmButtonColor: '#517A5B'
                        });
                    });
                </script>
            @endif
            
            <div class="shops-card">
                <div class="shops-heading">
                    <h1><i class="bi bi-shop"></i> Shops Management</h1>
                    <div class="search-box">
                        <input type="text" id="shopSearch" placeholder="Search shops..." class="form-control">
                    </div>
                </div>
                
                <div class="status-filters">
                    <div class="status-pill active" data-status="all">
                        <span>All</span>
                        <span class="count">{{ $shops->count() }}</span>
                    </div>
                    <div class="status-pill" data-status="pending">
                        <span>Pending</span>
                        <span class="count">{{ $pendingCount }}</span>
                    </div>
                    <div class="status-pill" data-status="approved">
                        <span>Approved</span>
                        <span class="count">{{ $approvedCount }}</span>
                    </div>
                    <div class="status-pill" data-status="rejected">
                        <span>Rejected</span>
                        <span class="count">{{ $rejectedCount }}</span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Shop Name</th>
                                <th>Address</th>
                                <th>Owner</th>
                                <th>Registered On</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($shops) > 0)
                                @foreach($shops as $shop)
                                <tr data-status="{{ $shop->status }}">
                                    <td>{{ $shop->id }}</td>
                                    <td>{{ $shop->shop_name }}</td>
                                    <td class="address">{{ $shop->shop_address }}</td>
                                    <td>
                                        @if($shop->user)
                                            {{ $shop->user->firstname }} {{ $shop->user->lastname }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $shop->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge {{ $shop->status }}">
                                            {{ ucfirst($shop->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-icons">
                                            <a href="#" class="action-icon view-id" data-tooltip="View ID" onclick="viewID('{{ $shop->id }}', '{{ asset('storage/' . $shop->valid_id_path) }}')">
                                                <i class="bi bi-card-image"></i>
                                            </a>
                                            
                                            <a href="#" class="action-icon edit" data-tooltip="Edit Shop" onclick="editShop({{ $shop->id }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            
                                            <div class="icon-dropdown">
                                                <a href="#" class="action-icon status" data-tooltip="Update Status">
                                                    <i class="bi bi-arrow-down-up"></i>
                                                </a>
                                                <div class="dropdown-content">
                                                    <button onclick="approveShop({{ $shop->id }}, '{{ addslashes($shop->shop_name) }}')" class="dropdown-option">
                                                        <i class="bi bi-check-circle text-success"></i> Approve
                                                    </button>
                                                    <button onclick="rejectShop({{ $shop->id }})" class="dropdown-option">
                                                        <i class="bi bi-x-circle text-danger"></i> Reject
                                                    </button>
                                                    <button onclick="setPendingShop({{ $shop->id }}, '{{ addslashes($shop->shop_name) }}')" class="dropdown-option">
                                                        <i class="bi bi-hourglass text-warning"></i> Set as Pending
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <a href="#" class="action-icon delete" data-tooltip="Delete Shop" onclick="confirmDeleteShop({{ $shop->id }}, '{{ addslashes($shop->shop_name) }}')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">No shops found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ID Preview Modal -->
    <div id="idModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Valid ID Preview</h2>
                <span class="close">&times;</span>
            </div>
            <div class="id-preview">
                <img id="idImage" src="" alt="Valid ID">
            </div>
        </div>
    </div>
    
    <!-- Reject Shop Modal -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Reject Shop Application</h2>
                <span class="close" onclick="closeRejectModal()">&times;</span>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="rejected">
                
                <div class="form-group">
                    <label for="remarks">Reason for Rejection:</label>
                    <textarea name="remarks" id="remarks" rows="4" required></textarea>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" onclick="closeRejectModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Shop Modal -->
    <div id="editShopModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Shop Details</h2>
                <span class="close" onclick="closeEditShopModal()">&times;</span>
            </div>
            <form id="editShopForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="edit_shop_name">Shop Name:</label>
                    <input type="text" class="form-control" id="edit_shop_name" name="shop_name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_shop_address">Shop Address:</label>
                    <textarea class="form-control" id="edit_shop_address" name="shop_address" rows="2" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_status">Status:</label>
                    <select class="form-control" id="edit_status" name="status" required>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                
                <div class="form-group" id="remarks_container">
                    <label for="edit_remarks">Remarks (required for rejection):</label>
                    <textarea class="form-control" id="edit_remarks" name="remarks" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_valid_id">Replace Valid ID (optional):</label>
                    <input type="file" class="form-control" id="edit_valid_id" name="valid_id">
                    <small class="text-muted">Leave empty to keep the current ID</small>
                </div>
                
                <div class="form-group">
                    <label>Current Valid ID:</label>
                    <div>
                        <img id="current_valid_id" src="" alt="Current Valid ID" style="max-width: 100%; max-height: 200px; margin-top: 10px;">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" onclick="closeEditShopModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Simple search functionality for shops table
        document.getElementById('shopSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if(text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Status filter functionality
        document.querySelectorAll('.status-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                // Update active status
                document.querySelectorAll('.status-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                
                const status = this.getAttribute('data-status');
                const tableRows = document.querySelectorAll('.table tbody tr');
                
                tableRows.forEach(row => {
                    if (status === 'all') {
                        row.style.display = '';
                    } else {
                        const rowStatus = row.getAttribute('data-status');
                        row.style.display = rowStatus === status ? '' : 'none';
                    }
                });
            });
        });
        
        // ID Preview Modal
        const idModal = document.getElementById('idModal');
        const idImage = document.getElementById('idImage');
        const closeBtn = document.getElementsByClassName('close')[0];
        
        function viewID(shopId, imagePath) {
            idImage.src = imagePath;
            idModal.style.display = "block";
        }
        
        closeBtn.onclick = function() {
            idModal.style.display = "none";
        }
        
        // Reject Shop Modal
        const rejectModal = document.getElementById('rejectModal');
        const rejectForm = document.getElementById('rejectForm');
        
        function rejectShop(shopId) {
            Swal.fire({
                title: 'Reject Shop Application',
                html: `<div class="form-group">
                        <label for="swal-remarks" style="text-align: left; display: block; margin-bottom: 8px;">Reason for Rejection:</label>
                        <textarea id="swal-remarks" class="swal2-textarea" style="width: 100%; padding: 12px; border: 1px solid #d9d9d9; border-radius: 4px;" placeholder="Please provide a reason for rejection..." rows="4"></textarea>
                       </div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Reject Shop',
                cancelButtonText: 'Cancel',
                focusCancel: true,
                didOpen: () => {
                    const textarea = document.getElementById('swal-remarks');
                    textarea.focus();
                },
                preConfirm: () => {
                    const remarks = document.getElementById('swal-remarks').value;
                    if (!remarks.trim()) {
                        Swal.showValidationMessage('You must provide a reason for rejection');
                        return false;
                    }
                    return remarks;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Processing...',
                        html: 'Please wait while rejecting the shop.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/shops/${shopId}/status`;
                    form.style.display = 'none';
                    
                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);
                    
                    // Add method field for PUT request
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    form.appendChild(methodField);
                    
                    // Add status field
                    const statusField = document.createElement('input');
                    statusField.type = 'hidden';
                    statusField.name = 'status';
                    statusField.value = 'rejected';
                    form.appendChild(statusField);
                    
                    // Add remarks field
                    const remarksField = document.createElement('input');
                    remarksField.type = 'hidden';
                    remarksField.name = 'remarks';
                    remarksField.value = result.value;
                    form.appendChild(remarksField);
                    
                    // Append form to body
                    document.body.appendChild(form);
                    
                    // Submit the form
                    form.submit();
                }
            });
        }
        
        function closeRejectModal() {
            rejectModal.style.display = "none";
        }
        
        // Edit Shop Modal
        const editShopModal = document.getElementById('editShopModal');
        const editShopForm = document.getElementById('editShopForm');
        
        function editShop(shopId) {
            // Fetch shop details and populate the form
            fetch(`/admin/shops/${shopId}`)
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        const shop = data.shop;
                        
                        // Set form action
                        editShopForm.action = `/admin/shops/${shopId}/edit`;
                        
                        // Populate form fields
                        document.getElementById('edit_shop_name').value = shop.shop_name;
                        document.getElementById('edit_shop_address').value = shop.shop_address;
                        document.getElementById('edit_status').value = shop.status;
                        document.getElementById('edit_remarks').value = shop.remarks || '';
                        
                        // Show/hide remarks field based on status
                        toggleRemarksField();
                        
                        // Set current ID image
                        document.getElementById('current_valid_id').src = `/storage/${shop.valid_id_path}`;
                        
                        // Show the modal
                        editShopModal.style.display = 'block';
                    } else {
                        Swal.fire('Error', 'Failed to load shop details', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'An error occurred while fetching shop details', 'error');
                });
        }
        
        function closeEditShopModal() {
            editShopModal.style.display = 'none';
        }
        
        // Toggle remarks field based on status selection
        document.getElementById('edit_status').addEventListener('change', toggleRemarksField);
        
        function toggleRemarksField() {
            const status = document.getElementById('edit_status').value;
            const remarksField = document.getElementById('edit_remarks');
            
            if (status === 'rejected') {
                remarksField.setAttribute('required', 'required');
                document.getElementById('remarks_container').style.display = 'block';
            } else {
                remarksField.removeAttribute('required');
                document.getElementById('remarks_container').style.display = status === 'approved' ? 'none' : 'block';
            }
        }
        
        // Add styles for form controls
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                .form-control {
                    width: 100%;
                    padding: 8px;
                    border-radius: 4px;
                    border: 1px solid #ddd;
                    margin-bottom: 10px;
                }
                select.form-control {
                    height: 38px;
                    background-color: white;
                }
            </style>
        `);
        
        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target == idModal) {
                idModal.style.display = "none";
            }
            if (event.target == rejectModal) {
                rejectModal.style.display = "none";
            }
            if (event.target == editShopModal) {
                editShopModal.style.display = "none";
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

        // Function to confirm and delete a shop
        function confirmDeleteShop(shopId, shopName) {
            Swal.fire({
                title: 'Delete Shop',
                html: `Are you sure you want to delete the shop "<strong>${shopName}</strong>"?<br><br>
                       <div class="text-danger"><strong>Warning:</strong> This action cannot be undone. All shop data, including valid ID and status history will be permanently removed.</div><br>
                       <div>The shop owner will be able to register a new shop after deletion.</div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Deleting Shop...',
                        html: 'Please wait while we process your request.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Create and submit a form for the DELETE request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/shops/${shopId}/delete`;
                    form.style.display = 'none';
                    
                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);
                    
                    // Add method field for DELETE request
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);
                    
                    // Append form to body
                    document.body.appendChild(form);
                    
                    // Submit the form
                    form.submit();
                }
            });
        }

        // Function to approve a shop with SweetAlert2 confirmation
        function approveShop(shopId, shopName) {
            Swal.fire({
                title: 'Approve Shop',
                html: `Are you sure you want to approve "<strong>${shopName}</strong>"?<br><br>
                       <div>The shop owner will be able to start selling products after approval.</div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Approve',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Processing...',
                        html: 'Please wait while approving the shop.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/shops/${shopId}/status`;
                    form.style.display = 'none';
                    
                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);
                    
                    // Add method field for PUT request
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    form.appendChild(methodField);
                    
                    // Add status field
                    const statusField = document.createElement('input');
                    statusField.type = 'hidden';
                    statusField.name = 'status';
                    statusField.value = 'approved';
                    form.appendChild(statusField);
                    
                    // Append form to body
                    document.body.appendChild(form);
                    
                    // Submit the form
                    form.submit();
                }
            });
        }
        
        // Function to set shop status to pending
        function setPendingShop(shopId, shopName) {
            Swal.fire({
                title: 'Set as Pending',
                html: `Are you sure you want to set "<strong>${shopName}</strong>" as pending?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Set as Pending',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Processing...',
                        html: 'Please wait while updating the shop status.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/shops/${shopId}/status`;
                    form.style.display = 'none';
                    
                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);
                    
                    // Add method field for PUT request
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    form.appendChild(methodField);
                    
                    // Add status field
                    const statusField = document.createElement('input');
                    statusField.type = 'hidden';
                    statusField.name = 'status';
                    statusField.value = 'pending';
                    form.appendChild(statusField);
                    
                    // Append form to body
                    document.body.appendChild(form);
                    
                    // Submit the form
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
