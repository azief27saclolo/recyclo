<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible"="ie=edge">
    <title>My Buy Requests - Recyclo</title>
    
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
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/css/login.css', 'resources/js/app.js'])
    
    <!-- SweetAlert for logout confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- OpenStreetMap Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <!-- Leaflet Control Geocoder for search functionality -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <style>
        .profile-container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 40px;
        }

        .content-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .content-header h1 {
            margin: 0;
            color: var(--hoockers-green);
            font-size: 28px;
            margin-bottom: 20px;
        }

        .buy-requests-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .request-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }
        
        .request-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #e9ecef;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            min-height: 220px;
            cursor: pointer;
        }
        
        .request-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .request-card h3 {
            color: var(--hoockers-green);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .request-card p {
            margin: 8px 0;
            color: #495057;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .request-card .timestamp {
            font-size: 12px;
            color: #868e96;
            margin-top: 15px;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 0;
        }
        
        .empty-state h3 {
            font-size: 20px;
            color: #495057;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: #868e96;
            margin-bottom: 25px;
        }
        
        .create-btn {
            background: var(--hoockers-green);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .create-btn:hover {
            background: #3c5c44;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            margin: 20px auto;
            padding: 0;
            width: 70%;
            max-width: 900px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transform: translateY(0);
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .modal-header {
            background: var(--hoockers-green);
            color: white;
            padding: 25px 30px;
            border-bottom: none;
            position: relative;
        }

        .modal-title {
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-title i {
            font-size: 28px;
        }

        .close {
            position: absolute;
            right: 25px;
            top: 25px;
            color: white;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s ease;
            opacity: 0.8;
        }

        .close:hover {
            transform: rotate(90deg);
            opacity: 1;
        }

        .modal-body {
            padding: 35px;
        }

        /* Form Styles */
        .form-container {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px;
            height: 500px;
            display: flex;
            flex-direction: column;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
            flex-shrink: 0;
        }

        .form-content {
            flex: 1;
            overflow-y: auto;
            padding-right: 10px;
            margin-right: -10px;
            height: 100px;
        }

        .form-content::-webkit-scrollbar {
            width: 8px;
        }

        .form-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .form-content::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .form-content::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .form-header h2 {
            color: var(--hoockers-green);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .form-header p {
            color: #6c757d;
            font-size: 16px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 15px;
        }

        .form-label i {
            color: var(--hoockers-green);
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            color: #2c3e50;
        }

        .form-control:hover {
            border-color: #ced4da;
            background-color: #fff;
        }

        .form-control:focus {
            border-color: var(--hoockers-green);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(81, 122, 91, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%232c3e50' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }

        textarea.form-control {
            min-height: 150px;
            max-height: 300px;
            resize: vertical;
            line-height: 1.6;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .form-footer {
            margin-top: 30px;
            display: flex;
            gap: 20px;
            flex-shrink: 0;
            padding-top: 25px;
            border-top: 1px solid #eee;
        }

        .submit-btn {
            flex: 1;
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .submit-btn:hover {
            background: #3c5c44;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(81, 122, 91, 0.2);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn i {
            font-size: 16px;
        }

        .cancel-btn {
            flex: 1;
            background: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e9ecef;
            padding: 16px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .cancel-btn:hover {
            background: #e9ecef;
            color: #495057;
        }

        .form-group .help-text {
            font-size: 13px;
            color: #6c757d;
            margin-top: 6px;
        }

        .form-group .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-group.has-error .form-control {
            border-color: #dc3545;
        }

        .form-group.has-error .form-control:focus {
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        }

        /* Responses Section Styles */
        .responses-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .responses-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .responses-header h2 {
            color: var(--hoockers-green);
            font-size: 24px;
            margin: 0;
        }

        .response-list {
            margin-top: 20px;
        }

        .response-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border-left: 4px solid var(--hoockers-green);
            margin-bottom: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .response-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .response-card.unread {
            background-color: #e8f4ea;
            border-left: 4px solid #ffc107;
        }
        
        .seller-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .seller-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        
        .seller-details {
            flex: 1;
        }
        
        .seller-name {
            font-weight: 600;
            font-size: 18px;
            color: #333;
            margin: 0 0 5px;
        }
        
        .response-meta {
            color: #666;
            font-size: 14px;
            display: flex;
            gap: 15px;
        }
        
        .response-message {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px solid #e9ecef;
        }
        
        .response-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            align-items: center;
        }
        
        .response-button {
            padding: 8px 15px;
            border-radius: 20px;
            color: white;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .view-shop-btn {
            background-color: var(--hoockers-green);
        }
        
        .view-shop-btn:hover {
            background-color: #3c5c44;
        }
        
        .mark-read-btn {
            background-color: #3b82f6;
        }
        
        .mark-read-btn:hover {
            background-color: #2563eb;
        }
        
        .empty-responses {
            text-align: center;
            padding: 40px 20px;
        }
        
        .empty-responses i {
            font-size: 48px;
            color: #dee2e6;
            margin-bottom: 15px;
            display: block;
        }
        
        .empty-responses h3 {
            font-size: 20px;
            color: #495057;
            margin-bottom: 10px;
        }
        
        .empty-responses p {
            color: #6c757d;
        }

        .response-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-unread {
            background-color: #ffc107;
            color: #212529;
        }
        
        .badge-read {
            background-color: #6c757d;
            color: white;
        }
        
        .request-label {
            font-weight: 600;
            color: #495057;
            margin-right: 5px;
        }

        /* SweetAlert2 custom styles for larger modals */
        .swal2-popup.swal2-modal.bigger-modal {
            width: 32em !important;
            max-width: 90% !important;
            font-size: 1.2rem !important;
            padding: 2em !important;
        }
        
        .swal2-popup.swal2-modal.bigger-modal .swal2-title {
            font-size: 1.8em !important;
            margin-bottom: 0.5em !important;
        }
        
        .swal2-popup.swal2-modal.bigger-modal .swal2-content,
        .swal2-popup.swal2-modal.bigger-modal .swal2-html-container {
            font-size: 1.1em !important;
            line-height: 1.5 !important;
        }
        
        .swal2-popup.swal2-modal.bigger-modal .swal2-confirm,
        .swal2-popup.swal2-modal.bigger-modal .swal2-cancel {
            font-size: 1.1em !important;
            padding: 0.6em 1.5em !important;
        }

        /* Overview Modal Styles */
        .overview-modal .modal-content {
            max-width: 700px;
        }

        .overview-header {
            background: var(--hoockers-green);
            color: white;
            padding: 25px 30px;
            border-radius: 20px 20px 0 0;
        }

        .overview-title {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .overview-body {
            padding: 30px;
        }

        .overview-section {
            margin-bottom: 25px;
        }

        .overview-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--hoockers-green);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .info-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 500;
        }

        .description-box {
            position: relative;
            max-height: 24px; /* Height for one line */
            overflow: hidden;
            margin: 10px 0;
            background:rgb(242, 242, 242);
            padding: 20px;
            border-radius: 12px;
            
            display: flex;
            align-items: center; /* Center text vertically */
        }

        .description-text {
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #495057;
            font-size: 15px;
            line-height: 1.6;
            width: 100%; /* Ensure text takes full width */
        }

        /* Remove the expand button and related styles */
        .expand-button {
            display: none;
        }

        /* Remove the fade effect */
        .description-box::after {
            display: none;
        }

        .overview-footer {
            padding: 20px 30px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .overview-btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .edit-overview-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
        }

        .edit-overview-btn:hover {
            background: #3c5c44;
            transform: translateY(-2px);
        }

        .close-overview-btn {
            background: #f8f9fa;
            color: #6c757d;
            border: 1px solid #e9ecef;
        }

        .close-overview-btn:hover {
            background: #e9ecef;
            color: #495057;
        }

        /* Add these styles to your existing CSS */
        #map-container, #edit-map-container {
            height: 300px;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #eee;
            margin-bottom: 20px;
        }

        .search-container {
            position: relative;
            margin-bottom: 20px;
        }

        .loader {
            display: none;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translateY(-50%) rotate(0deg); }
            100% { transform: translateY(-50%) rotate(360deg); }
        }

        .search-results {
            display: none;
            position: absolute;
            left: 0;
            right: 0;
            top: 100%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
        }

        .search-result-item {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: var(--transition);
            font-size: 14px;
        }

        .search-result-item:hover {
            background-color: #f9f9f9;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .selected-location {
            background-color: #f9f9f9;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 15px;
            margin: 20px 0;
            color: var(--text-color);
        }

        .geolocation-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
            background: white;
            border: none;
            border-radius: 4px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.2);
            padding: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .geolocation-btn:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .geolocation-btn i {
            color: var(--hoockers-green);
            font-size: 18px;
        }

        .geolocation-btn.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .custom-marker {
            background-color: var(--hoockers-green);
            border: 2px solid white;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .custom-marker::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-top: 8px solid var(--hoockers-green);
        }

        /* Update the overview modal description box */
        .overview-section .description-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            margin-top: 10px;
            max-height: 250px;
            overflow-y: auto;
            position: relative;
        }

        .overview-section .description-box::-webkit-scrollbar {
            width: 6px;
        }

        .overview-section .description-box::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .overview-section .description-box::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .overview-section .description-box::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .overview-section .description-text {
            color: #2c3e50;
            line-height: 1.6;
            margin: 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .overview-section .description-box::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            background: linear-gradient(transparent, #f8f9fa);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .overview-section .description-box:hover::after {
            opacity: 1;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .request-card .description-box,
            .overview-section .description-box {
                max-height: 180px;
            }
            
            .request-card p,
            .overview-section .description-text {
                font-size: 14px;
            }
        }

        .contact-details-section {
            background: #fff;
            padding: 12px 15px;
            border-radius: 8px;
            margin: 10px 0;
            border: 1px solid #e9ecef;
        }

        .contact-info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #2c3e50;
            font-size: 15px;
        }

        .contact-info-item i {
            color: var(--hoockers-green);
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Include the sidebar component -->
        <x-sidebar :activePage="'buy-requests'" />

        <!-- Main Content -->
        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="content-header">
                <div class="flex justify-between items-center">
                    <div>
                        <h1>My Buy Requests</h1>
                        <p>View and manage your recycling material requests</p>
                    </div>
                    <div>
                        <a href="#" class="create-btn" id="addRequestBtn">
                            <i class="bi bi-plus-circle"></i> Add Buy Request
                        </a>
                    </div>
                </div>
            </div>

            <div class="buy-requests-container">
                @if($buyRequests->count() > 0)
                    <div class="request-grid">
                        @foreach ($buyRequests as $buyRequest)
                            <div class="request-card" 
                                 data-id="{{ $buyRequest->id }}"
                                 data-category="{{ $buyRequest->category }}"
                                 data-quantity="{{ $buyRequest->quantity }}"
                                 data-unit="{{ $buyRequest->unit }}"
                                 data-description="{{ $buyRequest->description }}"
                                 data-location="{{ $buyRequest->location }}"
                                 data-number="{{ $buyRequest->number }}"
                                 data-date="{{ $buyRequest->created_at->format('F j, Y g:i A') }}">
                                <h3>{{ $buyRequest->category }}</h3>
                                <p><strong>Quantity:</strong> {{ $buyRequest->quantity }} {{ $buyRequest->unit }}</p>
                                <p><strong>Description:</strong> 
                                <div class="description-box">
                                   {{ $buyRequest->description }}</p>
                                </div>
                                <p class="timestamp">Posted: {{ $buyRequest->created_at->diffForHumans() }}</p>
                                <div class="action-buttons">
                                    <button class="edit-btn" onclick="openEditModal({{ $buyRequest->id }}, '{{ $buyRequest->category }}', {{ $buyRequest->quantity }}, '{{ $buyRequest->unit }}', '{{ addslashes($buyRequest->description) }}', '{{ addslashes($buyRequest->location) }}', '{{ $buyRequest->number }}')">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="delete-btn" onclick="confirmDelete({{ $buyRequest->id }})">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-basket" style="font-size: 48px; color: #dee2e6; display: block; margin-bottom: 15px;"></i>
                        <h3>You haven't posted any buy requests yet</h3>
                        <p>Create a buy request to let sellers know what you're looking for</p>
                        <a href="#" class="create-btn" onclick="openAddRequestModal(event)">Create Buy Request</a>
                    </div>
                @endif
            </div>

            <!-- Responses From Sellers Section -->
            <div class="responses-container">
                <div class="responses-header">
                    <h2><i class="bi bi-reply-all"></i> Responses From Sellers</h2>
                    @if(isset($responses) && $responses->where('status', 'pending')->count() > 0)
                        <span class="response-badge badge-unread">{{ $responses->where('status', 'pending')->count() }} New</span>
                    @endif
                </div>
                
                @if(isset($responses) && $responses->count() > 0)
                    <div class="response-list">
                        @foreach($responses as $response)
                            <div class="response-card {{ $response->status === 'pending' ? 'unread' : '' }}" id="response-{{ $response->id }}">
                                <div class="seller-info">
                                    <img src="{{ $response->seller->profile_picture ? asset('storage/' . $response->seller->profile_picture) : asset('images/default-avatar.png') }}" 
                                         alt="{{ $response->seller->username }}" 
                                         class="seller-avatar">
                                    <div class="seller-details">
                                        <h3 class="seller-name">{{ $response->seller->firstname }} {{ $response->seller->lastname }}</h3>
                                        <div class="response-meta">
                                            <span><i class="bi bi-clock"></i> {{ $response->created_at->diffForHumans() }}</span>
                                            <span><i class="bi bi-telephone"></i> Contact via {{ ucfirst($response->contact_method) }}</span>
                                            
                                            @if($response->status === 'pending')
                                                <span class="response-badge badge-unread">New</span>
                                            @else
                                                <span class="response-badge badge-read">Read</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <span class="request-label">Responding to your request for:</span> 
                                    <span>{{ $response->buy->category }} ({{ $response->buy->quantity }} {{ $response->buy->unit }})</span>
                                </div>

                                <!-- Add contact details section -->
                                <div class="contact-details-section">
                                    @if($response->contact_method === 'email' && $response->contact_email)
                                        <div class="contact-info-item">
                                            <i class="bi bi-envelope"></i>
                                            <span>{{ $response->contact_email }}</span>
                                        </div>
                                    @elseif($response->contact_method === 'phone' && $response->contact_phone)
                                        <div class="contact-info-item">
                                            <i class="bi bi-telephone"></i>
                                            <span>{{ $response->contact_phone }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="response-message">
                                    {{ $response->message }}
                                </div>
                                
                                <div class="response-actions">
                                    @php
                                        $sellerShop = \App\Models\Shop::where('user_id', $response->seller_id)
                                            ->where('status', 'approved')
                                            ->first();
                                    @endphp
                                    
                                    @if($sellerShop)
                                        <a href="{{ route('shops.show', $response->seller->id) }}" class="response-button view-shop-btn">
                                            <i class="bi bi-shop"></i> View Seller's Shop
                                        </a>
                                    @else
                                        <div class="shop-info" style="margin-top: 10px; font-size: 14px; color: #666;">
                                            <p><i class="bi bi-shop"></i> Shop not registered</p>
                                        </div>
                                    @endif
                                    
                                    @if($response->status === 'pending')
                                        <button class="response-button mark-read-btn" onclick="markAsRead({{ $response->id }})">
                                            <i class="bi bi-check-circle"></i> Mark as Read
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-responses">
                        <i class="bi bi-envelope-open"></i>
                        <h3>No responses yet</h3>
                        <p>When sellers respond to your buy requests, they'll appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Buy Request Form Modal -->
    <div id="addRequestModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="bi bi-plus-circle"></i>
                    Create Buy Request
                </h2>
                <span class="close">&times;</span>
            </div>
            
            <div class="modal-body">
                <div class="form-container">
                    <div class="form-header">
                        <h2>Create a New Buy Request</h2>
                        <p>Let sellers know what recycling materials you're looking for</p>
                    </div>

                    <div class="form-content">
                        <form id="addRequestForm" action="{{ route('buy.store') }}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="category">
                                        <i class="bi bi-tag"></i>
                                        Material Category
                                    </label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">Select a material category</option>
                                        <option value="Metal">Metal</option>
                                        <option value="Plastic">Plastic</option>
                                        <option value="Paper">Paper</option>
                                        <option value="Glass">Glass</option>
                                        <option value="Wood">Wood</option>
                                        <option value="Electronics">Electronics</option>
                                        <option value="Fabric">Fabric</option>
                                        <option value="Rubber">Rubber</option>
                                    </select>
                                    <div class="help-text">Choose the type of material you're looking for</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="quantity">
                                        <i class="bi bi-123"></i>
                                        Quantity Needed
                                    </label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" 
                                           placeholder="Enter the amount you need..." required min="1">
                                    <div class="help-text">Specify how much material you need</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="unit">
                                        <i class="bi bi-rulers"></i>
                                        Measurement Unit
                                    </label>
                                    <select name="unit" id="unit" class="form-control" required>
                                        <option value="">Select a unit of measurement</option>
                                        <option value="kg">Kilogram (kg)</option>
                                        <option value="g">Gram (g)</option>
                                        <option value="lb">Pound (lb)</option>
                                        <option value="L">Liter (L)</option>
                                        <option value="m3">Cubic Meter (m3)</option>
                                        <option value="gal">Gallon (gal)</option>
                                        <option value="pc">Per Piece (pc)</option>
                                        <option value="dz">Per Dozen (dz)</option>
                                        <option value="bndl">Per Bundle (bndl)</option>
                                        <option value="sack">Per Sack (sack)</option>
                                        <option value="bale">Per Bale (bale)</option>
                                        <option value="roll">Per Roll (roll)</option>
                                        <option value="drum">Per Drum (drum)</option>
                                        <option value="box">Per Box (box)</option>
                                        <option value="pallet">Per Pallet (pallet)</option>
                                    </select>
                                    <div class="help-text">Choose the appropriate unit for your quantity</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="number">
                                        <i class="bi bi-telephone"></i>
                                        Contact Number
                                    </label>
                                    <input type="text" name="number" id="number" class="form-control" 
                                           value="{{ auth()->user()->number }}" required>
                                    <div class="help-text">Your contact number</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="location">
                                    <i class="bi bi-geo-alt"></i>
                                    Current Location
                                </label>
                                <div class="search-container">
                                    <div class="form-input-icon">
                                        <input type="text" id="location" name="location" placeholder="Search for a location..." class="form-control" required value="{{ auth()->user()->location }}">
                                        <i class="bi bi-search"></i>
                                    </div>
                                    <div class="loader" id="search-loader"></div>
                                    <div class="search-results" id="search-results"></div>
                                </div>
                            </div>

                            <div id="map-container" style="position: relative;">
                                <button class="geolocation-btn" id="geolocation-btn" title="Use my current location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </button>
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label" for="description">
                                    <i class="bi bi-card-text"></i>
                                    Request Description
                                </label>
                                <textarea name="description" id="description" class="form-control" 
                                          rows="4" placeholder="Describe what you're looking for in detail..." required></textarea>
                                <div class="help-text">Provide specific details about your requirements</div>
                            </div>
                        </form>
                    </div>

                    <div class="form-footer">
                        <button type="button" class="cancel-btn" onclick="closeAddModal()">
                            <i class="bi bi-x-circle"></i>
                            Cancel
                        </button>
                        <button type="submit" class="submit-btn" form="addRequestForm">
                            <i class="bi bi-check-circle"></i>
                            Create Request
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Buy Request Modal -->
    <div id="editRequestModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="bi bi-pencil-square"></i>
                    Edit Buy Request
                </h2>
                <span class="close">&times;</span>
            </div>
            
            <div class="modal-body">
                <div class="form-container">
                    <div class="form-header">
                        <h2>Update Your Buy Request</h2>
                        <p>Modify the details of your recycling material request</p>
                    </div>

                    <div class="form-content">
                        <form id="editRequestForm" action="" method="post">
                            @csrf
                            @method('PUT')

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="edit_category">
                                        <i class="bi bi-tag"></i>
                                        Material Category
                                    </label>
                                    <select name="category" id="edit_category" class="form-control" required>
                                        <option value="">Select a material category</option>
                                        <option value="Metal">Metal</option>
                                        <option value="Plastic">Plastic</option>
                                        <option value="Paper">Paper</option>
                                        <option value="Glass">Glass</option>
                                        <option value="Wood">Wood</option>
                                        <option value="Electronics">Electronics</option>
                                        <option value="Fabric">Fabric</option>
                                        <option value="Rubber">Rubber</option>
                                    </select>
                                    <div class="help-text">Choose the type of material you're looking for</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="edit_quantity">
                                        <i class="bi bi-123"></i>
                                        Quantity Needed
                                    </label>
                                    <input type="number" name="quantity" id="edit_quantity" class="form-control" 
                                           placeholder="Enter the amount you need..." required min="1">
                                    <div class="help-text">Specify how much material you need</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="edit_unit">
                                        <i class="bi bi-rulers"></i>
                                        Measurement Unit
                                    </label>
                                    <select name="unit" id="edit_unit" class="form-control" required>
                                        <option value="">Select a unit of measurement</option>
                                        <option value="kg">Kilogram (kg)</option>
                                        <option value="g">Gram (g)</option>
                                        <option value="lb">Pound (lb)</option>
                                        <option value="L">Liter (L)</option>
                                        <option value="m3">Cubic Meter (m3)</option>
                                        <option value="gal">Gallon (gal)</option>
                                        <option value="pc">Per Piece (pc)</option>
                                        <option value="dz">Per Dozen (dz)</option>
                                        <option value="bndl">Per Bundle (bndl)</option>
                                        <option value="sack">Per Sack (sack)</option>
                                        <option value="bale">Per Bale (bale)</option>
                                        <option value="roll">Per Roll (roll)</option>
                                        <option value="drum">Per Drum (drum)</option>
                                        <option value="box">Per Box (box)</option>
                                        <option value="pallet">Per Pallet (pallet)</option>
                                    </select>
                                    <div class="help-text">Choose the appropriate unit for your quantity</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="edit_number">
                                        <i class="bi bi-telephone"></i>
                                        Contact Number
                                    </label>
                                    <input type="text" name="number" id="edit_number" class="form-control" 
                                           value="{{ auth()->user()->number }}" required>
                                    <div class="help-text">Your contact number</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="edit_location">
                                    <i class="bi bi-geo-alt"></i>
                                    Current Location
                                </label>
                                <div class="search-container">
                                    <div class="form-input-icon">
                                        <input type="text" id="edit_location" name="location" placeholder="Search for a location..." class="form-control" required>
                                        <i class="bi bi-search"></i>
                                    </div>
                                    <div class="loader" id="edit-search-loader"></div>
                                    <div class="search-results" id="edit-search-results"></div>
                                </div>
                            </div>

                            <div id="edit-map-container" style="position: relative;">
                                <button class="geolocation-btn" id="edit-geolocation-btn" title="Use my current location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </button>
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label" for="edit_description">
                                    <i class="bi bi-card-text"></i>
                                    Request Description
                                </label>
                                <textarea name="description" id="edit_description" class="form-control" 
                                          rows="4" placeholder="Describe what you're looking for in detail..." required></textarea>
                                <div class="help-text">Provide specific details about your requirements</div>
                            </div>
                        </form>
                    </div>

                    <div class="form-footer">
                        <button type="button" class="cancel-btn" onclick="closeEditModal()">
                            <i class="bi bi-x-circle"></i>
                            Cancel
                        </button>
                        <button type="submit" class="submit-btn" form="editRequestForm">
                            <i class="bi bi-check-circle"></i>
                            Update Request
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Buy Request Form -->
    <form id="deleteRequestForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Request Overview Modal -->
    <div id="requestOverviewModal" class="modal overview-modal">
        <div class="modal-content">
            <div class="overview-header">
                <h2 class="overview-title">
                    <i class="bi bi-info-circle"></i>
                    Request Overview
                </h2>
                <span class="close">&times;</span>
            </div>
            
            <div class="overview-body">
                <div class="overview-section">
                    <h3 class="section-title">
                        <i class="bi bi-tag"></i>
                        Material Details
                    </h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Category</div>
                            <div class="info-value" id="overview-category"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Quantity</div>
                            <div class="info-value" id="overview-quantity"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Unit</div>
                            <div class="info-value" id="overview-unit"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Posted Date</div>
                            <div class="info-value" id="overview-date"></div>
                        </div>
                    </div>
                </div>

                <div class="overview-section">
                    <h3 class="section-title">
                        <i class="bi bi-geo-alt"></i>
                        Contact Information
                    </h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Location</div>
                            <div class="info-value" id="overview-location"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Contact Number</div>
                            <div class="info-value" id="overview-contact"></div>
                        </div>
                    </div>
                </div>

                <div class="overview-section">
                    <h3 class="section-title">
                        <i class="bi bi-card-text"></i>
                        Description
                    </h3>
                    <div class="description-box">
                        <p class="description-text" id="overview-description"></p>
                    </div>
                </div>
            </div>

            <div class="overview-footer">
                <button class="overview-btn close-overview-btn" onclick="closeOverviewModal()">
                    <i class="bi bi-x-circle"></i>
                    Close
                </button>
                <button class="overview-btn edit-overview-btn" id="overview-edit-btn">
                    <i class="bi bi-pencil"></i>
                    Edit Request
                </button>
            </div>
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
            cancelButtonText: 'No, stay',
            customClass: {
                popup: 'bigger-modal'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    // Buy Request Modal Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Get modal elements
        const addModal = document.getElementById('addRequestModal');
        const editModal = document.getElementById('editRequestModal');
        const addBtn = document.getElementById('addRequestBtn');
        const addCloseBtn = addModal.querySelector('.close');
        const editCloseBtn = editModal.querySelector('.close');

        // Check if we need to open the modal automatically
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('open_modal') && urlParams.get('open_modal') === 'true') {
            addModal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            
            // Remove the query parameter from the URL to prevent reopening on refresh
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        }

        // Open modal when Add Request button is clicked
        addBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openAddRequestModal(e);
        });

        // Close add modal when X is clicked
        addCloseBtn.addEventListener('click', function() {
            addModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Enable scrolling again
        });
        
        // Close edit modal when X is clicked
        editCloseBtn.addEventListener('click', function() {
            editModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Enable scrolling again
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === addModal) {
                addModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
            if (e.target === editModal) {
                editModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
        
        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                if (addModal.style.display === 'flex') {
                    addModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
                if (editModal.style.display === 'flex') {
                    editModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            }
        });

        // Add form submission handler
        const addRequestForm = document.getElementById('addRequestForm');
        if (addRequestForm) {
            addRequestForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const locationInput = document.getElementById('location');
                const numberInput = document.getElementById('number');
                
                // Validate required fields
                if (!locationInput.value) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please select a location using the map or search.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                    return;
                }

                if (!numberInput.value) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter your contact number.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                    return;
                }
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Validation failed');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        addModal.style.display = 'none';
                        document.body.style.overflow = 'auto';
                        
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#517A5B',
                            customClass: {
                                popup: 'bigger-modal'
                            }
                        });
                        
                        addRequestForm.reset();
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B',
                        customClass: {
                            popup: 'bigger-modal'
                        }
                    });
                });
            });
        }
        
        // Update the edit form submission handler
        const editRequestForm = document.getElementById('editRequestForm');
        if (editRequestForm) {
            editRequestForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const locationInput = document.getElementById('edit_location');
                const numberInput = document.getElementById('edit_number');
                
                // Validate required fields
                if (!locationInput.value) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please select a location using the map or search.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                    return;
                }

                if (!numberInput.value) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter your contact number.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                    return;
                }
                
                // Add CSRF token to formData
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                formData.append('_method', 'PUT');
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    // Check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            if (!response.ok) {
                                throw new Error(data.message || 'Validation failed');
                            }
                            return data;
                        });
                    } else {
                        // If not JSON, assume success and reload
                        if (response.ok) {
                            return { success: true, message: 'Buy request updated successfully!' };
                        } else {
                            throw new Error('Server error occurred');
                        }
                    }
                })
                .then(data => {
                    // Close the modal
                    document.getElementById('editRequestModal').style.display = 'none';
                    document.body.style.overflow = 'auto';
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'Buy request updated successfully!',
                        icon: 'success',
                        confirmButtonColor: '#517A5B',
                        customClass: {
                            popup: 'bigger-modal'
                        }
                    });
                    
                    // Reload the page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B',
                        customClass: {
                            popup: 'bigger-modal'
                        }
                    });
                });
            });
        }
    });
    
    // Function to open add request modal
    function openAddRequestModal(e) {
        e.preventDefault();
        const addModal = document.getElementById('addRequestModal');
        addModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        setTimeout(initMap, 100); // Initialize map when modal opens
    }
    
    // Function to open edit modal with current data
    function openEditModal(id, category, quantity, unit, description, location, number) {
        // Set form action URL
        document.getElementById('editRequestForm').action = `/buy/${id}`;
        
        // Fill form with current values
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_quantity').value = quantity;
        document.getElementById('edit_unit').value = unit;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_location').value = location;
        document.getElementById('edit_number').value = number;
        
        // Show the modal
        document.getElementById('editRequestModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        setTimeout(initEditMap, 100); // Initialize map when modal opens
    }
    
    // Function to confirm deletion
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fa5252',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                popup: 'bigger-modal'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Use AJAX to delete the request
                fetch(`/buy/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Deleted!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#517A5B',
                            customClass: {
                                popup: 'bigger-modal'
                            }
                        });
                        
                        // Reload the page after a short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        throw new Error(data.message || 'Something went wrong');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Failed to delete the buy request.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B',
                        customClass: {
                            popup: 'bigger-modal'
                        }
                    });
                });
            }
        });
    }
    
    // Function to mark response as read
    function markAsRead(responseId) {
        fetch(`/buy-responses/${responseId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                const responseCard = document.getElementById(`response-${responseId}`);
                responseCard.classList.remove('unread');
                
                // Remove the mark as read button
                const markReadBtn = responseCard.querySelector('.mark-read-btn');
                if (markReadBtn) {
                    markReadBtn.remove();
                }
                
                // Update the badge
                const badge = responseCard.querySelector('.response-badge');
                if (badge) {
                    badge.textContent = 'Read';
                    badge.classList.remove('badge-unread');
                    badge.classList.add('badge-read');
                }
                
                // Show success message
                Swal.fire({
                    title: 'Success!',
                    text: 'Response marked as read',
                    icon: 'success',
                    confirmButtonColor: '#517A5B',
                    timer: 1500,
                    customClass: {
                        popup: 'bigger-modal'
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update response status',
                icon: 'error',
                confirmButtonColor: '#517A5B',
                customClass: {
                    popup: 'bigger-modal'
                }
            });
        });
    }

    // Add this function to handle modal closing
    function closeEditModal() {
        const modal = document.getElementById('editRequestModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Add this function to handle add modal closing
    function closeAddModal() {
        const modal = document.getElementById('addRequestModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Add these new functions for the overview modal
    function showRequestOverview(id, category, quantity, unit, description, location, number, date) {
        // Set the values in the overview modal
        document.getElementById('overview-category').textContent = category;
        document.getElementById('overview-quantity').textContent = quantity;
        document.getElementById('overview-unit').textContent = unit;
        document.getElementById('overview-description').textContent = description;
        document.getElementById('overview-location').textContent = location;
        document.getElementById('overview-contact').textContent = number;
        document.getElementById('overview-date').textContent = date;

        // Set up the edit button to open the edit modal
        document.getElementById('overview-edit-btn').onclick = function() {
            closeOverviewModal();
            openEditModal(id, category, quantity, unit, description, location, number);
        };

        // Show the modal
        const overviewModal = document.getElementById('requestOverviewModal');
        overviewModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeOverviewModal() {
        const overviewModal = document.getElementById('requestOverviewModal');
        overviewModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Update the request card click handler
    document.addEventListener('DOMContentLoaded', function() {
        const requestCards = document.querySelectorAll('.request-card');
        requestCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on action buttons
                if (e.target.closest('.action-buttons')) {
                    return;
                }

                const id = this.getAttribute('data-id');
                const category = this.getAttribute('data-category');
                const quantity = this.getAttribute('data-quantity');
                const unit = this.getAttribute('data-unit');
                const description = this.getAttribute('data-description');
                const location = this.getAttribute('data-location');
                const number = this.getAttribute('data-number');
                const date = this.getAttribute('data-date');

                showRequestOverview(id, category, quantity, unit, description, location, number, date);
            });
        });

        // Add close button handler for overview modal
        const overviewCloseBtn = document.querySelector('#requestOverviewModal .close');
        if (overviewCloseBtn) {
            overviewCloseBtn.addEventListener('click', closeOverviewModal);
        }
    });

    // Map initialization and search functionality
    let map, editMap;
    let marker, editMarker;
    let geocoder, editGeocoder;

    // Add this custom icon definition at the start of your map initialization code
    const customIcon = L.divIcon({
        className: 'custom-marker',
        html: '<i class="bi bi-geo-alt-fill" style="color: white; font-size: 16px;"></i>',
        iconSize: [30, 30],
        iconAnchor: [15, 15],
        popupAnchor: [0, -15]
    });

    function reverseGeocode(lat, lng, callback) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                if (data.display_name) {
                    callback(data.display_name);
                }
            })
            .catch(error => {
                console.error('Error getting address:', error);
            });
    }

    function initMap() {
        // Initialize the map
        map = L.map('map-container').setView([14.5995, 120.9842], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const locationInput = document.getElementById('location');
        
        // Add geolocation button functionality
        const geolocationBtn = document.getElementById('geolocation-btn');
        geolocationBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                geolocationBtn.classList.add('loading');
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        map.setView([lat, lng], 15);
                        
                        if (marker) {
                            marker.setLatLng([lat, lng]);
                        } else {
                            marker = L.marker([lat, lng], {
                                icon: customIcon,
                                draggable: true
                            }).addTo(map);
                        }
                        
                        reverseGeocode(lat, lng, function(address) {
                            locationInput.value = address;
                        });
                        
                        geolocationBtn.classList.remove('loading');
                    },
                    function(error) {
                        console.error('Error getting location:', error);
                        geolocationBtn.classList.remove('loading');
                        Swal.fire({
                            title: 'Error!',
                            text: 'Unable to get your current location. Please try again or search manually.',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    }
                );
            }
        });

        // Initialize the geocoder
        geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: 'Search for a location...',
            errorMessage: 'Nothing found.'
        }).on('markgeocode', function(e) {
            const bbox = e.geocode.bbox;
            const poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]);
            map.fitBounds(poly.getBounds());
            
            if (marker) {
                marker.setLatLng(e.geocode.center);
            } else {
                marker = L.marker(e.geocode.center, {
                    icon: customIcon,
                    draggable: true
                }).addTo(map);
            }
            
            locationInput.value = e.geocode.name;
        }).addTo(map);

        // Add marker drag end event
        map.on('click', function(e) {
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng, {
                    icon: customIcon,
                    draggable: true
                }).addTo(map);
            }
            
            
            reverseGeocode(e.latlng.lat, e.latlng.lng, function(address) {
                locationInput.value = address;
            });
        });

        // Add marker drag end event
        if (marker) {
            marker.on('dragend', function(e) {
                const position = marker.getLatLng();
                reverseGeocode(position.lat, position.lng, function(address) {
                    locationInput.value = address;
                });
            });
        }

        // Initialize with user's current location if available
        const initialLocation = locationInput.value;
        if (initialLocation) {
            geocoder.geocode(initialLocation, function(results) {
                if (results.length > 0) {
                    const result = results[0];
                    marker = L.marker(result.center, {
                        icon: customIcon,
                        draggable: true
                    }).addTo(map);
                    map.setView(result.center, 13);
                }
            });
        }
    }

    function initEditMap() {
        // Initialize the edit map
        editMap = L.map('edit-map-container').setView([14.5995, 120.9842], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(editMap);

        const locationInput = document.getElementById('edit_location');
        
        // Add geolocation button functionality
        const editGeolocationBtn = document.getElementById('edit-geolocation-btn');
        editGeolocationBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                editGeolocationBtn.classList.add('loading');
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        editMap.setView([lat, lng], 15);
                        
                        if (editMarker) {
                            editMarker.setLatLng([lat, lng]);
                        } else {
                            editMarker = L.marker([lat, lng], {
                                icon: customIcon,
                                draggable: true
                            }).addTo(editMap);
                        }
                        
                        reverseGeocode(lat, lng, function(address) {
                            locationInput.value = address;
                        });
                        
                        editGeolocationBtn.classList.remove('loading');
                    },
                    function(error) {
                        console.error('Error getting location:', error);
                        editGeolocationBtn.classList.remove('loading');
                        Swal.fire({
                            title: 'Error!',
                            text: 'Unable to get your current location. Please try again or search manually.',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    }
                );
            }
        });

        // Initialize the geocoder
        editGeocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: 'Search for a location...',
            errorMessage: 'Nothing found.'
        }).on('markgeocode', function(e) {
            const bbox = e.geocode.bbox;
            const poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]);
            editMap.fitBounds(poly.getBounds());
            
            if (editMarker) {
                editMarker.setLatLng(e.geocode.center);
            } else {
                editMarker = L.marker(e.geocode.center, {
                    icon: customIcon,
                    draggable: true
                }).addTo(editMap);
            }
            
            locationInput.value = e.geocode.name;
        }).addTo(editMap);

        // Add marker drag end event
        editMap.on('click', function(e) {
            if (editMarker) {
                editMarker.setLatLng(e.latlng);
            } else {
                editMarker = L.marker(e.latlng, {
                    icon: customIcon,
                    draggable: true
                }).addTo(editMap);
            }
            
            reverseGeocode(e.latlng.lat, e.latlng.lng, function(address) {
                locationInput.value = address;
            });
        });

        // Add marker drag end event
        if (editMarker) {
            editMarker.on('dragend', function(e) {
                const position = editMarker.getLatLng();
                reverseGeocode(position.lat, position.lng, function(address) {
                    locationInput.value = address;
                });
            });
        }

        // Initialize with the current location if available
        const initialLocation = locationInput.value;
        if (initialLocation) {
            editGeocoder.geocode(initialLocation, function(results) {
                if (results.length > 0) {
                    const result = results[0];
                    editMarker = L.marker(result.center, {
                        icon: customIcon,
                        draggable: true
                    }).addTo(editMap);
                    editMap.setView(result.center, 13);
                }
            });
        }
    }

    // Add event listeners for location search
    document.addEventListener('DOMContentLoaded', function() {
        const locationSearch = document.getElementById('location-search');
        const editLocationSearch = document.getElementById('edit-location-search');
        
        if (locationSearch) {
            locationSearch.addEventListener('input', function(e) {
                const query = e.target.value;
                if (query.length > 2) {
                    geocoder.geocode(query, function(results) {
                        const resultsContainer = document.getElementById('search-results');
                        resultsContainer.innerHTML = '';
                        resultsContainer.style.display = 'block';
                        
                        results.forEach(result => {
                            const div = document.createElement('div');
                            div.className = 'search-result-item';
                            div.textContent = result.name;
                            div.addEventListener('click', function() {
                                locationSearch.value = result.name;
                                resultsContainer.style.display = 'none';
                                geocoder.markGeocode(result);
                            });
                            resultsContainer.appendChild(div);
                        });
                    });
                }
            });
        }
        
        if (editLocationSearch) {
            editLocationSearch.addEventListener('input', function(e) {
                const query = e.target.value;
                if (query.length > 2) {
                    editGeocoder.geocode(query, function(results) {
                        const resultsContainer = document.getElementById('edit-search-results');
                        resultsContainer.innerHTML = '';
                        resultsContainer.style.display = 'block';
                        
                        results.forEach(result => {
                            const div = document.createElement('div');
                            div.className = 'search-result-item';
                            div.textContent = result.name;
                            div.addEventListener('click', function() {
                                editLocationSearch.value = result.name;
                                resultsContainer.style.display = 'none';
                                editGeocoder.markGeocode(result);
                            });
                            resultsContainer.appendChild(div);
                        });
                    });
                }
            });
        }
    });

    // Function to handle description box expansion
    function handleDescriptionBox(descriptionBox) {
        const description = descriptionBox.querySelector('.description-text');
        const expandButton = descriptionBox.querySelector('.expand-button');
        
        // Get the line height
        const lineHeight = parseInt(window.getComputedStyle(description).lineHeight);
        // Get the actual height of the content
        const contentHeight = description.scrollHeight;
        
        // Show read more button only if content exceeds 2 lines
        if (contentHeight > lineHeight * 2) {
            expandButton.style.display = 'flex';
        } else {
            expandButton.style.display = 'none';
        }
    }

    // Initialize description boxes
    document.addEventListener('DOMContentLoaded', function() {
        const descriptionBoxes = document.querySelectorAll('.description-box');
        descriptionBoxes.forEach(handleDescriptionBox);
    });

    // Handle expand/collapse
    function toggleDescription(button) {
        const descriptionBox = button.closest('.description-box');
        const isExpanded = descriptionBox.classList.contains('expanded');
        
        if (isExpanded) {
            descriptionBox.classList.remove('expanded');
            button.innerHTML = '<span>Read More</span><i class="bi bi-chevron-down"></i>';
        } else {
            descriptionBox.classList.add('expanded');
            button.innerHTML = '<span>Show Less</span><i class="bi bi-chevron-up"></i>';
        }
    }
    </script>
</body>
</html>
