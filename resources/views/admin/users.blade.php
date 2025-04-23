<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - Recyclo Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Add SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add CSRF token meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .users-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .users-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .users-heading h1 {
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

        .badge.active {
            background-color: #d4edda;
            color: #155724;
        }

        .badge.suspended {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge.inactive {
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

        /* Status filter tabs styling */
        .status-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
            overflow-x: auto;
        }

        .status-tab {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 500;
            color: #495057;
            background: none;
            border: none;
            position: relative;
            transition: all 0.2s ease;
        }

        .status-tab:hover {
            color: var(--hoockers-green);
        }

        .status-tab.active {
            color: var(--hoockers-green);
            font-weight: 600;
        }

        .status-tab.active:after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--hoockers-green);
        }

        .status-count {
            margin-left: 5px;
            background-color: #e9ecef;
            color: #495057;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 0.7rem;
        }

        .status-tab.active .status-count {
            background-color: var(--hoockers-green);
            color: white;
        }

        .no-users-message {
            text-align: center;
            padding: 20px;
            color: #6c757d;
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
            .status-tabs {
                flex-wrap: wrap;
            }
            .status-tab {
                flex: 1;
                text-align: center;
                padding: 10px;
            }
        }

        /* Action button styling */
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            color: #6c757d;
            padding: 5px;
            transition: all 0.2s ease;
            margin-right: 8px;
        }

        .action-btn:hover {
            transform: scale(1.2);
        }

        .action-btn.activate {
            color: #155724;
        }

        .action-btn.activate:hover {
            color: #0f3e1a;
        }

        .action-btn.suspend {
            color: #856404;
        }

        .action-btn.suspend:hover {
            color: #533f03;
        }

        .action-btn.deactivate {
            color: #721c24;
        }

        .action-btn.deactivate:hover {
            color: #491217;
        }

        .action-btn.delete {
            color: #dc3545;
        }

        .action-btn.delete:hover {
            color: #a71d2a;
        }

        .actions-cell {
            white-space: nowrap;
            display: flex;
            align-items: center;
        }

        /* Edit user modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            width: 70%;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        
        .modal-header h2 {
            color: var(--hoockers-green);
            margin: 0;
        }
        
        .close-modal {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close-modal:hover {
            color: #333;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .form-group {
            flex: 1;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Urbanist', sans-serif;
        }
        
        .form-actions {
            padding-top: 20px;
            border-top: 1px solid #ddd;
            margin-top: 20px;
            text-align: right;
        }
        
        /* Add edit button style */
        .action-btn.edit {
            color: #0d6efd;
        }
        
        .action-btn.edit:hover {
            color: #0a58ca;
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
                <a href="{{ route('admin.users') }}" class="nav-link active">
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
            <div class="users-card">
                <div class="users-heading">
                    <h1><i class="bi bi-people"></i> Users Management</h1>
                    <div class="search-box">
                        <input type="text" id="userSearch" placeholder="Search users..." class="form-control">
                    </div>
                </div>
                
                <!-- Status filter tabs -->
                <div class="status-tabs">
                    <button class="status-tab active" data-status="all">
                        All Users <span class="status-count">{{ count($users) }}</span>
                    </button>
                    <button class="status-tab" data-status="active">
                        Active <span class="status-count">{{ $users->where('status', 'active')->count() ?: $users->whereNull('status')->count() }}</span>
                    </button>
                    <button class="status-tab" data-status="suspended">
                        Suspended <span class="status-count">{{ $users->where('status', 'suspended')->count() }}</span>
                    </button>
                    <button class="status-tab" data-status="inactive">
                        Inactive <span class="status-count">{{ $users->where('status', 'inactive')->count() }}</span>
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Shop</th>
                                <th>Joined Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            @if(count($users) > 0)
                                @foreach($users as $user)
                                <tr class="user-row" data-status="{{ $user->status ?? 'active' }}" id="user-row-{{ $user->id }}">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->shop)
                                            {{ $user->shop->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge {{ $user->status ?? 'active' }}">
                                            {{ ucfirst($user->status ?? 'active') }}
                                        </span>
                                    </td>
                                    <td class="actions-cell">
                                        <!-- Activate button -->
                                        <button type="button" class="action-btn activate" title="Activate User" 
                                            onclick="updateUserStatus({{ $user->id }}, 'active', 'Activate', 'Are you sure you want to activate this user?')">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        
                                        <!-- Suspend button -->
                                        <button type="button" class="action-btn suspend" title="Suspend User" 
                                            onclick="updateUserStatus({{ $user->id }}, 'suspended', 'Suspend', 'Are you sure you want to suspend this user? They will be temporarily restricted from using the platform.')">
                                            <i class="bi bi-pause-circle"></i>
                                        </button>
                                        
                                        <!-- Deactivate button -->
                                        <button type="button" class="action-btn deactivate" title="Deactivate User" 
                                            onclick="updateUserStatus({{ $user->id }}, 'inactive', 'Deactivate', 'Are you sure you want to deactivate this user? Their account will be disabled.')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        
                                        <!-- Edit button -->
                                        <button type="button" class="action-btn edit" title="Edit User" 
                                            onclick="openEditUserModal({{ $user->id }})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        
                                        <!-- Delete button -->
                                        <button type="button" class="action-btn delete" title="Delete User" 
                                            onclick="deleteUser({{ $user->id }}, '{{ $user->username }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr id="no-users-row">
                                    <td colspan="8" class="no-users-message">No users found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="bi bi-person-gear"></i> Edit User</h2>
                <span class="close-modal" onclick="closeEditUserModal()">&times;</span>
            </div>
            <form id="editUserForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_user_id">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_firstname">First Name</label>
                        <input type="text" id="edit_firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_middlename">Middle Name</label>
                        <input type="text" id="edit_middlename" name="middlename">
                    </div>
                    <div class="form-group">
                        <label for="edit_lastname">Last Name</label>
                        <input type="text" id="edit_lastname" name="lastname" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_username">Username</label>
                        <input type="text" id="edit_username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" id="edit_email" name="email" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_birthday">Birthday</label>
                        <input type="date" id="edit_birthday" name="birthday" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_number">Phone Number</label>
                        <input type="text" id="edit_number" name="number">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_location">Location</label>
                        <input type="text" id="edit_location" name="location">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_profile_picture">Profile Picture</label>
                        <input type="file" id="edit_profile_picture" name="profile_picture" accept="image/*">
                    </div>
                </div>
                
                <div class="form-row" id="currentPictureContainer" style="display: none;">
                    <div class="form-group">
                        <label>Current Profile Picture</label>
                        <img id="currentProfilePicture" src="" alt="Profile Picture" style="max-width: 100px; max-height: 100px; border-radius: 50%;">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn" style="background-color: #6c757d; color: white;" onclick="closeEditUserModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Function to update user status via AJAX
        function updateUserStatus(userId, status, actionName, confirmMessage) {
            Swal.fire({
                title: actionName + ' User',
                text: confirmMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#517A5B',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, ' + actionName.toLowerCase() + ' user',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we update the user status.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Send AJAX request
                    $.ajax({
                        url: '/admin/users/' + userId + '/status',
                        type: 'PUT',
                        data: { status: status },
                        success: function(response) {
                            if (response.success) {
                                // Update user status in the table
                                const userRow = document.getElementById('user-row-' + userId);
                                if (userRow) {
                                    userRow.dataset.status = status;
                                    userRow.querySelector('.badge').className = 'badge ' + status;
                                    userRow.querySelector('.badge').textContent = status.charAt(0).toUpperCase() + status.slice(1);
                                }
                                
                                // Update tab counts
                                updateStatusCounts();
                                
                                // Show success message
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonColor: '#517A5B'
                                });
                            }
                        },
                        error: function(xhr) {
                            // Show error message
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON ? xhr.responseJSON.message : 'Failed to update user status',
                                icon: 'error',
                                confirmButtonColor: '#517A5B'
                            });
                        }
                    });
                }
            });
        }
        
        // Function to delete user via AJAX
        function deleteUser(userId, username) {
            Swal.fire({
                title: 'Delete User',
                text: 'Are you sure you want to permanently delete user ' + username + '? This action cannot be undone and all associated data will be removed.',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete user',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Deleting User...',
                        text: 'Please wait while we delete the user.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Send AJAX request
                    $.ajax({
                        url: '/admin/users/' + userId,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                // Remove user row from table
                                const userRow = document.getElementById('user-row-' + userId);
                                if (userRow) {
                                    userRow.remove();
                                }
                                
                                // Update tab counts
                                updateStatusCounts();
                                
                                // Show success message
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonColor: '#517A5B'
                                });
                            }
                        },
                        error: function(xhr) {
                            // Show error message
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON ? xhr.responseJSON.message : 'Failed to delete user',
                                icon: 'error',
                                confirmButtonColor: '#517A5B'
                            });
                        }
                    });
                }
            });
        }
        
        // Function to update status counts in the tabs
        function updateStatusCounts() {
            const activeUsers = document.querySelectorAll('.user-row[data-status="active"]').length;
            const suspendedUsers = document.querySelectorAll('.user-row[data-status="suspended"]').length;
            const inactiveUsers = document.querySelectorAll('.user-row[data-status="inactive"]').length;
            const totalUsers = activeUsers + suspendedUsers + inactiveUsers;
            
            document.querySelector('.status-tab[data-status="all"] .status-count').textContent = totalUsers;
            document.querySelector('.status-tab[data-status="active"] .status-count').textContent = activeUsers;
            document.querySelector('.status-tab[data-status="suspended"] .status-count').textContent = suspendedUsers;
            document.querySelector('.status-tab[data-status="inactive"] .status-count').textContent = inactiveUsers;
            
            // If no users are visible, show the no results message
            if (totalUsers === 0) {
                if (!document.getElementById('no-users-row')) {
                    const tbody = document.getElementById('usersTableBody');
                    const newRow = document.createElement('tr');
                    newRow.id = 'no-users-row';
                    newRow.innerHTML = '<td colspan="8" class="no-users-message">No users found</td>';
                    tbody.appendChild(newRow);
                } else {
                    document.getElementById('no-users-row').style.display = '';
                }
            }
        }

        // Simple search functionality for users table
        document.getElementById('userSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.user-row');
            let visibleRows = 0;
            const activeTab = document.querySelector('.status-tab.active');
            const activeStatus = activeTab ? activeTab.dataset.status : 'all';
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const rowStatus = row.dataset.status;
                const matchesSearch = text.includes(searchTerm);
                const matchesStatus = (activeStatus === 'all' || rowStatus === activeStatus);
                
                if(matchesSearch && matchesStatus) {
                    row.style.display = '';
                    visibleRows++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Show or hide the "No users found" message
            const noUsersRow = document.getElementById('no-users-row');
            if (noUsersRow) {
                if (visibleRows === 0) {
                    // Create a new row if it doesn't exist
                    if (!document.getElementById('no-results-row')) {
                        const tbody = document.getElementById('usersTableBody');
                        const newRow = document.createElement('tr');
                        newRow.id = 'no-results-row';
                        newRow.innerHTML = '<td colspan="8" class="no-users-message">No users found matching your criteria</td>';
                        tbody.appendChild(newRow);
                    } else {
                        document.getElementById('no-results-row').style.display = '';
                    }
                } else if (document.getElementById('no-results-row')) {
                    document.getElementById('no-results-row').style.display = 'none';
                }
            }
        });

        // Status tab filtering
        document.querySelectorAll('.status-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Update active tab
                document.querySelectorAll('.status-tab').forEach(t => {
                    t.classList.remove('active');
                });
                this.classList.add('active');
                
                const status = this.dataset.status;
                const tableRows = document.querySelectorAll('.user-row');
                let visibleRows = 0;
                const searchTerm = document.getElementById('userSearch').value.toLowerCase();
                
                tableRows.forEach(row => {
                    const rowStatus = row.dataset.status;
                    const text = row.textContent.toLowerCase();
                    const matchesSearch = text.includes(searchTerm);
                    
                    if ((status === 'all' || rowStatus === status) && matchesSearch) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Show or hide the "No users found" message
                const noUsersRow = document.getElementById('no-users-row');
                if (noUsersRow) {
                    noUsersRow.style.display = 'none';
                }
                
                // Show "No results" message if needed
                if (visibleRows === 0) {
                    // Create a new row if it doesn't exist
                    if (!document.getElementById('no-results-row')) {
                        const tbody = document.getElementById('usersTableBody');
                        const newRow = document.createElement('tr');
                        newRow.id = 'no-results-row';
                        newRow.innerHTML = '<td colspan="8" class="no-users-message">No ' + 
                            (status !== 'all' ? status + ' ' : '') + 'users found' +
                            (searchTerm ? ' matching your search' : '') + '</td>';
                        tbody.appendChild(newRow);
                    } else {
                        const noResultsRow = document.getElementById('no-results-row');
                        noResultsRow.style.display = '';
                        noResultsRow.querySelector('td').textContent = 'No ' + 
                            (status !== 'all' ? status + ' ' : '') + 'users found' +
                            (searchTerm ? ' matching your search' : '');
                    }
                } else if (document.getElementById('no-results-row')) {
                    document.getElementById('no-results-row').style.display = 'none';
                }
            });
        });

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
        
        // Show SweetAlert2 message if there was a success message from previous request
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#517A5B'
            });
        @endif
        
        // Show SweetAlert2 message if there was an error from previous request
        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#517A5B'
            });
        @endif

        // Function to open the edit user modal
        function openEditUserModal(userId) {
            // Reset the form
            document.getElementById('editUserForm').reset();
            
            // Set the user ID in the hidden input
            document.getElementById('edit_user_id').value = userId;
            
            // Show loading state
            Swal.fire({
                title: 'Loading User Data...',
                text: 'Please wait',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Fetch user details
            $.ajax({
                url: '/admin/users/' + userId,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Close the loading dialog
                        Swal.close();
                        
                        // Populate the form with user data
                        const user = response.user;
                        document.getElementById('edit_firstname').value = user.firstname || '';
                        document.getElementById('edit_middlename').value = user.middlename || '';
                        document.getElementById('edit_lastname').value = user.lastname || '';
                        document.getElementById('edit_username').value = user.username || '';
                        document.getElementById('edit_email').value = user.email || '';
                        document.getElementById('edit_birthday').value = user.birthday ? user.birthday.split(' ')[0] : '';
                        document.getElementById('edit_number').value = user.number || '';
                        document.getElementById('edit_location').value = user.location || '';
                        
                        // Show current profile picture if it exists
                        const currentPictureContainer = document.getElementById('currentPictureContainer');
                        const currentProfilePicture = document.getElementById('currentProfilePicture');
                        
                        if (user.profile_picture) {
                            currentProfilePicture.src = '/storage/' + user.profile_picture;
                            currentPictureContainer.style.display = 'block';
                        } else {
                            currentPictureContainer.style.display = 'none';
                        }
                        
                        // Show the modal
                        document.getElementById('editUserModal').style.display = 'block';
                        
                        // Set up form submission
                        setupEditUserForm(userId);
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'Failed to load user details',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                }
            });
        }
        
        // Function to close the edit user modal
        function closeEditUserModal() {
            document.getElementById('editUserModal').style.display = 'none';
        }
        
        // Function to set up the edit user form submission
        function setupEditUserForm(userId) {
            $('#editUserForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                
                // Create form data object to handle file uploads
                const formData = new FormData(this);
                
                // Show loading state
                Swal.fire({
                    title: 'Updating User...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form with AJAX
                $.ajax({
                    url: '/admin/users/' + userId + '/edit',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            // Close the modal
                            closeEditUserModal();
                            
                            // Update the user in the table
                            const user = response.user;
                            const userRow = document.getElementById('user-row-' + userId);
                            
                            if (userRow) {
                                userRow.cells[1].textContent = user.firstname + ' ' + user.lastname;
                                userRow.cells[2].textContent = user.username;
                                userRow.cells[3].textContent = user.email;
                            }
                            
                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#517A5B'
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to update user';
                        
                        // Handle validation errors
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            const errorsList = Object.values(errors).flat();
                            errorMessage = errorsList.join('<br>');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    }
                });
            });
        }
        
        // Close modal if user clicks outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('editUserModal');
            if (event.target === modal) {
                closeEditUserModal();
            }
        }
    </script>
</body>
</html>
