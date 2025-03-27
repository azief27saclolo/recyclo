<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shop->shop_name }} - Shop Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
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

        .shop-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .shop-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .shop-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background-color: #517A5B !important; /* Explicit color instead of variable */
            color: white !important;
            border-radius: 10px;
            text-align: center;
            height: 100px; /* Ensure minimum height */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin: -5px 0;
            min-height: 2.5rem; /* Ensure height even when empty */
            color: white !important; /* Ensure number is visible */
        }
        
        /* Enhanced Earnings Card */
        .earnings-card {
            background: linear-gradient(135deg, #517A5B 0%, #3a5c42 100%) !important;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(81, 122, 91, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .earnings-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(81, 122, 91, 0.4);
        }
        
        .earnings-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }
        
        .earnings-card::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: -40px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.05);
            z-index: 0;
        }
        
        .earnings-card i {
            margin-bottom: 5px;
            font-size: 24px;
            position: relative;
            z-index: 1;
        }
        
        .earnings-card .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin: -3px 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .earnings-card .stat-label {
            font-weight: 500;
            position: relative;
            z-index: 1;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .action-btn {
            background: var(--hoockers-green);
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: var(--hoockers-green_80);
            transform: translateY(-2px);
        }

        .recent-products {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-top: 30px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .product-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }

        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        /* Navbar styles */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--hoockers-green);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .navbar-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 20px;
        }

        .nav-item a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-item a:hover {
            color: var(--hoockers-green);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        @media (max-width: 768px) {
            .shop-stats {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                grid-template-columns: 1fr 1fr;
            }
            
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }

        /* Profile container and main content styles */
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
        }

        .modal-content {
            background-color: white;
            margin: 50px auto;
            padding: 20px; /* Reduced padding */
            width: 90%; /* Increased width from 80% */
            max-width: 900px; /* Increased from 800px */
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            padding-left: 5px; /* Added smaller padding */
            padding-right: 5px; /* Added smaller padding */
        }

        .modal-title {
            color: var(--hoockers-green);
            font-size: 32px; /* Increased from 24px */
            font-weight: 600;
            margin: 0;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 36px; /* Increased from 28px */
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 24px; /* Increased from 20px */
            padding: 0 5px; /* Reduced horizontal padding */
            width: 100%; /* Ensure full width */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .form-label {
            display: block;
            margin-bottom: 10px; /* Increased from 8px */
            font-weight: 600;
            color: #333;
            font-size: 18px; /* Increased from ~16px */
        }

        .form-control {
            width: 100%; /* Full width */
            padding: 12px; /* Increased from 10px */
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 18px; /* Increased from 16px */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .form-control:focus {
            border-color: var(--hoockers-green);
            outline: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 16px; /* Increased from 14px */
            margin-top: 5px;
        }

        .submit-btn {
            background: var(--hoockers-green);
            color: white;
            border: none;
            padding: 16px 25px; /* Increased height */
            border-radius: 8px;
            cursor: pointer;
            font-size: 20px; /* Increased from 16px */
            width: calc(100% - 10px); /* Adjusted width with padding consideration */
            margin: 0 5px; /* Centered with small margin */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .submit-btn:hover {
            background: var(--hoockers-green_80);
        }
        
        /* Modal body content text size */
        .modal-body p {
            font-size: 18px; /* Added larger text size for paragraphs */
            line-height: 28px; /* Added for better readability */
            margin-bottom: 10px;
        }
        
        /* Modal dialog text */
        #orderDetailsContent p {
            font-size: 18px; /* Larger text for order details */
        }
        
        #orderDetailsContent h4 {
            font-size: 22px; /* Larger heading in order details */
        }

        /* Specific styles for add/edit product forms */
        #addProductModal form, #editProductModal form {
            width: 100%;
        }

        #addProductModal .form-group, #editProductModal .form-group {
            width: 100%;
        }

        /* Ensure textareas expand fully */
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Loading spinner animation */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .pagination-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .pagination-btn {
            background-color: var(--hoockers-green);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            cursor: pointer;
        }
        
        .pagination-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
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

        /* Enhanced Inventory UI Styles */
        .dashboard-card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .dashboard-card-icon {
            margin-right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .total-sku .dashboard-card-icon {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .total-items .dashboard-card-icon {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .inventory-value .dashboard-card-icon {
            background-color: #fff8e1;
            color: #ffa000;
        }

        .inventory-status .dashboard-card-icon {
            background-color: #ffebee;
            color: #d32f2f;
        }

        .dashboard-card-content h3 {
            margin: 0;
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }

        .dashboard-card-content p {
            margin: 5px 0 0;
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .status-indicator {
            display: flex;
            gap: 8px;
            margin-top: 5px;
        }

        .badge {
            display: inline-flex;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            align-items: center;
        }

        .badge::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-warning::before {
            background-color: #ffc107;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-danger::before {
            background-color: #dc3545;
        }

        .loading-animation {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(81, 122, 91, 0.1);
            border-radius: 50%;
            border-left-color: var(--hoockers-green);
            animation: spin 1s linear infinite;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        /* Beautify table rows and hover effect */
        .inventory-table tbody tr {
            transition: background-color 0.15s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .inventory-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .inventory-table tbody tr:last-child {
            border-bottom: none;
        }

        /* Stock indicator styles */
        .stock-indicator {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 12px;
            text-align: center;
            min-width: 80px;
        }

        .in-stock {
            background-color: #d4edda;
            color: #155724;
        }

        .low-stock {
            background-color: #fff3cd;
            color: #856404;
        }

        .out-of-stock {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Action button styling */
        .inventory-action-btn {
            background-color: var(--hoockers-green);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 13px;
            cursor: pointer;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .inventory-action-btn:hover {
            background-color: var(--hoockers-green_80);
        }

        .inventory-action-btn i {
            font-size: 14px;
        }

        .inventory-action-btn.edit-btn {
            background-color: #4c72b0;
        }

        .inventory-action-btn.edit-btn:hover {
            background-color: #3a5a8c;
        }

        .inventory-action-btn.delete-btn {
            background-color: #dc3545;
        }

        .inventory-action-btn.delete-btn:hover {
            background-color: #bd2130;
        }

        /* Checkbox styling */
        .inventory-table input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* Fix position sticky for header */
        .inventory-table-container {
            position: relative;
        }

        .inventory-table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        /* Better pagination buttons */
        .pagination-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .pagination-btn:hover:not(:disabled) {
            background-color: var(--hoockers-green_80);
            transform: translateY(-2px);
        }

        .pagination-btn:disabled {
            opacity: 0.6;
        }

        /* Action buttons hover effect */
        .inventory-actions .action-btn {
            transition: all 0.2s;
        }

        .inventory-actions .action-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .inventory-actions .action-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        /* Better modal styling */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .modal-header {
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .modal-title {
            font-weight: 700;
        }

        /* Enhanced Form Styling */
        .form-container {
            padding: 0 10px;
        }
        
        .form-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }
        
        .form-section:last-child {
            border-bottom: none;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--hoockers-green);
            margin-bottom: 18px;
            padding-bottom: 8px;
            position: relative;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 40px;
            background-color: var(--hoockers-green);
            border-radius: 3px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .form-label i {
            color: var(--hoockers-green);
        }
        
        .enhanced {
            transition: all 0.2s ease-in-out;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 16px;
            width: 100%;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        
        .enhanced:focus {
            border-color: var(--hoockers-green);
            box-shadow: 0 0 0 3px rgba(81, 122, 91, 0.25);
            outline: none;
        }
        
        .form-control.enhanced::placeholder {
            color: #9ca3af;
        }
        
        .form-helper {
            margin-top: 6px;
            font-size: 12px;
            color: #6b7280;
        }
        
        .full-width {
            grid-column: 1 / -1;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        /* Quantity Input with Buttons */
        .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .quantity-btn {
            position: absolute;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            user-select: none;
            transition: all 0.2s;
        }
        
        .quantity-btn:hover {
            background: #e5e7eb;
        }
        
        .quantity-btn:active {
            transform: scale(0.95);
        }
        
        .quantity-btn[data-action="decrease"] {
            right: 40px;
            border-radius: 4px 0 0 4px;
        }
        
        .quantity-btn[data-action="increase"] {
            right: 0;
            border-radius: 0 4px 4px 0;
        }
        
        .input-with-icon input {
            padding-right: 70px;
        }
        
        /* Price Input with Prefix */
        .input-with-prefix {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-prefix {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-weight: 500;
        }
        
        .has-prefix {
            padding-left: 30px;
        }
        
        /* Enhanced Image Upload */
        .image-upload-container {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        
        .image-upload-wrapper {
            flex: 1;
            max-width: 300px;
        }
        
        .image-upload-input {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
        
        .image-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 30px 20px;
            cursor: pointer;
            transition: all 0.2s;
            background-color: #f9fafb;
            height: 150px;
        }
        
        .image-upload-label:hover {
            border-color: var(--hoockers-green);
            background-color: rgba(81, 122, 91, 0.05);
        }
        
        .image-upload-label i {
            font-size: 32px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        
        .image-upload-label span {
            font-weight: 500;
            color: #374151;
        }
        
        .image-upload-label small {
            margin-top: 5px;
            color: #6b7280;
        }
        
        .image-preview {
            flex: 1;
            max-width: 250px;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
            background-color: #f3f4f6;
            position: relative;
        }
        
        .placeholder-text {
            color: #6b7280;
            font-size: 14px;
        }
        
        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        /* Current Image Display */
        .current-image-container {
            margin-bottom: 15px;
        }
        
        .image-label {
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 8px;
        }
        
        .current-product-image {
            width: 150px;
            height: 150px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9fafb;
        }
        
        .current-product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        .no-image {
            color: #6b7280;
            font-size: 14px;
            text-align: center;
            padding: 10px;
        }
        
        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding: 20px 10px;
            margin-top: 20px;
            border-top: 1px solid #eaeaea;
        }
        
        .btn {
            padding: 12px 20px;
            font-size: 15px;
            font-weight: 500;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }
        
        .btn:active {
            transform: translateY(1px);
        }
        
        .btn i {
            font-size: 18px;
        }
        
        .btn-primary {
            background-color: var(--hoockers-green);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--hoockers-green_80);
            box-shadow: 0 4px 12px rgba(81, 122, 91, 0.2);
        }
        
        .btn-secondary {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #d1d5db;
        }
        
        .btn-secondary:hover {
            background-color: #e5e7eb;
        }
        
        .btn-danger {
            background-color: #fee2e2;
            color: #b91c1c;
            margin-left: auto;
        }
        
        .btn-danger:hover {
            background-color: #fecaca;
            box-shadow: 0 4px 12px rgba(185, 28, 28, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .image-upload-container {
                flex-direction: column;
            }
            
            .image-upload-wrapper, 
            .image-preview {
                max-width: 100%;
            }
            
            .form-actions {
                flex-wrap: wrap;
            }
            
            .btn-danger {
                margin-left: 0;
                order: -1;
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Use the sidebar component instead of hardcoded sidebar -->
        <x-sidebar activePage="shop" />

        <!-- Main Content -->
        <div class="main-content">
            <div class="shop-container">
                <div class="shop-header">
                    <h1>{{ $shop->shop_name }}</h1>
                    <p>{{ $shop->shop_address }}</p>
                    
                    <div class="shop-stats">
                        <div class="stat-card" id="productsStatCard" style="background-color: #517A5B; color: white; cursor: pointer;">
                            <i class="bi bi-box-seam"></i>
                            <div class="stat-number" style="color: white;">
                                @php
                                    try {
                                        // Use direct DB query for reliable count
                                        $productsCount = \App\Models\Post::where('user_id', Auth::id())->count();
                                        echo $productsCount;
                                    } catch (\Exception $e) {
                                        echo '0';
                                    }
                                @endphp
                            </div>
                            <div style="color: white;">Products (SKUs)</div>
                        </div>
                        
                        <!-- New Inventory Stat Card -->
                        <div class="stat-card" id="inventoryStatCard" style="background-color: #517A5B; color: white; cursor: pointer;">
                            <i class="bi bi-stack"></i>
                            <div class="stat-number" style="color: white;">
                                @php
                                    try {
                                        // Calculate total inventory by summing up quantities
                                        $totalInventory = \App\Models\Post::where('user_id', Auth::id())->sum('quantity');
                                        echo number_format($totalInventory);
                                    } catch (\Exception $e) {
                                        echo '0';
                                    }
                                @endphp
                            </div>
                            <div style="color: white;">Total Items</div>
                        </div>

                        <!-- New Total Inventory Value Card -->
                        <div class="stat-card" id="inventoryValueCard" style="background-color: #517A5B; color: white; cursor: pointer;">
                            <i class="bi bi-cash-stack"></i>
                            <div class="stat-number" style="color: white;">
                                @php
                                    try {
                                        // Calculate total inventory value (price * quantity for each product)
                                        $inventoryValue = \App\Models\Post::where('user_id', Auth::id())
                                            ->selectRaw('SUM(price * quantity) as total_value')
                                            ->first();
                                        echo '₱' . number_format($inventoryValue->total_value ?? 0, 2);
                                    } catch (\Exception $e) {
                                        echo '₱0.00';
                                    }
                                @endphp
                            </div>
                            <div style="color: white;">Total Value</div>
                        </div>
                        
                        <div class="stat-card" id="ordersStatCard" style="background-color: #517A5B; color: white; cursor: pointer;">
                            <i class="bi bi-cart-check"></i>
                            <div class="stat-number" style="color: white;">
                                @php
                                    try {
                                        // Use direct DB query for reliable count
                                        $ordersCount = \App\Models\Order::where('seller_id', Auth::id())->count();
                                        echo $ordersCount;
                                    } catch (\Exception $e) {
                                        echo '0';
                                    }
                                @endphp
                            </div>
                            <div style="color: white;">Orders</div>
                        </div>
                        <div class="stat-card earnings-card" style="color: white;">
                            <i class="bi bi-coin"></i>
                            <div class="stat-number" style="color: white;">
                                @php
                                    try {
                                        // Only count earnings from completed orders
                                        // Apply 10% commission fee deduction (multiply by 0.9)
                                        $totalEarnings = \App\Models\Order::where('seller_id', Auth::id())
                                                    ->where('status', 'completed')
                                                    ->sum('total_amount');
                                        $netEarnings = $totalEarnings * 0.9; // Deduct 10% commission fee
                                        echo '₱' . number_format($netEarnings ?? 0, 2);
                                    } catch (\Exception $e) {
                                        echo '₱0.00';
                                    }
                                @endphp
                            </div>
                            <div class="stat-label" style="color: white;">Net Earnings</div>
                        </div>
                    </div>
                </div>

                <div class="quick-actions">
                    <a href="#" class="action-btn" id="addProductBtn">
                        <i class="bi bi-plus-circle"></i> Add Product
                    </a>
                    <button id="manageOrdersBtn" class="action-btn" style="border: none; display: block; width: 100%; text-align: center; cursor: pointer;">
                        <i class="bi bi-list-check"></i> Manage Orders
                    </button>
                    <button id="shopSettingsBtn" class="action-btn" style="border: none; display: block; width: 100%; text-align: center; cursor: pointer;">
                        <i class="bi bi-gear"></i> Shop Settings
                    </button>
                    <button id="allProductsBtn" class="action-btn" style="border: none; display: block; width: 100%; text-align: center; cursor: pointer;">
                        <i class="bi bi-grid"></i> All Products
                    </button>
                </div>

                <div class="recent-products">
                    <h2>Recent Products</h2>
                    <div class="product-grid">
                        @php
                            try {
                                $recentProducts = \App\Models\Post::where('user_id', Auth::id())
                                    ->latest()
                                    ->take(4) // Changed from 5 to 4
                                    ->get();
                            } catch (\Exception $e) {
                                $recentProducts = collect([]);
                            }
                        @endphp
                        
                        @if(count($recentProducts) > 0)
                            @foreach($recentProducts as $product)
                                <div class="product-card">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
                                    @else
                                        <img src="{{ asset('images/placeholder.png') }}" alt="No image">
                                    @endif
                                    <h3>{{ $product->title }}</h3>
                                    <p>₱{{ number_format($product->price, 2) }}</p>
                                    <p>Stock: {{ $product->quantity ?? 'N/A' }}</p>
                                    
                                    <!-- Updated action buttons with larger size -->
                                    <div class="product-actions" style="margin-top: 15px; display: flex; justify-content: space-between;">
                                        <button class="action-btn edit-product-btn" 
                                                style="flex: 1; margin-right: 5px; font-size: 16px; padding: 12px 10px; height: 48px;"
                                                data-product-id="{{ $product->id }}"
                                                data-product-title="{{ $product->title }}"
                                                data-product-category="{{ $product->category }}"
                                                data-product-location="{{ $product->location }}"
                                                data-product-unit="{{ $product->unit }}"
                                                data-product-quantity="{{ $product->quantity }}"
                                                data-product-price="{{ $product->price }}"
                                                data-product-description="{{ $product->description }}">
                                            <i class="bi bi-pencil" style="font-size: 18px;"></i> Edit
                                        </button>
                                        <button class="action-btn delete-product-btn" 
                                                style="flex: 1; margin-left: 5px; font-size: 16px; padding: 12px 10px; height: 48px; background-color: #dc3545;"
                                                data-product-id="{{ $product->id }}"
                                                data-product-title="{{ $product->title }}">
                                            <i class="bi bi-trash" style="font-size: 18px;"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="bi bi-box"></i>
                                <h3>No products yet</h3>
                                <p>Start selling by adding your first product</p>
                                <a href="{{ route('posts.create') }}" class="action-btn" style="display: inline-block; margin-top: 15px;">
                                    <i class="bi bi-plus-circle"></i> Add Product
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add New Product</h2>
                <span class="close">&times;</span>
            </div>
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-container">
                    <div class="form-grid">
                        <!-- Left Column -->
                        <div class="form-column">
                            <div class="form-group">
                                <label class="form-label" for="title">
                                    <i class="bi bi-tag"></i> Product Title
                                </label>
                                <input type="text" name="title" id="title" class="form-control enhanced" 
                                    placeholder="Enter product title..." required>
                                <div class="form-helper">Give your product a descriptive title</div>
                                @error('title')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="category">
                                    <i class="bi bi-collection"></i> Category
                                </label>
                                <select name="category" id="category" class="form-control enhanced" required>
                                    <option value="">--Select Category--</option>
                                    <option value="Metal">Metal</option>
                                    <option value="Plastic">Plastic</option>
                                    <option value="Paper">Paper</option>
                                    <option value="Glass">Glass</option>
                                    <option value="Wood">Wood</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Fabric">Fabric</option>
                                    <option value="Rubber">Rubber</option>
                                </select>
                                @error('category')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="location">
                                    <i class="bi bi-geo-alt"></i> Location
                                </label>
                                <select name="location" id="location" class="form-control enhanced" required>
                                    <option value="">--Select Location--</option>
                                    <option value="user-location">{{ Auth::user()->location }}</option>
                                    <option value="custom">Set up another location</option>
                                </select>
                                @error('location')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="custom-location-wrapper" class="form-group" style="display: none;">
                                <label class="form-label" for="custom-location-input">
                                    <i class="bi bi-geo-alt"></i> Custom Location
                                </label>
                                <input type="text" name="custom_location" id="custom-location-input" class="form-control enhanced" 
                                    placeholder="Enter custom location...">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="form-column">
                            <div class="form-group">
                                <label class="form-label" for="unit">
                                    <i class="bi bi-box2"></i> Unit
                                </label>
                                <select name="unit" id="unit" class="form-control enhanced" required>
                                    <option value="">--Select Unit--</option>
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
                                @error('unit')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="quantity">
                                    <i class="bi bi-123"></i> Quantity
                                </label>
                                <div class="input-with-icon">
                                    <input type="number" name="quantity" id="quantity" class="form-control enhanced" 
                                        placeholder="Enter quantity..." min="0" required>
                                    <button type="button" class="quantity-btn" data-action="decrease">-</button>
                                    <button type="button" class="quantity-btn" data-action="increase">+</button>
                                </div>
                                @error('quantity')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="price">
                                    <i class="bi bi-currency-dollar"></i> Price per unit
                                </label>
                                <div class="input-with-prefix">
                                    <span class="input-prefix">₱</span>
                                    <input type="number" name="price" id="price" class="form-control enhanced has-prefix" 
                                        placeholder="0.00" step="0.01" min="0" required>
                                </div>
                                @error('price')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label" for="description">
                            <i class="bi bi-file-text"></i> Description
                        </label>
                        <textarea name="description" id="description" class="form-control enhanced" 
                            rows="4" placeholder="Enter product description..."></textarea>
                        <div class="form-helper">Provide detailed information about your product</div>
                        @error('description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label" for="image">
                            <i class="bi bi-image"></i> Product Image
                        </label>
                        <div class="image-upload-container">
                            <div class="image-upload-wrapper">
                                <input type="file" name="image" id="image" class="image-upload-input" 
                                    accept="image/*" onchange="previewImage(this, 'imagePreview')">
                                <label for="image" class="image-upload-label">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <span>Choose a file</span>
                                    <small>or drag and drop</small>
                                </label>
                            </div>
                            <div id="imagePreview" class="image-preview">
                                <span class="placeholder-text">No image selected</span>
                            </div>
                        </div>
                        <div class="form-helper">Maximum file size: 2MB. Formats: JPG, PNG, GIF</div>
                        @error('image')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="document.querySelector('#addProductModal .close').click()">
                        <i class="bi bi-x"></i> Cancel
                    </button>
                    <button type="submit" name="add_product" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Product Form Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Product</h2>
                <span class="close">&times;</span>
            </div>
            
            <form id="editProductForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-container">
                    <div class="form-grid">
                        <!-- Left Column -->
                        <div class="form-column">
                            <div class="form-group">
                                <label class="form-label" for="edit-title">
                                    <i class="bi bi-tag"></i> Product Title
                                </label>
                                <input type="text" name="title" id="edit-title" class="form-control enhanced" 
                                    placeholder="Enter product title..." required>
                                <div class="form-helper">Give your product a descriptive title</div>
                                @error('title')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="edit-category">
                                    <i class="bi bi-collection"></i> Category
                                </label>
                                <select name="category" id="edit-category" class="form-control enhanced" required>
                                    <option value="">--Select Category--</option>
                                    <option value="Metal">Metal</option>
                                    <option value="Plastic">Plastic</option>
                                    <option value="Paper">Paper</option>
                                    <option value="Glass">Glass</option>
                                    <option value="Wood">Wood</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Fabric">Fabric</option>
                                    <option value="Rubber">Rubber</option>
                                </select>
                                @error('category')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="edit-location">
                                    <i class="bi bi-geo-alt"></i> Location
                                </label>
                                <select name="location" id="edit-location" class="form-control enhanced" required>
                                    <option value="">--Select Location--</option>
                                    <option value="user-location">{{ Auth::user()->location }}</option>
                                    <option value="custom">Set up another location</option>
                                </select>
                                @error('location')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="edit-custom-location-wrapper" class="form-group" style="display: none;">
                                <label class="form-label" for="edit-custom-location-input">
                                    <i class="bi bi-geo-alt"></i> Custom Location
                                </label>
                                <input type="text" name="custom_location" id="edit-custom-location-input" class="form-control enhanced" 
                                    placeholder="Enter custom location...">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="form-column">
                            <div class="form-group">
                                <label class="form-label" for="edit-unit">
                                    <i class="bi bi-box2"></i> Unit
                                </label>
                                <select name="unit" id="edit-unit" class="form-control enhanced" required>
                                    <option value="">--Select Unit--</option>
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
                                @error('unit')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="edit-quantity">
                                    <i class="bi bi-123"></i> Quantity
                                </label>
                                <div class="input-with-icon">
                                    <input type="number" name="quantity" id="edit-quantity" class="form-control enhanced" 
                                        placeholder="Enter quantity..." min="0" required>
                                    <button type="button" class="quantity-btn" data-action="decrease">-</button>
                                    <button type="button" class="quantity-btn" data-action="increase">+</button>
                                </div>
                                @error('quantity')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="edit-price">
                                    <i class="bi bi-currency-dollar"></i> Price per unit
                                </label>
                                <div class="input-with-prefix">
                                    <span class="input-prefix">₱</span>
                                    <input type="number" name="price" id="edit-price" class="form-control enhanced has-prefix" 
                                        placeholder="0.00" step="0.01" min="0" required>
                                </div>
                                @error('price')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label" for="edit-description">
                            <i class="bi bi-file-text"></i> Description
                        </label>
                        <textarea name="description" id="edit-description" class="form-control enhanced" 
                            rows="4" placeholder="Enter product description..."></textarea>
                        <div class="form-helper">Provide detailed information about your product</div>
                        @error('description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label" for="edit-image">
                            <i class="bi bi-image"></i> Product Image
                        </label>
                        
                        <div id="current-image-container" class="current-image-container">
                            <p class="image-label">Current Image:</p>
                            <div id="current-product-image" class="current-product-image">
                                <!-- Current image will be displayed here via JavaScript -->
                                <div class="no-image">No image available</div>
                            </div>
                        </div>
                        
                        <div class="image-upload-container">
                            <div class="image-upload-wrapper">
                                <input type="file" name="image" id="edit-image" class="image-upload-input" 
                                    accept="image/*" onchange="previewImage(this, 'editImagePreview')">
                                <label for="edit-image" class="image-upload-label">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <span>Change image</span>
                                    <small>Leave empty to keep current image</small>
                                </label>
                            </div>
                            <div id="editImagePreview" class="image-preview">
                                <span class="placeholder-text">No new image selected</span>
                            </div>
                        </div>
                        
                        <div class="form-helper">Maximum file size: 2MB. Formats: JPG, PNG, GIF</div>
                        @error('image')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="document.querySelector('#editProductModal .close').click()">
                        <i class="bi bi-x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2"></i> Update Product
                    </button>
                    <button type="button" class="btn btn-danger" id="editFormDeleteBtn">
                        <i class="bi bi-trash"></i> Delete Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Modal -->
    <div id="ordersModal" class="modal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h2 class="modal-title">Orders</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 15px; display: flex; align-items: center;">
                    <label for="order-status-filter" style="margin-right: 3px; font-weight: 600;">Filter by Status:</label>
                    <select id="order-status-filter" class="form-control" style="display: inline-block; width: auto; padding: 8px;">
                        <option value="all">All Orders</option>
                        <option value="processing">Processing</option>
                        <option value="delivering">Delivering</option>
                        <option value="for_pickup">For Pick Up</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    
                    <div class="search-box" style="margin-left: auto;">
                        <input type="text" id="order-search" class="form-control" placeholder="Search orders..." style="padding: 8px;">
                    </div>
                </div>
                
                <div style="max-height: 500px; overflow-y: auto;">
                    <table class="orders-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white;">
                                <th style="padding: 12px; text-align: left;">Order ID</th>
                                <th style="padding: 12px; text-align: left;">Customer</th>
                                <th style="padding: 12px; text-align: left;">Date</th>
                                <th style="padding: 12px; text-align: left;">Items</th>
                                <th style="padding: 12px; text-align: right;">Total</th>
                                <th style="padding: 12px; text-align: center;">Status</th>
                                <th style="padding: 12px; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="orders-table-body">
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 20px;">Loading orders...</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="pagination-container" style="margin-top: 20px; text-align: center; display: flex; justify-content: center; gap: 10px;">
                        <button id="prev-page-btn" class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;" disabled>Previous</button>
                        <span id="pagination-info" style="align-self: center; padding: 0 10px;">Page 1</span>
                        <button id="next-page-btn" class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Order Details</h2>
                <span class="close">&times;</span>
            </div>
            <div id="orderDetailsContent" class="modal-body">
                <!-- Order details will be injected here -->
            </div>
        </div>
    </div>

    <!-- All Products Modal -->
    <div id="allProductsModal" class="modal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h2 class="modal-title">All Products</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                    <!-- Add category filter dropdown -->
                    <div class="category-filter">
                        <select id="category-filter" class="form-control" style="padding: 8px; min-width: 150px;">
                            <option value="all">All Categories</option>
                            <option value="Metal">Metal</option>
                            <option value="Plastic">Plastic</option>
                            <option value="Paper">Paper</option>
                            <option value="Glass">Glass</option>
                            <option value="Wood">Wood</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Fabric">Fabric</option>
                            <option value="Rubber">Rubber</option>
                        </select>
                    </div>
                    
                    <div class="search-box" style="margin-left: auto;">
                        <input type="text" id="product-search" class="form-control" placeholder="Search products..." style="padding: 8px;">
                    </div>
                </div>
                
                <div id="all-products-container" style="max-height: 500px; overflow-y: auto;">
                    <div class="product-grid" id="allProductsGrid">
                        <div class="loading-spinner" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                            <i class="bi bi-arrow-repeat" style="font-size: 48px; animation: spin 1s linear infinite;"></i>
                            <p>Loading products...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add new Inventory Management Modal -->
    <div id="inventoryModal" class="modal">
        <div class="modal-content" style="max-width: 950px;">
            <div class="modal-header">
                <h2 class="modal-title">Inventory Management</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Inventory Dashboard Cards -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px;">
                    <div class="dashboard-card total-sku">
                        <div class="dashboard-card-icon">
                            <i class="bi bi-boxes"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <h3>Total SKUs</h3>
                            <p id="dashboard-total-skus">-</p>
                        </div>
                    </div>
                    <div class="dashboard-card total-items">
                        <div class="dashboard-card-icon">
                            <i class="bi bi-stack"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <h3>Total Items</h3>
                            <p id="dashboard-total-items">-</p>
                        </div>
                    </div>
                    <div class="dashboard-card inventory-value">
                        <div class="dashboard-card-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <h3>Total Value</h3>
                            <p id="dashboard-inventory-value">-</p>
                        </div>
                    </div>
                    <div class="dashboard-card inventory-status">
                        <div class="dashboard-card-icon">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <h3>Status</h3>
                            <div class="status-indicator">
                                <span id="low-stock-count" class="badge badge-warning">0</span>
                                <span id="out-stock-count" class="badge badge-danger">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filter-toolbar" style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                    <!-- Add category filter dropdown -->
                    <div class="filter-group">
                        <label for="inventory-category-filter" style="display: block; font-weight: 600; margin-bottom: 5px;">Category</label>
                        <select id="inventory-category-filter" class="form-control" style="padding: 8px; min-width: 150px;">
                            <option value="all">All Categories</option>
                            <option value="Metal">Metal</option>
                            <option value="Plastic">Plastic</option>
                            <option value="Paper">Paper</option>
                            <option value="Glass">Glass</option>
                            <option value="Wood">Wood</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Fabric">Fabric</option>
                            <option value="Rubber">Rubber</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="inventory-stock-filter" style="display: block; font-weight: 600; margin-bottom: 5px;">Stock Level</label>
                        <select id="inventory-stock-filter" class="form-control" style="padding: 8px; min-width: 150px;">
                            <option value="all">All Levels</option>
                            <option value="in-stock">In Stock</option>
                            <option value="low-stock">Low Stock (<10)</option>
                            <option value="out-of-stock">Out of Stock</option>
                        </select>
                    </div>
                    
                    <div class="search-box" style="margin-left: auto;">
                        <label for="inventory-search" style="display: block; font-weight: 600; margin-bottom: 5px;">Search</label>
                        <div style="position: relative;">
                            <input type="text" id="inventory-search" class="form-control" placeholder="Search products..." style="padding: 8px; padding-left: 35px;">
                            <i class="bi bi-search" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: #666;"></i>
                        </div>
                    </div>
                </div>
                
                <div class="inventory-table-container" style="max-height: 450px; overflow-y: auto; margin-bottom: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <table class="inventory-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white; position: sticky; top: 0; z-index: 10;">
                                <th style="padding: 12px; text-align: left; white-space: nowrap;">
                                    <input type="checkbox" id="select-all-checkbox" style="margin-right: 8px;"> ID
                                </th>
                                <th style="padding: 12px; text-align: center; white-space: nowrap;">Image</th>
                                <th style="padding: 12px; text-align: left; white-space: nowrap;">Product Name</th>
                                <th style="padding: 12px; text-align: center; white-space: nowrap;">Category</th>
                                <th style="padding: 12px; text-align: right; white-space: nowrap;">Price (₱)</th>
                                <th style="padding: 12px; text-align: center; white-space: nowrap;">Stock</th>
                                <th style="padding: 12px; text-align: right; white-space: nowrap;">Total Value</th>
                                <th style="padding: 12px; text-align: center; white-space: nowrap;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="inventory-table-body">
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 20px;">
                                    <div class="loading-animation">
                                        <div class="spinner"></div>
                                        <p>Loading inventory...</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="inventory-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                    <div class="inventory-summary">
                        <p style="margin: 0; font-size: 16px;"><span id="selected-count">0</span> of <span id="total-count">0</span> items selected</p>
                    </div>
                    
                    <div class="pagination-container" style="display: flex; justify-content: center; gap: 10px; align-items: center;">
                        <button id="inventory-prev-page-btn" class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;" disabled>
                            <i class="bi bi-chevron-left"></i> Previous
                        </button>
                        <span id="inventory-pagination-info" style="align-self: center; padding: 0 10px; font-weight: 600;">Page 1 of 1</span>
                        <button id="inventory-next-page-btn" class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;">
                            Next <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Inventory Action Buttons -->
                <div class="inventory-actions" style="margin-top: 20px; display: flex; gap: 15px; justify-content: space-between; border-top: 1px solid #eee; padding-top: 20px;">
                    <button id="batch-update-btn" class="action-btn" style="flex: 1; padding: 12px 10px; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600;" disabled>
                        <i class="bi bi-layers" style="font-size: 18px;"></i> Batch Update
                    </button>
                    <button id="view-history-btn" class="action-btn" style="flex: 1; padding: 12px 10px; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600;">
                        <i class="bi bi-clock-history" style="font-size: 18px;"></i> View History
                    </button>
                    <button id="export-inventory-btn" class="action-btn" style="flex: 1; padding: 12px 10px; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600;">
                        <i class="bi bi-download" style="font-size: 18px;"></i> Export Inventory
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Stock Modal -->
    <div id="updateStockModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Update Stock</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form id="updateStockForm">
                    <input type="hidden" id="update-product-id" name="product_id">
                    
                    <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <p id="update-product-name" style="font-size: 1.2rem; margin-bottom: 10px; padding: 8px; background-color: #f8f9fa; border-radius: 4px;"></p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Current Stock</label>
                        <p id="update-current-stock" style="font-size: 1.2rem; margin-bottom: 10px; padding: 8px; background-color: #f8f9fa; border-radius: 4px;"></p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="stock-action">Action</label>
                        <select name="stock_action" id="stock-action" class="form-control" required>
                            <option value="add">Add Stock</option>
                            <option value="remove">Remove Stock</option>
                            <option value="set">Set Exact Amount</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="stock-quantity">Quantity</label>
                        <input type="number" name="quantity" id="stock-quantity" class="form-control" min="1" value="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="stock-notes">Notes (Optional)</label>
                        <textarea name="notes" id="stock-notes" class="form-control" rows="3" placeholder="Enter notes about this stock update..."></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Update Stock</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Inventory History Modal -->
    <div id="inventoryHistoryModal" class="modal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h2 class="modal-title">Inventory History</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                    <div>
                        <label for="history-product-filter" style="margin-right: 3px; font-weight: 600;">Product:</label>
                        <select id="history-product-filter" class="form-control" style="display: inline-block; width: auto; padding: 8px;">
                            <option value="all">All Products</option>
                            <!-- Product options will be populated dynamically -->
                        </select>
                    </div>
                    
                    <div>
                        <label for="history-action-filter" style="margin-right: 3px; font-weight: 600;">Action:</label>
                        <select id="history-action-filter" class="form-control" style="display: inline-block; width: auto; padding: 8px;">
                            <option value="all">All Actions</option>
                            <option value="update">Update</option>
                            <option value="add">Add</option>
                            <option value="remove">Remove</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="history-field-filter" style="margin-right: 3px; font-weight: 600;">Field:</label>
                        <select id="history-field-filter" class="form-control" style="display: inline-block; width: auto; padding: 8px;">
                            <option value="all">All Fields</option>
                            <option value="quantity">Quantity</option>
                            <option value="price">Price</option>
                            <option value="category">Category</option>
                        </select>
                    </div>
                </div>
                
                <div style="max-height: 500px; overflow-y: auto;">
                    <table class="history-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--hoockers-green); color: white;">
                                <th style="padding: 12px; text-align: left;">Date</th>
                                <th style="padding: 12px; text-align: left;">Product</th>
                                <th style="padding: 12px; text-align: left;">Action</th>
                                <th style="padding: 12px; text-align: left;">Field</th>
                                <th style="padding: 12px; text-align: left;">Old Value</th>
                                <th style="padding: 12px; text-align: left;">New Value</th>
                                <th style="padding: 12px; text-align: left;">Notes</th>
                            </tr>
                        </thead>
                        <tbody id="history-table-body">
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 20px;">Loading history...</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="pagination-container" style="margin-top: 20px; text-align: center; display: flex; justify-content: center; gap: 10px;">
                        <button id="history-prev-page-btn" class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;" disabled>Previous</button>
                        <span id="history-pagination-info" style="align-self: center; padding: 0 10px;">Page 1</span>
                        <button id="history-next-page-btn" class="pagination-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer;">Next</button>
                    </div>
                </div>
                
                <!-- Export History Button -->
                <div style="margin-top: 20px; text-align: right;">
                    <button id="export-history-btn" class="action-btn" style="padding: 12px 20px;">
                        <i class="bi bi-download"></i> Export History
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Batch Update Modal -->
    <div id="batchUpdateModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Batch Update Products</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form id="batchUpdateForm">
                    <div class="form-group">
                        <label class="form-label">Selected Products</label>
                        <div id="selected-products-list" style="max-height: 150px; overflow-y: auto; border: 1px solid #ddd; border-radius: 8px; padding: 10px; margin-bottom: 10px;">
                            <p style="text-align: center; color: #666;">No products selected</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="batch-action">Update Action</label>
                        <select name="batch_action" id="batch-action" class="form-control" required>
                            <option value="">--Select--</option>
                            <option value="stock">Update Stock</option>
                            <option value="price">Update Price</option>
                            <option value="category">Update Category</option>
                        </select>
                    </div>
                    
                    <div id="batch-value-container" class="form-group" style="display: none;">
                        <!-- Dynamic content based on selected action -->
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="batch-notes">Notes (Optional)</label>
                        <textarea name="notes" id="batch-notes" class="form-control" rows="3" placeholder="Enter notes about this batch update..."></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Update Products</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Export Inventory Modal -->
    <div id="exportInventoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Export Inventory</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form id="exportInventoryForm">
                    <div class="form-group">
                        <label class="form-label" for="export-type">Export Type</label>
                        <select name="export_type" id="export-type" class="form-control" required>
                            <option value="current">Current Inventory</option>
                            <option value="history">Inventory History</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="export-format">Format</label>
                        <select name="export_format" id="export-format" class="form-control" required>
                            <option value="csv">CSV</option>
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="submit-btn">Export</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Shop Settings Modal -->
    <div id="shopSettingsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Shop Settings</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form id="shopSettingsForm" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label class="form-label" for="shop-name">Shop Name</label>
                        <input type="text" name="shop_name" id="shop-name" class="form-control" placeholder="Enter shop name..." value="{{ $shop->shop_name }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="shop-address">Shop Location</label>
                        <input type="text" name="shop_address" id="shop-address" class="form-control" placeholder="Enter shop location..." value="{{ $shop->shop_address }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="shop-image">Shop Banner Image (Optional)</label>
                        <input type="file" name="shop_image" id="shop-image" class="form-control" accept="image/*">
                        <small style="display: block; margin-top: 5px; color: #666;">Leave empty to keep current image</small>
                    </div>

                    @if($shop->image)
                    <div class="form-group">
                        <label class="form-label">Current Banner</label>
                        <div style="width: 100%; max-height: 150px; overflow: hidden; border-radius: 8px;">
                            <img src="{{ asset('storage/' . $shop->image) }}" alt="Shop Banner" style="width: 100%; object-fit: cover;">
                        </div>
                    </div>
                    @endif

                    <div class="form-group" style="margin-bottom: 0;">
                        <button type="submit" class="submit-btn">Update Shop Settings</button>
                    </div>
                </form>
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

    // Product Modal Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Check for success message in session and show popup
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'bigger-modal'
                }
            });
        @endif
        
        @if(session('delete'))
            Swal.fire({
                title: 'Deleted!',
                text: "{{ session('delete') }}",
                icon: 'warning',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'bigger-modal'
                }
            });
        @endif

        // Get modal elements
        const modal = document.getElementById('addProductModal');
        const btn = document.getElementById('addProductBtn');
        const closeBtn = modal.querySelector('.close');

        // Open modal when Add Product button is clicked
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'block';
        });

        // Close modal when X is clicked
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Close modal when clicking outside the modal
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Get modal elements for edit modal
        const editModal = document.getElementById('editProductModal');
        const editCloseBtn = editModal.querySelector('.close');
        const editProductForm = document.getElementById('editProductForm');
        
        // Edit Product Button Click
        document.querySelectorAll('.edit-product-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productTitle = this.getAttribute('data-product-title');
                const productCategory = this.getAttribute('data-product-category');
                const productLocation = this.getAttribute('data-product-location');
                const productUnit = this.getAttribute('data-product-unit');
                const productQuantity = this.getAttribute('data-product-quantity');
                const productPrice = this.getAttribute('data-product-price');
                const productDescription = this.getAttribute('data-product-description');
                
                // Set form action - Fix the route name from posts.index to posts
                editProductForm.action = `{{ route('posts') }}/${productId}`;
                
                // Populate form fields
                document.getElementById('edit-title').value = productTitle;
                document.getElementById('edit-category').value = productCategory;
                document.getElementById('edit-location').value = productLocation;
                document.getElementById('edit-unit').value = productUnit;
                document.getElementById('edit-quantity').value = productQuantity;
                document.getElementById('edit-price').value = productPrice;
                document.getElementById('edit-description').value = productDescription;
                
                // Reset the file input field to ensure it's empty
                document.getElementById('edit-image').value = '';
                
                // Show the modal
                editModal.style.display = 'block';
            });
        });
        
        // Close edit modal when X is clicked
        editCloseBtn.addEventListener('click', function() {
            editModal.style.display = 'none';
        });
        
        // Close edit modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === editModal) {
                editModal.style.display = 'none';
            }
        });
        
        // Delete Product Button Click
        document.querySelectorAll('.delete-product-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productTitle = this.getAttribute('data-product-title');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you really want to delete "${productTitle}"? This cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it',
                    customClass: {
                        popup: 'bigger-modal'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create form and submit for DELETE request
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('posts') }}/${productId}`; // Fix the route name
                        form.style.display = 'none';
                        
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        
                        form.submit();
                    }
                });
            });
        });

        // Orders Modal Functionality
        const ordersModal = document.getElementById('ordersModal');
        const ordersStatCard = document.getElementById('ordersStatCard');
        const manageOrdersBtn = document.getElementById('manageOrdersBtn');
        const ordersCloseBtn = ordersModal.querySelector('.close');
        
        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 5;
        let totalPages = 1;
        let statusFilter = 'all';
        let searchQuery = '';
        
        // Open orders modal when Orders stat card is clicked
        ordersStatCard.addEventListener('click', function() {
            ordersModal.style.display = 'block';
            loadOrders(1);
        });

        // Open orders modal when Manage Orders button is clicked
        manageOrdersBtn.addEventListener('click', function() {
            ordersModal.style.display = 'block';
            loadOrders(1);
        });

        // Close orders modal when X is clicked
        ordersCloseBtn.addEventListener('click', function() {
            ordersModal.style.display = 'none';
        });

        // Close orders modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === ordersModal) {
                ordersModal.style.display = 'none';
            }
        });

        // Filter functionality for orders
        const statusFilterSelect = document.getElementById('order-status-filter');
        const searchInput = document.getElementById('order-search');
        
        // Pagination buttons
        const prevPageBtn = document.getElementById('prev-page-btn');
        const nextPageBtn = document.getElementById('next-page-btn');
        const paginationInfo = document.getElementById('pagination-info');

        statusFilterSelect.addEventListener('change', function() {
            statusFilter = this.value;
            currentPage = 1; // Reset to first page when filter changes
            loadOrders(currentPage);
        });
        
        searchInput.addEventListener('input', function() {
            searchQuery = this.value;
            currentPage = 1; // Reset to first page when search changes
            loadOrders(currentPage);
        });
        
        // Handle pagination button clicks
        prevPageBtn.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                loadOrders(currentPage);
            }
        });
        
        nextPageBtn.addEventListener('click', function() {
            if (currentPage < totalPages) {
                currentPage++;
                loadOrders(currentPage);
            }
        });
        
        // Function to load orders with pagination
        function loadOrders(page) {
            const ordersTableBody = document.getElementById('orders-table-body');
            
            // Show loading state
            ordersTableBody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">
                        <i class="bi bi-arrow-repeat" style="font-size: 24px; animation: spin 1s linear infinite; display: inline-block; margin-right: 10px;"></i>
                        Loading orders...
                    </td>
                </tr>
            `;
            
            // Fetch orders from server
            fetch(`/shop/orders?page=${page}&status=${statusFilter}&search=${searchQuery}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok (Status: ${response.status})`);
                }
                return response.json();
            })
            .then(data => {
                // Update pagination state
                currentPage = data.current_page;
                totalPages = data.last_page;
                
                // Update pagination UI
                prevPageBtn.disabled = currentPage <= 1;
                nextPageBtn.disabled = currentPage >= totalPages;
                paginationInfo.textContent = `Page ${currentPage} of ${totalPages}`;
                
                // Clear table
                ordersTableBody.innerHTML = '';
                
                if (data.data.length === 0) {
                    ordersTableBody.innerHTML = `
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px;">No orders found</td>
                        </tr>
                    `;
                    return;
                }
                
                // Append orders to table
                data.data.forEach(order => {
                    const statusColor = {
                        'pending': '#ffc107',
                        'processing': '#17a2b8',
                        'delivering': '#007bff',
                        'for_pickup': '#28a745',
                        'cancelled': '#dc3545',
                        'completed': '#198754'
                    };
                    
                    const status = order.status || 'pending';
                    const color = statusColor[status] || '#ffc107';
                    const textColor = status === 'pending' ? '#212529' : 'white';
                    
                    ordersTableBody.innerHTML += `
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;">#ORD-${order.id}</td>
                            <td style="padding: 12px;">${order.customer_name || 'Customer'}</td>
                            <td style="padding: 12px;">${new Date(order.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                            <td style="padding: 12px;">${order.product_title || 'Product'} (${order.quantity} ${order.unit || 'units'})</td>
                            <td style="padding: 12px; text-align: right;">₱${parseFloat(order.total_amount).toFixed(2)}</td>
                            <td style="padding: 12px; text-align: center;">
                                <span class="status-badge" style="background-color: ${color}; color: ${textColor}; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;">
                                    ${status.charAt(0).toUpperCase() + status.slice(1)}
                                </span>
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                <button class="view-order-btn" style="background-color: var(--hoockers-green); color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;" 
                                    data-order-id="${order.id}"
                                    data-customer-name="${order.customer_name || 'Customer'}">
                                    View
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                // Add event listeners to view order buttons
                addViewOrderEventListeners();
            })
            .catch(error => {
                console.error('Error loading orders:', error);
                ordersTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #dc3545;">
                            Error loading orders. Please try again.
                        </td>
                    </tr>
                `;
            });
        }
        
        // Function to add event listeners to view order buttons
        function addViewOrderEventListeners() {
            document.querySelectorAll('.view-order-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    const customerName = this.getAttribute('data-customer-name');
                    
                    // Fetch order details
                    fetch(`/shop/orders/${orderId}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(order => {
                        // Create order details HTML
                        const orderDetailsHTML = `
                            <div style="text-align: left;">
                                <p><strong>Order ID:</strong> #ORD-${order.id}</p>
                                <p><strong>Customer:</strong> ${order.customer_name || 'Customer'}</p>
                                <p><strong>Date:</strong> ${new Date(order.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</p>
                                <p><strong>Items:</strong> ${order.product_title || 'Product'} (${order.quantity} ${order.unit || 'units'})</p>
                                <p><strong>Total Amount:</strong> ₱${parseFloat(order.total_amount).toFixed(2)}</p>
                                <p><strong>Status:</strong> ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</p>
                                <hr>
                                <p><strong>Shipping Address:</strong> ${order.address || 'Not available'}</p>
                                <p><strong>Contact Number:</strong> ${order.contact || 'Not available'}</p>
                                <p><strong>Payment Method:</strong> Cash on Delivery</p>
                                
                                <div style="margin-top: 20px;">
                                    <h4 style="font-weight: 600; margin-bottom: 10px;">Update Order Status</h4>
                                    <select id="update-status" class="form-control" style="width: 100%; padding: 8px; margin-bottom: 10px;">
                                        <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>Processing</option>
                                        <option value="delivering" ${order.status === 'delivering' ? 'selected' : ''}>Delivering</option>
                                        <option value="for_pickup" ${order.status === 'for_pickup' ? 'selected' : ''}>For Pick Up</option>
                                        <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>Completed</option>
                                        <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                    </select>
                                    <button id="update-status-btn" data-order-id="${order.id}" class="submit-btn" style="width: 100%;">Update Status</button>
                                </div>
                            </div>
                        `;
                        
                        // Inject HTML into the modal
                        document.getElementById('orderDetailsContent').innerHTML = orderDetailsHTML;
                        
                        // Show the modal
                        document.getElementById('orderDetailsModal').style.display = 'block';
                        
                        // Update Status button click
                        document.getElementById('update-status-btn').addEventListener('click', function() {
                            const newStatus = document.getElementById('update-status').value;
                            const orderId = this.getAttribute('data-order-id');
                            
                            updateOrderStatus(orderId, newStatus);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching order details:', error);
                        Swal.fire({
                            title: 'Error', 
                            text: 'Failed to load order details. Please try again.', 
                            icon: 'error',
                            customClass: {
                                popup: 'bigger-modal'
                            }
                        });
                    });
                });
            });
        }
        
        // Function to update order status
        function updateOrderStatus(orderId, newStatus) {
            Swal.fire({
                title: 'Update Order Status',
                text: `Are you sure you want to change the status to ${newStatus}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#517A5B',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update it',
                customClass: {
                    popup: 'bigger-modal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to update the order status
                    fetch(`/orders/${orderId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // If the order status is set to completed, update the earnings display
                            if (newStatus === 'completed' && data.orderAmount) {
                                updateEarningsCard(data.orderAmount);
                            }
                            
                            Swal.fire({
                                title: 'Updated!',
                                text: 'Order status has been updated.',
                                icon: 'success',
                                customClass: {
                                    popup: 'bigger-modal'
                                }
                            }).then(() => {
                                // Close the modal after status update
                                document.getElementById('orderDetailsModal').style.display = 'none';
                                // Reload orders to reflect changes
                                loadOrders(currentPage);
                            });
                        } else {
                            Swal.fire({
                                title: 'Error', 
                                text: data.message || 'Failed to update order status', 
                                icon: 'error',
                                customClass: {
                                    popup: 'bigger-modal'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error updating status:', error);
                        Swal.fire({
                            title: 'Error', 
                            text: 'Something went wrong. Please try again.', 
                            icon: 'error',
                            customClass: {
                                popup: 'bigger-modal'
                                }
                            });
                        });
                    }
                });
            }
            
            // Function to update the earnings card in real-time when an order is completed
            function updateEarningsCard(orderAmount) {
                // Get the earnings stat card number element
                const earningsElement = document.querySelector('.earnings-card .stat-number');
                if (!earningsElement) return;
                
                // Get the current earnings value (remove currency symbol and commas)
                let currentValue = earningsElement.textContent.trim();
                currentValue = parseFloat(currentValue.replace('₱', '').replace(/,/g, '')) || 0;
                
                // Calculate new earnings with 10% fee deducted
                const newOrderAmount = parseFloat(orderAmount) * 0.9; // Apply 10% commission fee
                const newTotalEarnings = currentValue + newOrderAmount;
                
                // Update the display with formatted number
                earningsElement.textContent = '₱' + newTotalEarnings.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                
                // Add animation effect to highlight the change
                earningsElement.style.transition = 'transform 0.3s ease, color 0.3s ease';
                earningsElement.style.transform = 'scale(1.1)';
                earningsElement.style.color = '#FFEB3B';
                
                setTimeout(() => {
                    earningsElement.style.transform = 'scale(1)';
                    earningsElement.style.color = 'white';
                }, 500);
                
                console.log(`Earnings updated: Added ₱${newOrderAmount.toFixed(2)} (after 10% fee from ₱${orderAmount})`);
            }

        // View order button handlers
        // ...rest of the existing code...

        // All Products Modal Functionality
        const allProductsModal = document.getElementById('allProductsModal');
        const allProductsBtn = document.getElementById('allProductsBtn');
        const allProductsCloseBtn = allProductsModal.querySelector('.close');
        const productsStatCard = document.getElementById('productsStatCard');
        
        // Open all products modal when All Products button is clicked
        allProductsBtn.addEventListener('click', function() {
            allProductsModal.style.display = 'block';
            loadAllProducts();
        });
        
        // Open all products modal when Products stat card is clicked
        productsStatCard.addEventListener('click', function() {
            allProductsModal.style.display = 'block';
            loadAllProducts();
        });
        
        // Close all products modal when X is clicked
        allProductsCloseBtn.addEventListener('click', function() {
            allProductsModal.style.display = 'none';
        });
        
        // Close all products modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === allProductsModal) {
                allProductsModal.style.display = 'none';
            }
        });
        
        // Load all products
        function loadAllProducts() {
            const productsContainer = document.getElementById('allProductsGrid');
            
            // Show loading spinner
            productsContainer.innerHTML = `
                <div class="loading-spinner" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <i class="bi bi-arrow-repeat" style="font-size: 48px; animation: spin 1s linear infinite;"></i>
                    <p>Loading products...</p>
                </div>
            `;
            
            // Fix: Use the correct route URL with error handling
            fetch('{{ route("user.products") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok (Status: ${response.status})`);
                }
                return response.json();
            })
            .then(data => {
                // Clear loading spinner
                productsContainer.innerHTML = '';
                
                if (data.products.length === 0) {
                    productsContainer.innerHTML = `
                        <div class="empty-state" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                            <i class="bi bi-box"></i>
                            <h3>No products yet</h3>
                            <p>Start selling by adding your first product</p>
                            <button id="emptyStateAddBtn" class="action-btn" style="display: inline-block; margin-top: 15px;">
                                <i class="bi bi-plus-circle"></i> Add Product
                            </button>
                        </div>
                    `;
                    
                    document.getElementById('emptyStateAddBtn').addEventListener('click', function() {
                        allProductsModal.style.display = 'none';
                        document.getElementById('addProductBtn').click();
                    });
                    
                    return;
                }
                
                // Create product cards
                data.products.forEach(product => {
                    const productCard = document.createElement('div');
                    productCard.className = 'product-card';
                    productCard.setAttribute('data-category', product.category);
                    
                    const imagePath = product.image ? "{{ asset('storage') }}/" + product.image : "{{ asset('images/placeholder.png') }}";
                    
                    productCard.innerHTML = `
                        <img src="${imagePath}" alt="${product.title}">
                        <h3>${product.title}</h3>
                        <p>₱${parseFloat(product.price).toFixed(2)}</p>
                        <p><span class="badge" style="background-color: var(--hoockers-green); color: white; padding: 3px 8px; border-radius: 12px; font-size: 12px;">${product.category}</span></p>
                        <p>Stock: ${product.quantity ?? 'N/A'}</p>
                        
                        <div class="product-actions" style="margin-top: 15px; display: flex; justify-content: space-between;">
                            <button class="action-btn edit-product-btn" 
                                    style="flex: 1; margin-right: 5px; font-size: 16px; padding: 12px 10px; height: 48px;"
                                    data-product-id="${product.id}"
                                    data-product-title="${product.title}"
                                    data-product-category="${product.category}"
                                    data-product-location="${product.location}"
                                    data-product-unit="${product.unit}"
                                    data-product-quantity="${product.quantity}"
                                    data-product-price="${product.price}"
                                    data-product-description="${product.description || ''}">
                                <i class="bi bi-pencil" style="font-size: 18px;"></i> Edit
                            </button>
                            <button class="action-btn delete-product-btn" 
                                    style="flex: 1; margin-left: 5px; font-size: 16px; padding: 12px 10px; height: 48px; background-color: #dc3545;"
                                    data-product-id="${product.id}"
                                    data-product-title="${product.title}">
                                <i class="bi bi-trash" style="font-size: 18px;"></i> Delete
                            </button>
                        </div>
                    `;
                    
                    productsContainer.appendChild(productCard);
                });
                
                // Add event listeners to the new buttons
                addButtonEventListeners();
            })
            .catch(error => {
                console.error('Error loading products:', error);
                productsContainer.innerHTML = `
                    <div class="error-state" style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #dc3545;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 48px;"></i>
                        <h3>Error loading products</h3>
                        <p>Something went wrong. Please try again later.</p>
                        <p>Details: ${error.message}</p>
                    </div>
                `;
            });
        }
        
        // Add event listeners to edit and delete buttons
        function addButtonEventListeners() {
            // Add event listeners to edit buttons
            document.querySelectorAll('#allProductsGrid .edit-product-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productTitle = this.getAttribute('data-product-title');
                    const productCategory = this.getAttribute('data-product-category');
                    const productLocation = this.getAttribute('data-product-location');
                    const productUnit = this.getAttribute('data-product-unit');
                    const productQuantity = this.getAttribute('data-product-quantity');
                    const productPrice = this.getAttribute('data-product-price');
                    const productDescription = this.getAttribute('data-product-description');
                    
                    // Close all products modal
                    allProductsModal.style.display = 'none';
                    
                    // Set form action
                    editProductForm.action = `{{ route('posts') }}/${productId}`;
                    
                    // Populate form fields
                    document.getElementById('edit-title').value = productTitle;
                    document.getElementById('edit-category').value = productCategory;
                    document.getElementById('edit-location').value = productLocation;
                    document.getElementById('edit-unit').value = productUnit;
                    document.getElementById('edit-quantity').value = productQuantity;
                    document.getElementById('edit-price').value = productPrice;
                    document.getElementById('edit-description').value = productDescription;
                    
                    // Show the edit modal
                    document.getElementById('editProductModal').style.display = 'block';
                });
            });
            
            // Add event listeners to delete buttons
            document.querySelectorAll('#allProductsGrid .delete-product-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productTitle = this.getAttribute('data-product-title');
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: `Do you really want to delete "${productTitle}"? This cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, keep it',
                        customClass: {
                            popup: 'bigger-modal'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create form and submit for DELETE request
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `{{ route('posts') }}/${productId}`;
                            form.style.display = 'none';
                            
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            
                            const methodField = document.createElement('input');
                            methodField.type = 'hidden';
                            methodField.name = '_method';
                            methodField.value = 'DELETE';
                            
                            form.appendChild(csrfToken);
                            form.appendChild(methodField);
                            document.body.appendChild(form);
                            
                            form.submit();
                        }
                    });
                });
            });
        }
        
        // Filter products with search input and category dropdown
        const productSearchInput = document.getElementById('product-search');
        const categoryFilter = document.getElementById('category-filter');
        
        function filterProducts() {
            const searchTerm = productSearchInput.value.toLowerCase();
            const categoryValue = categoryFilter.value;
            const productCards = document.querySelectorAll('#allProductsGrid .product-card');
            
            productCards.forEach(card => {
                const productTitle = card.querySelector('h3').textContent.toLowerCase();
                const productCategory = card.getAttribute('data-category') || '';
                
                const matchesSearch = productTitle.includes(searchTerm);
                const matchesCategory = categoryValue === 'all' || productCategory === categoryValue;
                
                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        productSearchInput.addEventListener('input', filterProducts);
        categoryFilter.addEventListener('change', filterProducts);
        
        // Shop Settings Modal Functionality
        const shopSettingsModal = document.getElementById('shopSettingsModal');
        const shopSettingsBtn = document.getElementById('shopSettingsBtn');
        const shopSettingsCloseBtn = shopSettingsModal.querySelector('.close');
        const shopSettingsForm = document.getElementById('shopSettingsForm');
        
        // Open shop settings modal when Shop Settings button is clicked
        shopSettingsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            shopSettingsModal.style.display = 'block';
        });
        
        // Close shop settings modal when X is clicked
        shopSettingsCloseBtn.addEventListener('click', function() {
            shopSettingsModal.style.display = 'none';
        });
        
        // Close shop settings modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === shopSettingsModal) {
                shopSettingsModal.style.display = 'none';
            }
        });
        
        // Handle shop settings form submission
        shopSettingsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Create form data object from the form
            const formData = new FormData(shopSettingsForm);
            
            // Send AJAX request
            fetch('{{ route("shop.update") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok (Status: ${response.status})`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Close the modal
                    shopSettingsModal.style.display = 'none';
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || 'Shop settings updated successfully!',
                        icon: 'success',
                        confirmButtonColor: '#517A5B',
                        customClass: {
                            popup: 'bigger-modal'
                        }
                    }).then(() => {
                        // Reload the page to reflect changes
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Failed to update shop settings');
                }
            })
            .catch(error => {
                console.error('Error updating shop settings:', error);
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
        
        // ...existing code...

        // Add click handler for inventory stat card
        const inventoryStatCard = document.getElementById('inventoryStatCard');
        if (inventoryStatCard) {
            inventoryStatCard.addEventListener('click', function() {
                // Open the all products modal when clicking on the inventory stat
                allProductsModal.style.display = 'block';
                loadAllProducts();
            });
        }
    });

    // Add click handler for inventory stat card
    const inventoryStatCard = document.getElementById('inventoryStatCard');
    if (inventoryStatCard) {
        inventoryStatCard.addEventListener('click', function() {
            // Open the inventory modal when clicking on the inventory stat
            document.getElementById('inventoryModal').style.display = 'block';
            loadInventory(1);
        });
    }

    // Inventory Modal Functionality
    const inventoryModal = document.getElementById('inventoryModal');
    const inventoryCloseBtn = inventoryModal.querySelector('.close');

    // Close inventory modal when X is clicked
    inventoryCloseBtn.addEventListener('click', function() {
        inventoryModal.style.display = 'none';
    });

    // Close inventory modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === inventoryModal) {
            inventoryModal.style.display = 'none';
        }
    });

    // Filter inventory with search input and category dropdown
    const inventorySearchInput = document.getElementById('inventory-search');
    const inventoryCategoryFilter = document.getElementById('inventory-category-filter');

    // Inventory pagination variables
    let inventoryCurrentPage = 1;
    let inventoryTotalPages = 1;
    let selectedProducts = [];

    // Function to load inventory with pagination
    function loadInventory(page) {
        const inventoryTableBody = document.getElementById('inventory-table-body');
        
        // Show loading state
        inventoryTableBody.innerHTML = `
            <tr>
                <td colspan="8" style="text-align: center; padding: 30px;">
                    <div class="loading-animation">
                        <div class="spinner"></div>
                        <p>Loading inventory data...</p>
                    </div>
                </td>
            </tr>
        `;
        
        // Get category filter and search query
        const categoryFilter = document.getElementById('inventory-category-filter').value;
        const searchTerm = document.getElementById('inventory-search').value;
        const stockFilter = document.getElementById('inventory-stock-filter').value;
        
        // Fetch inventory from API
        fetch('{{ route("user.products") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok (Status: ${response.status})`);
            }
            return response.json();
        })
        .then(data => {
            // Clear table
            inventoryTableBody.innerHTML = '';
            
            // Filter products by category, search term, and stock level
            let filteredProducts = data.products;
            
            if (categoryFilter && categoryFilter !== 'all') {
                filteredProducts = filteredProducts.filter(product => product.category === categoryFilter);
            }
            
            if (searchTerm) {
                const searchLower = searchTerm.toLowerCase();
                filteredProducts = filteredProducts.filter(product => 
                    product.title.toLowerCase().includes(searchLower) || 
                    product.id.toString().includes(searchLower)
                );
            }
            
            if (stockFilter && stockFilter !== 'all') {
                switch (stockFilter) {
                    case 'in-stock':
                        filteredProducts = filteredProducts.filter(product => parseInt(product.quantity) > 0);
                        break;
                    case 'low-stock':
                        filteredProducts = filteredProducts.filter(product => parseInt(product.quantity) > 0 && parseInt(product.quantity) < 10);
                        break;
                    case 'out-of-stock':
                        filteredProducts = filteredProducts.filter(product => parseInt(product.quantity) <= 0);
                        break;
                }
            }
            
            // Update total counts for dashboard
            const totalSKUs = filteredProducts.length;
            let totalItems = 0;
            let totalValue = 0;
            let lowStockCount = 0;
            let outOfStockCount = 0;
            
            filteredProducts.forEach(product => {
                const quantity = parseInt(product.quantity);
                const price = parseFloat(product.price);
                totalItems += quantity;
                totalValue += quantity * price;
                
                if (quantity <= 0) {
                    outOfStockCount++;
                } else if (quantity < 10) {
                    lowStockCount++;
                }
            });
            
            // Update dashboard cards
            document.getElementById('dashboard-total-skus').textContent = totalSKUs;
            document.getElementById('dashboard-total-items').textContent = totalItems.toLocaleString();
            document.getElementById('dashboard-inventory-value').textContent = '₱' + totalValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('low-stock-count').textContent = lowStockCount + ' Low Stock';
            document.getElementById('out-stock-count').textContent = outOfStockCount + ' Out of Stock';
            
            // Calculate pagination
            const itemsPerPage = 10;
            const totalProducts = filteredProducts.length;
            inventoryTotalPages = Math.ceil(totalProducts / itemsPerPage);
            
            // Update pagination UI
            document.getElementById('inventory-prev-page-btn').disabled = inventoryCurrentPage <= 1;
            document.getElementById('inventory-next-page-btn').disabled = inventoryCurrentPage >= inventoryTotalPages;
            document.getElementById('inventory-pagination-info').textContent = `Page ${inventoryCurrentPage} of ${inventoryTotalPages > 0 ? inventoryTotalPages : 1}`;
            document.getElementById('total-count').textContent = totalProducts;
            
            // Get products for current page
            const startIndex = (inventoryCurrentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const productsForPage = filteredProducts.slice(startIndex, endIndex);
            
            if (productsForPage.length === 0) {
                inventoryTableBody.innerHTML = `
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 30px;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
                                <i class="bi bi-search" style="font-size: 48px; color: #ddd;"></i>
                                <h3 style="margin: 0; color: #666;">No products found</h3>
                                <p style="margin: 0; color: #888;">Try adjusting your filters or search terms</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            // Populate table with products
            productsForPage.forEach(product => {
                const isSelected = selectedProducts.some(p => p.id === product.id);
                const imagePath = product.image ? 
                    product.image.startsWith('http') ? product.image : "{{ asset('storage') }}/" + product.image : 
                    "{{ asset('images/placeholder.png') }}";
                
                // Calculate stock status
                let stockStatus = '';
                let statusClass = '';
                const quantity = parseInt(product.quantity);
                
                if (quantity <= 0) {
                    stockStatus = 'Out of Stock';
                    statusClass = 'out-of-stock';
                } else if (quantity < 10) {
                    stockStatus = 'Low Stock';
                    statusClass = 'low-stock';
                } else {
                    stockStatus = 'In Stock';
                    statusClass = 'in-stock';
                }
                
                // Calculate total value
                const totalValue = quantity * parseFloat(product.price);
                
                inventoryTableBody.innerHTML += `
                    <tr style="border-bottom: 1px solid #eee;" data-product-id="${product.id}">
                        <td style="padding: 12px; vertical-align: middle;">
                            <div style="display: flex; align-items: center;">
                                <input type="checkbox" class="product-checkbox" style="margin-right: 8px;" 
                                       ${isSelected ? 'checked' : ''}>
                                <span class="product-id">${product.id}</span>
                            </div>
                        </td>
                        <td style="padding: 12px; vertical-align: middle; text-align: center;">
                            <img src="${imagePath}" alt="${product.title}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        </td>
                        <td style="padding: 12px; vertical-align: middle; font-weight: 500;">${product.title}</td>
                        <td style="padding: 12px; vertical-align: middle; text-align: center;">
                            <span class="badge" style="background-color: var(--hoockers-green); color: white; padding: 3px 8px; border-radius: 12px; font-size: 12px;">
                                ${product.category}
                            </span>
                        </td>
                        <td style="padding: 12px; vertical-align: middle; text-align: right; font-weight: 600;">₱${parseFloat(product.price).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td style="padding: 12px; vertical-align: middle; text-align: center;">
                            <span class="stock-indicator ${statusClass}">
                                ${product.quantity} ${product.unit || 'units'}
                            </span>
                        </td>
                        <td style="padding: 12px; vertical-align: middle; text-align: right; font-weight: 600;">
                            ₱${totalValue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                        </td>
                        <td style="padding: 12px; vertical-align: middle; text-align: center; white-space: nowrap;">
                            <button class="inventory-action-btn update-stock-btn" 
                                    data-product-id="${product.id}"
                                    data-product-title="${product.title}"
                                    data-product-quantity="${product.quantity}">
                                <i class="bi bi-plus-circle"></i> Stock
                            </button>
                            <button class="inventory-action-btn edit-btn" 
                                    data-product-id="${product.id}"
                                    data-product-title="${product.title}"
                                    data-product-category="${product.category}"
                                    data-product-location="${product.location}"
                                    data-product-unit="${product.unit}"
                                    data-product-quantity="${product.quantity}"
                                    data-product-price="${product.price}"
                                    data-product-description="${product.description || ''}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            // Add event listeners to checkboxes and buttons
            addInventoryEventListeners();
            
            // Add select all functionality
            const selectAllCheckbox = document.getElementById('select-all-checkbox');
            selectAllCheckbox.checked = false;
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.product-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    
                    // Trigger the change event to update selected products
                    const changeEvent = new Event('change');
                    checkbox.dispatchEvent(changeEvent);
                });
            });
        })
        .catch(error => {
            console.error('Error loading inventory:', error);
            inventoryTableBody.innerHTML = `
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #dc3545;">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
                            <i class="bi bi-exclamation-triangle" style="font-size: 48px;"></i>
                            <h3 style="margin: 0;">Error loading inventory</h3>
                            <p style="margin: 0;">${error.message}</p>
                            <button onclick="loadInventory(1)" class="action-btn" style="margin-top: 10px;">Try Again</button>
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    // Add event listeners to inventory table elements with enhanced functionality
    function addInventoryEventListeners() {
        // Add listeners for product checkboxes
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const productRow = this.closest('tr');
                const productId = parseInt(productRow.getAttribute('data-product-id'));
                const productTitle = productRow.querySelector('td:nth-child(3)').textContent;
                
                // Update selectedProducts array
                if (this.checked) {
                    // Add to selected products if not already in the array
                    if (!selectedProducts.some(p => p.id === productId)) {
                        selectedProducts.push({
                            id: productId,
                            title: productTitle
                        });
                    }
                } else {
                    // Remove from selected products
                    selectedProducts = selectedProducts.filter(p => p.id !== productId);
                }
                
                // Update UI to show selected products count
                updateSelectedProductsCount();
            });
        });
        
        // Add listeners for update stock buttons
        document.querySelectorAll('.update-stock-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productTitle = this.getAttribute('data-product-title');
                const productQuantity = this.getAttribute('data-product-quantity');
                
                // Set values in update stock modal
                document.getElementById('update-product-id').value = productId;
                document.getElementById('update-product-name').textContent = productTitle;
                document.getElementById('update-current-stock').textContent = productQuantity;
                
                // Reset form fields
                document.getElementById('stock-action').value = 'add';
                document.getElementById('stock-quantity').value = '1';
                document.getElementById('stock-notes').value = '';
                
                // Show the modal
                document.getElementById('updateStockModal').style.display = 'block';
            });
        });
        
        // Add listeners for edit buttons
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productTitle = this.getAttribute('data-product-title');
                const productCategory = this.getAttribute('data-product-category');
                const productLocation = this.getAttribute('data-product-location');
                const productUnit = this.getAttribute('data-product-unit');
                const productQuantity = this.getAttribute('data-product-quantity');
                const productPrice = this.getAttribute('data-product-price');
                const productDescription = this.getAttribute('data-product-description');
                
                // Close inventory modal
                document.getElementById('inventoryModal').style.display = 'none';
                
                // Set form action
                const editProductForm = document.getElementById('editProductForm');
                editProductForm.action = `{{ route('posts') }}/${productId}`;
                
                // Populate form fields
                document.getElementById('edit-title').value = productTitle;
                document.getElementById('edit-category').value = productCategory;
                
                // Handle location based on user location
                const userLocation = "{{ Auth::user()->location }}";
                if (productLocation === userLocation) {
                    document.getElementById('edit-location').value = 'user-location';
                    document.getElementById('edit-custom-location-wrapper').style.display = 'none';
                } else {
                    document.getElementById('edit-location').value = 'custom';
                    document.getElementById('edit-custom-location-input').value = productLocation;
                    document.getElementById('edit-custom-location-wrapper').style.display = 'block';
                }
                
                document.getElementById('edit-unit').value = productUnit;
                document.getElementById('edit-quantity').value = productQuantity;
                document.getElementById('edit-price').value = productPrice;
                document.getElementById('edit-description').value = productDescription;
                
                // Show the edit modal
                document.getElementById('editProductModal').style.display = 'block';
            });
        });
    }

    // Update the selected products count with enhanced UI
    function updateSelectedProductsCount() {
        const batchUpdateBtn = document.getElementById('batch-update-btn');
        const selectedCountElement = document.getElementById('selected-count');
        
        if (selectedProducts.length > 0) {
            batchUpdateBtn.innerHTML = `<i class="bi bi-layers"></i> Batch Update (${selectedProducts.length})`;
            batchUpdateBtn.disabled = false;
            selectedCountElement.textContent = selectedProducts.length;
        } else {
            batchUpdateBtn.innerHTML = `<i class="bi bi-layers"></i> Batch Update`;
            batchUpdateBtn.disabled = true;
            selectedCountElement.textContent = '0';
        }
    }

    // Add stock filter change event
    document.getElementById('inventory-stock-filter').addEventListener('change', function() {
        inventoryCurrentPage = 1;
        loadInventory(1);
    });

    // Click handler for inventory value card
    document.getElementById('inventoryValueCard').addEventListener('click', function() {
        // Open the inventory modal when clicking on the inventory value stat
        document.getElementById('inventoryModal').style.display = 'block';
        loadInventory(1);
    });

    // Update Stock Form Submission
    const updateStockForm = document.getElementById('updateStockForm');
    const updateStockModal = document.getElementById('updateStockModal');
    const updateStockCloseBtn = updateStockModal.querySelector('.close');

    // Close update stock modal when X is clicked
    updateStockCloseBtn.addEventListener('click', function() {
        updateStockModal.style.display = 'none';
    });

    // Close update stock modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === updateStockModal) {
            updateStockModal.style.display = 'none';
        }
    });

    // Handle update stock form submission
    updateStockForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const productId = document.getElementById('update-product-id').value;
        const action = document.getElementById('stock-action').value;
        const inputQuantity = parseInt(document.getElementById('stock-quantity').value);
        const notes = document.getElementById('stock-notes').value;
        const currentStock = parseInt(document.getElementById('update-current-stock').textContent);
        
        let newQuantity;
        
        // Calculate new quantity based on action
        switch (action) {
            case 'add':
                newQuantity = currentStock + inputQuantity;
                break;
            case 'remove':
                newQuantity = Math.max(0, currentStock - inputQuantity);
                break;
            case 'set':
                newQuantity = inputQuantity;
                break;
            default:
                newQuantity = currentStock;
                break;
        }
        
        // Update stock via API
        fetch(`/posts/${productId}/update-stock`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                quantity: newQuantity,
                notes: notes || `Stock ${action}ed via dashboard`
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update total inventory in the stat card
                if (data.total_inventory !== undefined) {
                    document.querySelector('#inventoryStatCard .stat-number').textContent = data.total_inventory;
                }
                
                updateStockModal.style.display = 'none';
                
                Swal.fire({
                    title: 'Success!',
                    text: 'Stock updated successfully',
                    icon: 'success',
                    confirmButtonColor: '#517A5B'
                });
                
                // Reload inventory to reflect changes
                loadInventory(inventoryCurrentPage);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Failed to update stock',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
            }
        })
        .catch(error => {
            console.error('Error updating stock:', error);
            Swal.fire({
                title: 'Error',
                text: 'Something went wrong. Please try again.',
                icon: 'error',
                confirmButtonColor: '#517A5B'
            });
        });
    });

    // Inventory History Functionality
    const inventoryHistoryModal = document.getElementById('inventoryHistoryModal');
    const inventoryHistoryCloseBtn = inventoryHistoryModal.querySelector('.close');
    const viewHistoryBtn = document.getElementById('view-history-btn');

    // Pagination variables for history
    let historyCurrentPage = 1;
    let historyTotalPages = 1;

    // Open inventory history modal when View History button is clicked
    viewHistoryBtn.addEventListener('click', function() {
        inventoryHistoryModal.style.display = 'block';
        loadInventoryHistory(1);
    });

    // Close inventory history modal when X is clicked
    inventoryHistoryCloseBtn.addEventListener('click', function() {
        inventoryHistoryModal.style.display = 'none';
    });

    // Close inventory history modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === inventoryHistoryModal) {
            inventoryHistoryModal.style.display = 'none';
        }
    });

    // Function to load inventory history
    function loadInventoryHistory(page) {
        const historyTableBody = document.getElementById('history-table-body');
        
        // Show loading state
        historyTableBody.innerHTML = `
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">
                    <i class="bi bi-arrow-repeat" style="font-size: 24px; animation: spin 1s linear infinite; display: inline-block; margin-right: 10px;"></i>
                    Loading history...
                </td>
            </tr>
        `;
        
        // Get filter values
        const productFilter = document.getElementById('history-product-filter').value;
        const actionFilter = document.getElementById('history-action-filter').value;
        const fieldFilter = document.getElementById('history-field-filter').value;
        
        // Build query params
        const queryParams = new URLSearchParams();
        queryParams.append('page', page);
        
        if (productFilter && productFilter !== 'all') {
            queryParams.append('product_id', productFilter);
        }
        
        if (actionFilter && actionFilter !== 'all') {
            queryParams.append('action', actionFilter);
        }
        
        if (fieldFilter && fieldFilter !== 'all') {
            queryParams.append('field', fieldFilter);
        }
        
        // Fetch history from API
        fetch(`/inventory-history?${queryParams.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok (Status: ${response.status})`);
            }
            return response.json();
        })
        .then(data => {
            // Check if table doesn't exist
            if (data.missing_table) {
                historyTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #dc3545;">
                            <i class="bi bi-exclamation-triangle" style="font-size: 24px; display: inline-block; margin-right: 10px;"></i>
                            Inventory history table doesn't exist. Please run migrations.
                        </td>
                    </tr>
                `;
                return;
            }
            
            // Populate product filter dropdown
            const productFilterSelect = document.getElementById('history-product-filter');
            
            // Only populate if it hasn't been populated yet
            if (productFilterSelect.querySelectorAll('option').length <= 1) {
                data.products.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.textContent = product.title;
                    productFilterSelect.appendChild(option);
                });
            }
            
            // Clear table
            historyTableBody.innerHTML = '';
            
            const historyItems = data.history.data || [];
            
            // Update pagination info
            historyCurrentPage = data.history.current_page || 1;
            historyTotalPages = data.history.last_page || 1;
            
            // Update pagination UI
            document.getElementById('history-prev-page-btn').disabled = historyCurrentPage <= 1;
            document.getElementById('history-next-page-btn').disabled = historyCurrentPage >= historyTotalPages;
            document.getElementById('history-pagination-info').textContent = `Page ${historyCurrentPage} of ${historyTotalPages}`;
            
            if (historyItems.length === 0) {
                historyTableBody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">No history records found</td>
                    </tr>
                `;
                return;
            }
            
            // Populate table with history items
            historyItems.forEach(item => {
                const date = new Date(item.created_at);
                const formattedDate = date.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric', 
                    year: 'numeric' 
                });
                
                historyTableBody.innerHTML += `
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;">${formattedDate}</td>
                        <td style="padding: 12px;">${item.product_title}</td>
                        <td style="padding: 12px;">${item.action}</td>
                        <td style="padding: 12px;">${item.field}</td>
                        <td style="padding: 12px;">${item.old_value}</td>
                        <td style="padding: 12px;">${item.new_value}</td>
                        <td style="padding: 12px;">${item.notes || 'N/A'}</td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Error loading history:', error);
            historyTableBody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #dc3545;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 24px; display: inline-block; margin-right: 10px;"></i>
                        Error loading history. Please try again.
                    </td>
                </tr>
            `;
        });
    }

    // Batch Update Functionality
    const batchUpdateModal = document.getElementById('batchUpdateModal');
    const batchUpdateCloseBtn = batchUpdateModal.querySelector('.close');
    const batchUpdateBtn = document.getElementById('batch-update-btn');
    const batchUpdateForm = document.getElementById('batchUpdateForm');
    const batchActionSelect = document.getElementById('batch-action');
    const batchValueContainer = document.getElementById('batch-value-container');
    const selectedProductsList = document.getElementById('selected-products-list');

    // Open batch update modal when batch update button is clicked
    batchUpdateBtn.addEventListener('click', function() {
        batchUpdateModal.style.display = 'block';
        populateSelectedProductsList();
    });

    // Close batch update modal when X is clicked
    batchUpdateCloseBtn.addEventListener('click', function() {
        batchUpdateModal.style.display = 'none';
    });

    // Close batch update modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === batchUpdateModal) {
            batchUpdateModal.style.display = 'none';
        }
    });

    // Populate selected products list in batch update modal
    function populateSelectedProductsList() {
        selectedProductsList.innerHTML = '';
        
        if (selectedProducts.length === 0) {
            selectedProductsList.innerHTML = '<p style="text-align: center; color: #666;">No products selected</p>';
            return;
        }
        
        selectedProducts.forEach(product => {
            const productItem = document.createElement('div');
            productItem.className = 'selected-product-item';
            productItem.style.display = 'flex';
            productItem.style.alignItems = 'center';
            productItem.style.justifyContent = 'space-between';
            productItem.style.padding = '8px 0';
            productItem.style.borderBottom = '1px solid #eee';
            
            productItem.innerHTML = `
                <span>${product.title}</span>
                <button type="button" class="remove-selected-product-btn" data-product-id="${product.id}" style="background: none; border: none; color: #dc3545; cursor: pointer;">
                    <i class="bi bi-x-circle"></i>
                </button>
            `;
            
            selectedProductsList.appendChild(productItem);
        });
        
        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-selected-product-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = parseInt(this.getAttribute('data-product-id'));
                selectedProducts = selectedProducts.filter(p => p.id !== productId);
                populateSelectedProductsList();
                updateSelectedProductsCount();
            });
        });
    }

    // Handle batch action change
    batchActionSelect.addEventListener('change', function() {
        const action = this.value;
        batchValueContainer.innerHTML = '';
        
        if (!action) {
            batchValueContainer.style.display = 'none';
            return;
        }
        
        batchValueContainer.style.display = 'block';
        
        switch (action) {
            case 'stock':
                batchValueContainer.innerHTML = `
                    <label class="form-label" for="batch-stock-action">Stock Action</label>
                    <select name="batch_stock_action" id="batch-stock-action" class="form-control" required>
                        <option value="add">Add Stock</option>
                        <option value="remove">Remove Stock</option>
                        <option value="set">Set Exact Amount</option>
                    </select>
                    <label class="form-label" for="batch-stock-quantity">Quantity</label>
                    <input type="number" name="batch_stock_quantity" id="batch-stock-quantity" class="form-control" min="1" value="1" required>
                `;
                break;
            case 'price':
                batchValueContainer.innerHTML = `
                    <label class="form-label" for="batch-price">New Price (₱)</label>
                    <input type="number" name="batch_price" id="batch-price" class="form-control" step="0.01" min="0" required>
                `;
                break;
            case 'category':
                batchValueContainer.innerHTML = `
                    <label class="form-label" for="batch-category">New Category</label>
                    <select name="batch_category" id="batch-category" class="form-control" required>
                        <option value="">--Select Category--</option>
                        <option value="Metal">Metal</option>
                        <option value="Plastic">Plastic</option>
                        <option value="Paper">Paper</option>
                        <option value="Glass">Glass</option>
                        <option value="Wood">Wood</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fabric">Fabric</option>
                        <option value="Rubber">Rubber</option>
                    </select>
                `;
                break;
        }
    });

    // Handle batch update form submission
    batchUpdateForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const action = batchActionSelect.value;
        const notes = document.getElementById('batch-notes').value;
        const productIds = selectedProducts.map(p => p.id);
        
        let payload = {
            action: action,
            product_ids: productIds,
            notes: notes
        };
        
        switch (action) {
            case 'stock':
                payload.stock_action = document.getElementById('batch-stock-action').value;
                payload.quantity = parseInt(document.getElementById('batch-stock-quantity').value);
                break;
            case 'price':
                payload.price = parseFloat(document.getElementById('batch-price').value);
                break;
            case 'category':
                payload.category = document.getElementById('batch-category').value;
                break;
        }
        
        // Send batch update request
        fetch('/inventory/batch-update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                batchUpdateModal.style.display = 'none';
                
                Swal.fire({
                    title: 'Success!',
                    text: 'Batch update completed successfully',
                    icon: 'success',
                    confirmButtonColor: '#517A5B'
                });
                
                // Reload inventory to reflect changes
                loadInventory(inventoryCurrentPage);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Failed to complete batch update',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
            }
        })
        .catch(error => {
            console.error('Error completing batch update:', error);
            Swal.fire({
                title: 'Error',
                text: 'Something went wrong. Please try again.',
                icon: 'error',
                confirmButtonColor: '#517A5B'
            });
        });
    });

    // Export Inventory Functionality
    const exportInventoryModal = document.getElementById('exportInventoryModal');
    const exportInventoryCloseBtn = exportInventoryModal.querySelector('.close');
    const exportInventoryBtn = document.getElementById('export-inventory-btn');
    const exportInventoryForm = document.getElementById('exportInventoryForm');

    // Open export inventory modal when Export Inventory button is clicked
    exportInventoryBtn.addEventListener('click', function() {
        exportInventoryModal.style.display = 'block';
    });

    // Close export inventory modal when X is clicked
    exportInventoryCloseBtn.addEventListener('click', function() {
        exportInventoryModal.style.display = 'none';
    });

    // Close export inventory modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === exportInventoryModal) {
            exportInventoryModal.style.display = 'none';
        }
    });

    // Handle export inventory form submission
    exportInventoryForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const exportType = document.getElementById('export-type').value;
        const exportFormat = document.getElementById('export-format').value;
        
        // Send export request
        fetch('/inventory/export', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                export_type: exportType,
                export_format: exportFormat
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.file_url) {
                exportInventoryModal.style.display = 'none';
                
                Swal.fire({
                    title: 'Success!',
                    text: 'Inventory exported successfully',
                    icon: 'success',
                    confirmButtonColor: '#517A5B'
                }).then(() => {
                    // Download the exported file
                    window.location.href = data.file_url;
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Failed to export inventory',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
            }
        })
        .catch(error => {
            console.error('Error exporting inventory:', error);
            Swal.fire({
                title: 'Error',
                text: 'Something went wrong. Please try again.',
                icon: 'error',
                confirmButtonColor: '#517A5B'
            });
        });
    });

    // Add this code right before the closing script tag
    
    // Image preview functionality
    window.previewImage = function(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100%';
                img.style.maxHeight = '100%';
                preview.appendChild(img);
                
                // Add remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-image-btn';
                removeBtn.innerHTML = '<i class="bi bi-x-circle"></i>';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '5px';
                removeBtn.style.right = '5px';
                removeBtn.style.backgroundColor = 'rgba(255,255,255,0.8)';
                removeBtn.style.border = 'none';
                removeBtn.style.borderRadius = '50%';
                removeBtn.style.cursor = 'pointer';
                removeBtn.style.padding = '3px';
                preview.appendChild(removeBtn);
                
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    input.value = '';
                    preview.innerHTML = '<span class="placeholder-text">No image selected</span>';
                });
            };
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.innerHTML = '<span class="placeholder-text">No image selected</span>';
        }
    };
    
    // Initialize quantity buttons for all forms
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all quantity buttons
        initQuantityButtons();
        
        // Edit Product Button Click (enhanced)
        document.querySelectorAll('.edit-product-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productTitle = this.getAttribute('data-product-title');
                const productCategory = this.getAttribute('data-product-category');
                const productLocation = this.getAttribute('data-product-location');
                const productUnit = this.getAttribute('data-product-unit');
                const productQuantity = this.getAttribute('data-product-quantity');
                const productPrice = this.getAttribute('data-product-price');
                const productDescription = this.getAttribute('data-product-description');
                
                // Set form action
                const editProductForm = document.getElementById('editProductForm');
                editProductForm.action = `{{ route('posts') }}/${productId}`;
                
                // Populate form fields
                document.getElementById('edit-title').value = productTitle;
                document.getElementById('edit-category').value = productCategory;
                
                // Handle location based on user location
                const userLocation = "{{ Auth::user()->location }}";
                if (productLocation === userLocation) {
                    document.getElementById('edit-location').value = 'user-location';
                    document.getElementById('edit-custom-location-wrapper').style.display = 'none';
                } else {
                    document.getElementById('edit-location').value = 'custom';
                    document.getElementById('edit-custom-location-input').value = productLocation;
                    document.getElementById('edit-custom-location-wrapper').style.display = 'block';
                }
                
                document.getElementById('edit-unit').value = productUnit;
                document.getElementById('edit-quantity').value = productQuantity;
                document.getElementById('edit-price').value = productPrice;
                document.getElementById('edit-description').value = productDescription;
                
                // Reset the file input field to ensure it's empty
                document.getElementById('edit-image').value = '';
                document.getElementById('editImagePreview').innerHTML = '<span class="placeholder-text">No new image selected</span>';
                
                // Load and display current product image
                loadProductImage(productId);
                
                // Show the modal
                document.getElementById('editProductModal').style.display = 'block';
            });
        });
        
        // Set up edit form delete button
        document.getElementById('editFormDeleteBtn').addEventListener('click', function() {
            const productId = document.getElementById('editProductForm').action.split('/').pop();
            const productTitle = document.getElementById('edit-title').value;
            
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you really want to delete "${productTitle}"? This cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it',
                customClass: {
                    popup: 'bigger-modal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit for DELETE request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('posts') }}/${productId}`;
                    form.style.display = 'none';
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    
                    form.submit();
                }
            });
        });
    });
    
    // Function to load product image for edit form
    function loadProductImage(productId) {
        const currentImageContainer = document.getElementById('current-product-image');
        currentImageContainer.innerHTML = '<div class="loading-indicator" style="display: flex; align-items: center; justify-content: center; height: 100%;"><i class="bi bi-arrow-repeat" style="animation: spin 1s linear infinite;"></i> Loading...</div>';
        
        // Fetch product details to get the image URL
        fetch(`/posts/${productId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.image) {
                const imgPath = data.image.startsWith('http') 
                    ? data.image 
                    : "{{ asset('storage') }}/" + data.image;
                    
                const img = document.createElement('img');
                img.src = imgPath;
                img.alt = data.title;
                img.style.maxWidth = '100%';
                img.style.maxHeight = '100%';
                img.style.objectFit = 'contain';
                currentImageContainer.innerHTML = '';
                currentImageContainer.appendChild(img);
            } else {
                currentImageContainer.innerHTML = '<div class="no-image">No image available</div>';
            }
        })
        .catch(error => {
            console.error('Error fetching product details:', error);
            currentImageContainer.innerHTML = '<div class="no-image">Failed to load image</div>';
        });
    }
    
    // Function to initialize quantity buttons
    function initQuantityButtons() {
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const input = this.closest('.input-with-icon').querySelector('input');
                const currentValue = parseInt(input.value) || 0;
                
                if (action === 'increase') {
                    input.value = currentValue + 1;
                } else if (action === 'decrease' && currentValue > 0) {
                    input.value = currentValue - 1;
                }
                
                // Trigger change event
                const event = new Event('change');
                input.dispatchEvent(event);
            });
        });
    }
    
    // Auto-fill location functionality
    document.addEventListener('DOMContentLoaded', function() {
        const locationSelect = document.getElementById('location');
        const customLocationInput = document.getElementById('custom-location-input');
        const customLocationWrapper = document.getElementById('custom-location-wrapper');

        if (locationSelect) {
            locationSelect.addEventListener('change', function () {
                if (this.value === 'custom') {
                    customLocationWrapper.style.display = 'block';
                    customLocationInput.required = true;
                } else {
                    customLocationWrapper.style.display = 'none';
                    customLocationInput.required = false;
                }
            });
        }

        const editLocationSelect = document.getElementById('edit-location');
        const editCustomLocationInput = document.getElementById('edit-custom-location-input');
        const editCustomLocationWrapper = document.getElementById('edit-custom-location-wrapper');

        if (editLocationSelect) {
            editLocationSelect.addEventListener('change', function () {
                if (this.value === 'custom') {
                    editCustomLocationWrapper.style.display = 'block';
                    editCustomLocationInput.required = true;
                } else {
                    editCustomLocationWrapper.style.display = 'none';
                    editCustomLocationInput.required = false;
                }
            });
        }
    });
</script>
</body>
</html>
