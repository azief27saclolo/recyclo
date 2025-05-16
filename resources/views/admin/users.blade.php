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
    <!-- Add Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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

        .badge.restricted {
            background-color: #f8d7da;
            color: #721c24;
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
            border: none;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: var(--hoockers-green);
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #000;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--hoockers-green_80);
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-success:hover {
            background-color: #218838;
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

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab.active {
            background: var(--hoockers-green);
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .reports-count {
            background: #dc3545;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
            margin-left: 5px;
        }
        
        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }

        .report-description {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .modal-lg {
            max-width: 800px;
        }
        
        .badge {
            font-size: 0.85rem;
            padding: 0.5em 0.8em;
        }
        
        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
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

            <div class="tabs">
                <div class="tab active" data-tab="all-users">All Users</div>
                <div class="tab" data-tab="reported-users">
                    Reported Users
                    @if($reportedUsersCount > 0)
                        <span class="reports-count">{{ $reportedUsersCount }}</span>
                    @endif
                </div>
            </div>

            <div class="tab-content active" id="all-users">
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
                                    <span class="badge {{ $user->status === 'active' ? 'active' : ($user->status === 'restricted' ? 'restricted' : 'inactive') }}">
                                        {{ ucfirst($user->status ?? 'inactive') }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="action-btn-group">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary btn-sm">View</a>
                                        @if($user->status === 'active')
                                            <button onclick="restrictUser({{ $user->id }})" class="btn btn-danger btn-sm">Restrict</button>
                                        @elseif($user->status === 'restricted')
                                            <button onclick="unrestrictUser({{ $user->id }})" class="btn btn-success btn-sm">Unrestrict</button>
                                        @endif
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

            <div class="tab-content" id="reported-users">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Reported User</th>
                            <th>Reported By</th>
                            <th>Reason</th>
                            <th>Description</th>
                            <th>Order ID</th>
                            <th>Report Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportedUsers as $user)
                            @foreach($user->reports as $report)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $user->firstname }} {{ $user->lastname }}</strong>
                                                <div class="text-muted small">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $report->reporter->firstname }} {{ $report->reporter->lastname }}</strong>
                                                <div class="text-muted small">{{ $report->reporter->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ ucfirst($report->reason) }}</span>
                                    </td>
                                    <td>
                                        <div class="report-description" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ $report->description }}
                                        </div>
                                        <button type="button" class="btn btn-link btn-sm p-0" onclick="showReportDetails({{ $report->id }})">
                                            View Details
                                        </button>
                                    </td>
                                    <td>{{ $report->order_id }}</td>
                                    <td>{{ $report->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $user->status === 'active' ? 'active' : ($user->status === 'restricted' ? 'restricted' : 'inactive') }}">
                                            {{ ucfirst($user->status ?? 'inactive') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-btn-group">
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary btn-sm">View User</a>
                                            @if($user->status === 'active')
                                                <button onclick="restrictUser({{ $user->id }})" class="btn btn-danger btn-sm">Restrict</button>
                                            @elseif($user->status === 'restricted')
                                                <button onclick="unrestrictUser({{ $user->id }})" class="btn btn-success btn-sm">Unrestrict</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        
                        @if(count($reportedUsers) == 0)
                            <tr>
                                <td colspan="8" style="text-align: center;">No reported users found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Report Details Modal -->
            <div class="modal fade" id="reportDetailsModal" tabindex="-1" aria-labelledby="reportDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportDetailsModalLabel">Report Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="reportDetailsContent">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading report details...</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                document.getElementById(tab.dataset.tab).classList.add('active');
            });
        });

        // Store active tab in localStorage
        function setActiveTab(tabName) {
            localStorage.setItem('activeTab', tabName);
        }

        // Get active tab from localStorage
        function getActiveTab() {
            return localStorage.getItem('activeTab') || 'all-users';
        }

        // Set initial active tab
        document.addEventListener('DOMContentLoaded', function() {
            const activeTab = getActiveTab();
            document.querySelector(`.tab[data-tab="${activeTab}"]`).click();
        });

        // User restriction functions
        function restrictUser(userId) {
            Swal.fire({
                title: 'Restrict User',
                text: "Are you sure you want to restrict this user?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, restrict user',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/users') }}/" + userId + "/restrict",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'User has been restricted.',
                                icon: 'success',
                                confirmButtonColor: '#517A5B'
                            }).then(() => {
                                // Store current active tab
                                const activeTab = document.querySelector('.tab.active').dataset.tab;
                                setActiveTab(activeTab);
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'An error occurred while restricting the user.',
                                icon: 'error',
                                confirmButtonColor: '#517A5B'
                            });
                        }
                    });
                }
            });
        }

        function unrestrictUser(userId) {
            Swal.fire({
                title: 'Unrestrict User',
                text: "Are you sure you want to unrestrict this user?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, unrestrict user',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/users') }}/" + userId + "/unrestrict",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'User has been unrestricted.',
                                icon: 'success',
                                confirmButtonColor: '#517A5B'
                            }).then(() => {
                                // Store current active tab
                                const activeTab = document.querySelector('.tab.active').dataset.tab;
                                setActiveTab(activeTab);
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'An error occurred while unrestricting the user.',
                                icon: 'error',
                                confirmButtonColor: '#517A5B'
                            });
                        }
                    });
                }
            });
        }

        // Update tab click handler to store active tab
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                setActiveTab(tab.dataset.tab);
            });
        });

        // Check for success/error messages in session
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#517A5B'
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#517A5B'
            });
        @endif

        function showReportDetails(reportId) {
            // Show loading state
            $('#reportDetailsContent').html(`
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading report details...</p>
                </div>
            `);

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('reportDetailsModal'));
            modal.show();

            // Make an AJAX call to get report details
            $.ajax({
                url: "{{ route('admin.reports.details', '') }}/" + reportId,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const report = response.report;
                        const modalContent = `
                            <div class="report-details">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold">Reported User</h6>
                                        <p class="mb-1">${report.reported.firstname} ${report.reported.lastname}</p>
                                        <p class="text-muted small mb-0">${report.reported.email}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold">Reported By</h6>
                                        <p class="mb-1">${report.reporter.firstname} ${report.reporter.lastname}</p>
                                        <p class="text-muted small mb-0">${report.reporter.email}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h6 class="fw-bold">Reason</h6>
                                        <p><span class="badge bg-warning">${report.reason}</span></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h6 class="fw-bold">Description</h6>
                                        <p class="mb-0">${report.description}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold">Order ID</h6>
                                        <p class="mb-0">${report.order_id}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold">Report Date</h6>
                                        <p class="mb-0">${new Date(report.created_at).toLocaleString()}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#reportDetailsContent').html(modalContent);
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Failed to load report details.';
                    $('#reportDetailsContent').html(`
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            ${errorMessage}
                        </div>
                    `);
                }
            });
        }
    </script>
</body>
</html>
