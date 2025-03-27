<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <a href="{{ route('admin.shops') }}" class="nav-link active">
                    <i class="bi bi-shop"></i> Shops
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
                                        <a href="#" class="btn-view" onclick="viewID('{{ $shop->id }}', '{{ asset('storage/' . $shop->valid_id_path) }}')">View ID</a>
                                        <div class="dropdown">
                                            <button class="btn btn-primary">Update Status</button>
                                            <div class="dropdown-content">
                                                <form action="/admin/shops/{{ $shop->id }}/status" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="dropdown-option">Approve</button>
                                                </form>
                                                <button onclick="rejectShop({{ $shop->id }})" class="dropdown-option">Reject</button>
                                                <form action="/admin/shops/{{ $shop->id }}/status" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="pending">
                                                    <button type="submit" class="dropdown-option">Set as Pending</button>
                                                </form>
                                            </div>
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
            rejectForm.action = `/admin/shops/${shopId}/status`;
            rejectModal.style.display = "block";
        }
        
        function closeRejectModal() {
            rejectModal.style.display = "none";
        }
        
        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target == idModal) {
                idModal.style.display = "none";
            }
            if (event.target == rejectModal) {
                rejectModal.style.display = "none";
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
