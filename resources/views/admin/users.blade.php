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
    <!-- Add Leaflet CSS and JS for OpenStreetMap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
          integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
          crossorigin=""></script>
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

        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 290px;
            min-height: 100vh;
            width: calc(100% - 290px);
            box-sizing: border-box;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--hoockers-green);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--hoockers-green_80);
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.9rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            margin: 0;
            color: #333;
            font-size: 1.8rem;
        }
        
        .action-btn-group {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <x-admin-sidebar activePage="users" />

        <div class="main-content">
            <div class="page-header">
                <h1 class="page-title">Users Management</h1>
                </div>
                
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                        <th>Role</th>
                                <th>Status</th>
                        <th>Joined</th>
                        <th>Action</th>
                            </tr>
                        </thead>
                <tbody>
                                @foreach($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                                    <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                    <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <span class="badge {{ $user->status === 'active' ? 'active' : 'inactive' }}">
                                {{ ucfirst($user->status ?? 'inactive') }}
                            </span>
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                            <div class="action-btn-group">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary btn-sm">View</a>
                            </div>
                                    </td>
                                </tr>
                                @endforeach
                    
                    @if(count($users) == 0)
                    <tr>
                        <td colspan="7" style="text-align: center;">No users found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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
    </script>
</body>
</html>
