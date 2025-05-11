<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - Recyclo Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --hoockers-green: #517A5B;
            --hoockers-green_80: #517A5Bcc;
            --light-gray: #f8f9fa;
            --border-color: #e9ecef;
            --text-primary: #2c3e50;
            --text-secondary: #6c757d;
        }
        
        body {
            font-family: 'Urbanist', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            color: var(--text-primary);
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            margin-left: 290px;
            min-height: 100vh;
            width: calc(100% - 290px);
            box-sizing: border-box;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .user-profile {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .user-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--hoockers-green);
            box-shadow: 0 4px 15px rgba(81, 122, 91, 0.2);
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
            color: var(--text-primary);
        }

        .user-email {
            color: var(--text-secondary);
            font-size: 16px;
            margin: 0 0 15px 0;
        }

        .user-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .detail-item {
            background: var(--light-gray);
            padding: 20px;
            border-radius: 15px;
            transition: transform 0.2s ease;
        }

        .detail-item:hover {
            transform: translateY(-2px);
        }

        .detail-label {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 8px 0;
            font-weight: 500;
        }

        .detail-value {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: var(--text-primary);
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 40px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-color);
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .table th, .table td {
            padding: 20px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .table th {
            background-color: var(--light-gray);
            color: var(--text-primary);
            font-weight: 600;
            font-size: 15px;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover td {
            background-color: var(--light-gray);
        }

        .badge {
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
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
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--hoockers-green);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--hoockers-green_80);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--hoockers-green);
            margin: 10px 0;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
        }

        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }

            .user-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-picture {
                width: 100px;
                height: 100px;
            }

            .user-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <x-admin-sidebar activePage="users" />

        <div class="main-content">
            <div class="page-header">
                <h1 class="page-title">User Details</h1>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Users
                </a>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ $user->posts->count() }}</div>
                    <div class="stat-label">Total Posts</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $orders->count() }}</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                @if($user->shop)
                <div class="stat-card">
                    <div class="stat-value">{{ $user->shop->posts_count ?? 0 }}</div>
                    <div class="stat-label">Shop Products</div>
                </div>
                @endif
            </div>

            <div class="user-profile">
                <div class="user-header">
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}" 
                         alt="Profile Picture" 
                         class="profile-picture">
                    <div class="user-info">
                        <h2 class="user-name">{{ $user->firstname }} {{ $user->lastname }}</h2>
                        <p class="user-email">{{ $user->email }}</p>
                        <span class="badge {{ $user->status === 'active' ? 'active' : 'inactive' }}">
                            {{ ucfirst($user->status ?? 'inactive') }}
                        </span>
                    </div>
                </div>

                <div class="user-details">
                    <div class="detail-item">
                        <p class="detail-label">Username</p>
                        <p class="detail-value">{{ $user->username }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Role</p>
                        <p class="detail-value">
                            {{ ($user->shop || $user->posts->count() > 0) ? 'Seller' : ucfirst($user->role) }}
                        </p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Joined Date</p>
                        <p class="detail-value">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Location</p>
                        <p class="detail-value">{{ $user->location ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>

            @if($user->shop)
            <h2 class="section-title">Shop Information</h2>
            <div class="user-profile">
                <div class="user-details">
                    <div class="detail-item">
                        <p class="detail-label">Shop Name</p>
                        <p class="detail-value">{{ $user->shop->shop_name }}</p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Shop Status</p>
                        <p class="detail-value">
                            <span class="badge active">Active</span>
                        </p>
                    </div>
                    <div class="detail-item">
                        <p class="detail-label">Shop Location</p>
                        <p class="detail-value">{{ $user->shop->shop_address ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <h2 class="section-title">Recent Orders</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->post->title ?? 'N/A' }}</td>
                            <td>₱{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">No orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <h2 class="section-title">Recent Posts</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->category->name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($post->price, 2) }}</td>
                            <td>
                                <span class="badge {{ $post->status }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">No posts found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Check for success message in session and show popup
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#517A5B'
            });
        @endif

        // Check for error message in session and show popup
        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#517A5B'
            });
        @endif

        function updateUserRole(userId) {
            Swal.fire({
                title: 'Update User Role',
                text: 'Are you sure you want to make this user a seller?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#517A5B',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, make seller',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/users/${userId}/update-role`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'User role updated successfully',
                                icon: 'success',
                                confirmButtonColor: '#517A5B'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Failed to update user role',
                                icon: 'error',
                                confirmButtonColor: '#517A5B'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while updating user role',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    });
                }
            });
        }

        function activateShop(shopId) {
            Swal.fire({
                title: 'Activate Shop',
                text: 'Are you sure you want to activate this shop?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#517A5B',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, activate',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/shops/${shopId}/activate`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Shop activated successfully',
                                icon: 'success',
                                confirmButtonColor: '#517A5B'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Failed to activate shop',
                                icon: 'error',
                                confirmButtonColor: '#517A5B'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while activating shop',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    });
                }
            });
        }
    </script>
</body>
</html> 