<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register a Shop - Recyclo</title>
    
    <!-- Required imports as specified -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
    
    <!-- SweetAlert for confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Base styles matching profile.php */
        .profile-container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .sidebar {
            width: 250px;
            background: var(--hoockers-green);
            padding: 20px;
            color: white;
            position: fixed;
            height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 40px;
        }

        /* Updated seller form styles to match profile.php */
        .profile-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .profile-header h1 {
            margin: 0;
            color: var(--hoockers-green);
            font-size: 32px;
            margin-bottom: 20px;
        }

        .profile-header p {
            font-size: 16px;
        }

        .requirements {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .requirements h3 {
            color: var(--hoockers-green);
            font-size: 24px;
            margin-bottom: 20px;
        }

        .requirements ul {
            list-style: none;
            padding: 0;
        }

        .requirements li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #333;
            font-size: 18px;
        }

        .requirements li:before {
            content: "\F26B"; /* Bootstrap Icons check-circle */
            font-family: "Bootstrap Icons";
            margin-right: 10px;
            color: var(--hoockers-green);
        }

        .seller-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #666;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 18px;
        }

        .file-input-wrapper {
            margin-top: 10px;
        }

        .file-label {
            display: block;
            padding: 12px;
            background: #f8f9fa;
            border: 2px dashed #ddd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .file-label:hover {
            border-color: var(--hoockers-green);
            background: #f0f0f0;
        }

        .file-label.has-file {
            border-style: solid;
            border-color: var(--hoockers-green);
            color: var(--hoockers-green);
        }

        .submit-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: #3c5c44; /* Using direct color instead of variable */
            color: white !important; /* Using !important to override any other styles */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .required {
            color: #dc3545;
            margin-left: 3px;
        }

        .input-hint {
            display: block;
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Matching sidebar styles from profile.php */
        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }

        .menu-item i {
            margin-right: 10px;
            font-size: 20px;
        }

        /* Application status styles */
        .application-status-container {
            max-width: 800px;
            margin: 40px auto;
        }

        .status-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .status-box.pending {
            border-top: 5px solid #ffc107;
        }

        .status-box.approved {
            border-top: 5px solid #28a745;
        }

        .status-box.rejected {
            border-top: 5px solid #dc3545;
        }

        .status-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .pending .status-icon {
            color: #ffc107;
        }

        .approved .status-icon {
            color: #28a745;
        }

        .rejected .status-icon {
            color: #dc3545;
        }

        .status-details {
            margin: 25px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            font-size: 16px;
        }

        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 500;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.approved {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .info-message {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #e9ecef;
            border-radius: 10px;
            margin-top: 20px;
        }

        .info-message i {
            color: #517A5B;
            font-size: 1.2rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #517A5B;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #3c5c44;
            transform: translateY(-2px);
        }

        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
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

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/mainlogo.png') }}" alt="Recyclo Logo">
                <h2>Recyclo</h2>
            </div>
            <nav>
                <a href="{{ url('/') }}" class="menu-item">
                    <i class="bi bi-house-door"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('profile') }}" class="menu-item">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bi bi-shield-lock"></i>
                    <span>Privacy Settings</span>
                </a>
                <a href="{{ route('shop.register') }}" class="menu-item active">
                    <i class="bi bi-person-check-fill"></i>
                    <span>Register a Shop</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="menu-item" style="color: #dc3545;" onclick="confirmLogout(event)">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
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

            @if (!isset($application))
                <!-- Show regular application form for new applicants -->
                <div class="profile-header">
                    <h1>Register a Shop</h1>
                    <p>Start your journey as a Recyclo shop owner and contribute to a sustainable future</p>
                </div>

                <div class="requirements">
                    <h3>Requirements</h3>
                    <ul>
                        <li>Valid Government-issued ID</li>
                        <li>Physical store/warehouse address</li>
                        <li>Active email address</li>
                        <li>Mobile number for verification</li>
                    </ul>
                </div>

                <div class="seller-form">
                    <form method="POST" action="{{ route('shop.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" name="shop_name" required placeholder="Enter your shop name" value="{{ old('shop_name') }}">
                            @error('shop_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Shop Address</label>
                            <textarea name="shop_address" rows="3" required placeholder="Enter your complete shop address">{{ old('shop_address') }}</textarea>
                            @error('shop_address')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Valid ID <span class="required">*</span></label>
                            <div class="file-input-wrapper">
                                <label class="file-label">
                                    <i class="bi bi-upload"></i> Upload Valid ID
                                    <input type="file" name="valid_id" accept=".jpg,.jpeg,.png,.pdf" style="display: none;" required>
                                </label>
                            </div>
                            <small class="input-hint">Upload a valid government-issued ID (Max: 5MB)</small>
                            @error('valid_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="submit-btn">Submit Application</button>
                    </form>
                </div>
            @else
                <!-- Show application status -->
                <div class="application-status-container">
                    @if ($application->status == 'pending')
                        <div class="status-box pending">
                            <i class="bi bi-hourglass-split status-icon"></i>
                            <h2>Application Under Review</h2>
                            <p>Your shop application is currently being reviewed by our team.</p>
                            <div class="status-details">
                                <p>Application Date: {{ $application->created_at->format('F j, Y - g:i A') }}</p>
                                @if ($application->updated_at && $application->updated_at != $application->created_at)
                                    <p>Status Update: {{ $application->updated_at->format('F j, Y - g:i A') }}</p>
                                @endif
                                <p>Status: <span class="status-badge pending">Pending</span></p>
                            </div>
                            <div class="info-message">
                                <i class="bi bi-info-circle"></i>
                                <p>Please wait while we verify your information. This process typically takes 1-2 business days.</p>
                            </div>
                        </div>
                    @elseif ($application->status == 'approved')
                        <div class="status-box approved">
                            <i class="bi bi-check-circle-fill status-icon"></i>
                            <h2>Congratulations!</h2>
                            <p>Your application has been approved. You are now a verified Recyclo shop owner.</p>
                            <div class="status-details">
                                <p>Application Date: {{ $application->created_at->format('F j, Y - g:i A') }}</p>
                                @if ($application->updated_at && $application->updated_at != $application->created_at)
                                    <p>Status Update: {{ $application->updated_at->format('F j, Y - g:i A') }}</p>
                                @endif
                                <p>Status: <span class="status-badge approved">Approved</span></p>
                            </div>
                            <a href="{{ route('shop.dashboard') }}" class="btn-primary">
                                <i class="bi bi-shop"></i> Go to Shop Dashboard
                            </a>
                        </div>
                    @elseif ($application->status == 'rejected')
                        <div class="status-box rejected">
                            <i class="bi bi-x-circle-fill status-icon"></i>
                            <h2>Application Not Approved</h2>
                            <p>Unfortunately, your shop application was not approved at this time.</p>
                            <div class="status-details">
                                <p>Application Date: {{ $application->created_at->format('F j, Y - g:i A') }}</p>
                                @if ($application->updated_at && $application->updated_at != $application->created_at)
                                    <p>Status Update: {{ $application->updated_at->format('F j, Y - g:i A') }}</p>
                                @endif
                                <p>Status: <span class="status-badge rejected">Rejected</span></p>
                                @if ($application->remarks)
                                    <p>Reason: {{ $application->remarks }}</p>
                                @endif
                            </div>
                            <div class="info-message">
                                <i class="bi bi-info-circle"></i>
                                <p>You can submit a new application after 30 days with updated information.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
    function confirmLogout(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Logout Confirmation',
            text: "Do you really want to logout?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#517A5B',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'No, stay'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    // Show filename when file is selected
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(e) {
            if (e.target.files[0]) {
                let fileName = e.target.files[0].name;
                let fileSize = e.target.files[0].size / (1024 * 1024); // Convert to MB
                let label = e.target.parentElement;
                
                if (fileSize > 5) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'File size must be less than 5MB',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                    e.target.value = ''; // Clear the input
                    return;
                }

                label.innerHTML = `<i class="bi bi-file-earmark-check"></i> ${fileName}`;
                label.classList.add('has-file');
                input.style.display = 'none'; // Keep the input hidden
                label.appendChild(input); // Re-append the input to the label
            }
        });
    });

    // Form validation
    document.querySelector('form')?.addEventListener('submit', function(e) {
        let validId = document.querySelector('input[name="valid_id"]');

        if (validId && !validId.files[0]) {
            e.preventDefault();
            Swal.fire({
                title: 'Error!',
                text: 'Valid ID is required',
                icon: 'error',
                confirmButtonColor: '#517A5B'
            });
        }
    });
    </script>
</body>
</html>
