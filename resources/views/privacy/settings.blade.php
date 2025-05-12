<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Privacy Settings - Recyclo</title>
    
    <!-- Required imports -->
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
        :root {
            --primary-color: #517A5B;
            --secondary-color: #3c5c44;
            --accent-color: #8BA888;
            --background-color: #f8f9fa;
            --text-color: #333;
            --text-light: #666;
            --border-radius: 16px;
            --box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        body {
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
            font-family: 'Urbanist', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        .page-container {
            display: flex;
            min-height: 100vh;
            background-color: var(--background-color);
        }

        .main-content {
            flex: 1;
            padding: 40px;
            margin-left: 250px;
            max-width: calc(100% - 250px);
            min-height: 100vh;
            background-color: var(--background-color);
        }

        .privacy-header {
            background: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .privacy-header h1 {
            margin: 0;
            color: var(--primary-color);
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .privacy-header p {
            color: var(--text-light);
            font-size: 18px;
            max-width: 600px;
        }

        .privacy-settings {
            background: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .settings-section {
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid #eee;
        }

        .settings-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .settings-section h2 {
            color: var(--primary-color);
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .settings-section h2 i {
            color: var(--primary-color);
            font-size: 24px;
        }

        .setting-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background: white;
            border-radius: 12px;
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(81, 122, 91, 0.1);
            transition: var(--transition);
        }

        .setting-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }

        .setting-info {
            flex: 1;
        }

        .setting-info h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: var(--text-color);
        }

        .setting-info p {
            margin: 5px 0 0;
            font-size: 14px;
            color: var(--text-light);
        }

        /* Toggle Switch Styles */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-color);
        }

        input:focus + .slider {
            box-shadow: 0 0 1px var(--primary-color);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .save-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            margin-top: 30px;
        }

        .save-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .save-btn i {
            font-size: 18px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
                max-width: 100%;
                padding: 20px;
            }

            .privacy-header,
            .privacy-settings {
                padding: 25px;
            }

            .privacy-header h1 {
                font-size: 32px;
            }

            .settings-section h2 {
                font-size: 22px;
            }

            .setting-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .toggle-switch {
                align-self: flex-end;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <!-- Sidebar Component -->
        <x-sidebar activePage="privacy" />

        <!-- Main Content -->
        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="privacy-header">
                <h1>Privacy Settings</h1>
                <p>Control how your information is displayed on Recyclo</p>
            </div>

            <div class="privacy-settings">
                <form action="{{ route('privacy.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="settings-section">
                        <h2><i class="bi bi-eye"></i> Profile Visibility</h2>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h3>Public Profile</h3>
                                <p>Allow other users to view your profile information</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="public_profile" value="1" {{ $settings->public_profile ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h3>Show Email</h3>
                                <p>Display your email address on your public profile</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="show_email" value="1" {{ $settings->show_email ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h3>Show Location</h3>
                                <p>Display your location on your public profile</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="show_location" value="1" {{ $settings->show_location ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h2><i class="bi bi-bell"></i> Notifications</h2>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h3>Email Notifications</h3>
                                <p>Receive email notifications for important updates</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="email_notifications" value="1" {{ $settings->email_notifications ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <h3>Order Updates</h3>
                                <p>Get notified about your order status changes</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="order_notifications" value="1" {{ $settings->order_notifications ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="save-btn">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add loading state to save button
        document.querySelector('form').addEventListener('submit', function(e) {
            const saveBtn = this.querySelector('.save-btn');
            saveBtn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Saving...';
            saveBtn.disabled = true;
        });
    </script>
</body>
</html> 