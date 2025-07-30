<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $shop->shop_name }} - Shop Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .inventory-table-container {
            max-height: 450px;
            overflow-y: auto;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inventory-table thead {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .inventory-table tbody tr {
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s ease;
        }

        .inventory-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .inventory-table tbody tr:last-child {
            border-bottom: none;
        }

        /* Stock indicator styles */
        .stock-indicator {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
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

        .inventory-action-btn {
            background: none;
            border: none;
            padding: 6px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #6c757d;
        }

        .inventory-action-btn:hover {
            background-color: #f8f9fa;
            color: var(--hoockers-green);
        }

        .inventory-action-btn i {
            font-size: 1.1rem;
        }

        .inventory-action-btn.edit-btn {
            color: #0d6efd;
        }

        .inventory-action-btn.edit-btn:hover {
            background-color: #e7f1ff;
        }

        .inventory-action-btn.delete-btn {
            color:rgb(72, 71, 71);
        }

        .inventory-action-btn.delete-btn:hover {
            background-color:rgb(162, 159, 159);
        }

        .inventory-table input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            border: 2px solid #dee2e6;
            border-radius: 3px;
        }

        .inventory-actions .action-btn {
            flex: 1;
            padding: 12px 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
        }

        .inventory-actions .action-btn:hover:not(:disabled) {
            transform: translateY(-2px);
        }

        .inventory-actions .action-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Enhanced form controls */
        .form-control.enhanced:focus {
            border-color: var(--hoockers-green);
            box-shadow: 0 0 0 3px rgba(81, 122, 91, 0.1);
            outline: none;
        }

        /* Image upload hover effect */
        .image-upload-container:hover {
            border-color: var(--hoockers-green);
            background-color: rgba(81, 122, 91, 0.02);
        }

        /* Button hover effects */
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn-secondary:hover {
            background-color: #e8e8e8;
        }

        .btn-primary:hover {
            background-color: var(--hoockers-green_80);
        }

        /* Modal animation */
        .modal {
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Close button hover effect */
        .close:hover {
            color: var(--hoockers-green);
        }

        /* Shop Settings Modal Styles */
        .shop-overview {
            padding: 20px;
        }

        .shop-info {
            font-size: 16px;
            color: #333;
            margin: 5px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .shop-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .stat-item {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            text-align: center;
        }

        .stat-item .stat-label {
            display: block;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .stat-item .stat-value {
            display: block;
            font-size: 18px;
            font-weight: 600;
            color: #517A5B;
        }

        /* Add these styles to your existing styles */
        .modal {
            transition: opacity 0.3s ease;
        }

        .product-overview-grid {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .image-wrapper {
            transition: all 0.3s ease;
        }

        .image-wrapper:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        #overviewProductImage {
            transition: all 0.3s ease;
        }

        .detail-section {
            transition: all 0.3s ease;
        }

        .detail-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .description-section {
            transition: all 0.3s ease;
        }

        .description-section:hover {
            transform: translateY(-2px);
        }

        .price-tag {
            transition: all 0.3s ease;
        }

        .price-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(81, 122, 91, 0.2);
        }

        /* Earnings Modal Styles */
        .earnings-summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .earnings-summary-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .earnings-summary-card:hover {
            transform: translateY(-5px);
        }

        .earnings-summary-card .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .total-earnings .card-icon {
            background: linear-gradient(135deg, #517A5B 0%, #3a5c42 100%);
            color: white;
        }

        .net-earnings .card-icon {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
        }

        .commission-paid .card-icon {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .earnings-summary-card .card-content {
            flex: 1;
        }

        .earnings-summary-card h3 {
            margin: 0;
            font-size: 16px;
            color: #666;
        }

        .earnings-summary-card .amount {
            margin: 5px 0;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .earnings-summary-card .label {
            font-size: 12px;
            color: #888;
        }

        .recent-earnings {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }

        .recent-earnings h3 {
            margin: 0 0 20px 0;
            color: #333;
        }

        .earnings-table {
            width: 100%;
            border-collapse: collapse;
        }

        .earnings-table th,
        .earnings-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .earnings-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #666;
        }

        .earnings-table tr:hover {
            background: #f8f9fa;
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Detailed Earnings Breakdown Styles */
        .breakdown-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-stat {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .summary-stat h4 {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .summary-stat .stat-value {
            margin: 10px 0 0;
            font-size: 24px;
            font-weight: bold;
            color: #517A5B;
        }

        .earnings-timeline {
            background: white;
            border-radius: 15px;
            padding: 20px;
        }

        .earnings-timeline h3 {
            margin: 0 0 20px;
            color: #333;
        }

        .timeline-container {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .timeline-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .timeline-item:last-child {
            border-bottom: none;
        }

        .timeline-date {
            min-width: 100px;
            text-align: right;
        }

        .timeline-date .date {
            display: block;
            font-weight: 600;
            color: #333;
        }

        .timeline-date .time {
            display: block;
            font-size: 12px;
            color: #666;
        }

        .timeline-content {
            flex: 1;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .order-header h4 {
            margin: 0;
            color: #333;
        }

        .order-amount {
            font-weight: 600;
            color: #517A5B;
        }

        .order-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }

        .customer-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
            color: #666;
        }

        .products-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .product-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px;
            background: white;
            border-radius: 8px;
        }

        .product-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }

        .product-info {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-name {
            font-weight: 500;
            color: #333;
        }

        .product-quantity {
            color: #666;
        }

        .product-price {
            font-weight: 600;
            color: #517A5B;
        }

        .order-summary {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            color: #666;
        }

        .summary-row.total {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-weight: 600;
            color: #333;
        }

        .no-orders {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .no-orders i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #ccc;
        }

        /* Scrollbar Styling */
        .timeline-container::-webkit-scrollbar {
            width: 8px;
        }

        .timeline-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .timeline-container::-webkit-scrollbar-thumb {
            background: #517A5B;
            border-radius: 4px;
        }

        .timeline-container::-webkit-scrollbar-thumb:hover {
            background: #3a5c42;
        }

        /* Orders Management Modal Styles */
        .order-status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .order-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .accept-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .reject-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .accept-btn:hover {
            background-color: #218838;
        }

        .reject-btn:hover {
            background-color: #c82333;
        }

        /* Export Button Styles */
        .export-actions {
            display: flex;
            gap: 10px;
            margin-right: 20px;
        }

        .export-btn {
            background-color: #517A5B;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9em;
        }

        .export-btn:hover {
            background-color: #446749;
        }

        /* Delete Button Styles */
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        /* Inventory action buttons */
        .inventory-action-btn {
            padding: 6px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 2px;
            transition: all 0.3s ease;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .delete-btn:hover {
            background-color: #da190b;
        }

        .inventory-action-btn i {
            font-size: 14px;
        }

        .report-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .report-btn:hover {
            background-color: #fff3f3;
        }

        .report-btn i {
            font-size: 0.9em;
        }

        #reportUserModal .modal-content {
            padding: 20px;
        }

        #reportUserModal .form-group {
            margin-bottom: 20px;
        }

        #reportUserModal label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        #reportUserModal select,
        #reportUserModal textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        #reportUserModal textarea {
            resize: vertical;
            min-height: 100px;
        }

        #reportUserModal .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        #reportUserModal .cancel-btn,
        #reportUserModal .submit-btn {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        #reportUserModal .cancel-btn {
            background: #f8f9fa;
            border: 1px solid #ddd;
            color: #333;
        }

        #reportUserModal .submit-btn {
            background: #dc3545;
            border: none;
            color: white;
        }

        #reportUserModal .cancel-btn:hover {
            background: #e9ecef;
        }

        #reportUserModal .submit-btn:hover {
            background: #c82333;
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
                    <!-- <h1>{{ $shop->shop_name }}</h1>
                    <p>{{ $shop->shop_address }}</p> -->
                    
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
                            <div style="color: white;">Products</div>
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
                        <div class="stat-card earnings-card" id="earningsStatCard" style="cursor: pointer;">
                            <i class="bi bi-currency-dollar"></i>
                            <div class="stat-number">
                                @php
                                    try {
                                        $totalEarnings = \App\Models\Order::where('seller_id', Auth::id())
                                                    ->where('status', 'completed')
                                                    ->sum('total_amount');
                                        $netEarnings = $totalEarnings * 0.9;
                                        echo '₱' . number_format($netEarnings ?? 0, 2);
                                    } catch (\Exception $e) {
                                        echo '₱0.00';
                                    }
                                @endphp
                            </div>
                            <div class="stat-label">Earnings (after 10% fee)</div>
                        </div>

                        <!-- New Inventory Stat Card -->
                        <div class="stat-card" id="inventoryStatCard" style="background-color: #517A5B; color: white; cursor: pointer;">
                            <i class="bi bi-box-seam"></i>
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
                            <div style="color: white;">Inventory Value</div>
                        </div>
                    </div>
                </div>

                <div class="quick-actions">
                    <button id="manageOrdersBtn" class="action-btn">
                        <i class="bi bi-cart-check"></i> Manage Orders
                    </button>
                    <button id="allProductsBtn" class="action-btn">
                        <i class="bi bi-box-seam"></i> All Products
                    </button>
                    <button id="shopSettingsBtn" class="action-btn" style="border: none; display: block; width: 100%; text-align: center; cursor: pointer;">
                        <i class="bi bi-gear"></i> Shop Settings
                    </button>
                </div>

                <div class="recent-products">
                    <h2 style="font-size: 24px; font-weight: 600; color: #333; margin-bottom: 25px;">Recent Products</h2>
                    <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px;">
                        @php
                            try {
                                $recentProducts = \App\Models\Post::where('user_id', Auth::id())
                                    ->latest()
                                    ->take(4)
                                    ->get();
                            } catch (\Exception $e) {
                                $recentProducts = collect([]);
                            }
                        @endphp
                        
                        @if(count($recentProducts) > 0)
                            @foreach($recentProducts as $product)
                                <div class="product-card" 
                                    style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer;"
                                    onclick="showProductOverview({{ $product->id }})"
                                                data-product-id="{{ $product->id }}"
                                                data-product-title="{{ $product->title }}"
                                                data-product-category-id="{{ $product->category_id }}"
                                                data-product-category="{{ $product->category_name }}"
                                                data-product-location="{{ $product->location }}"
                                                data-product-unit="{{ $product->unit }}"
                                                data-product-quantity="{{ $product->quantity }}"
                                                data-product-price="{{ $product->price }}"
                                                data-product-description="{{ $product->description }}">
                                    <div class="product-image" style="position: relative; height: 200px; overflow: hidden;">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" 
                                                style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                        @else
                                            <img src="{{ asset('images/placeholder.png') }}" alt="No image" 
                                                style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                        @endif
                                        <div class="product-category" 
                                            style="position: absolute; top: 15px; right: 15px; background: rgba(81, 122, 91, 0.9); color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                            {{ $product->category_name }}
                                        </div>
                                    </div>
                                    <div class="product-info" style="padding: 20px;">
                                        <h3 style="font-size: 18px; font-weight: 600; color: #333; margin-bottom: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $product->title }}
                                        </h3>
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                            <span style="font-size: 20px; font-weight: 700; color: var(--hoockers-green);">
                                                ₱{{ number_format($product->price, 2) }}
                                            </span>
                                            <span style="font-size: 14px; color: #666;">
                                                {{ $product->unit }}
                                            </span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div style="display: flex; align-items: center; gap: 5px;">
                                                <i class="bi bi-box-seam" style="color: var(--hoockers-green);"></i>
                                                <span style="font-size: 14px; color: #666;">
                                                    Stock: {{ $product->quantity }}
                                                </span>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 5px;">
                                                <i class="bi bi-geo-alt" style="color: var(--hoockers-green);"></i>
                                                <span style="font-size: 14px; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                                                    {{ $product->location }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state" style="grid-column: 1 / -1; text-align: center; padding: 40px 20px; background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                <i class="bi bi-box" style="font-size: 48px; color: #dee2e6; margin-bottom: 15px;"></i>
                                <h3 style="font-size: 20px; font-weight: 600; color: #333; margin-bottom: 10px;">No products yet</h3>
                                <p style="color: #666; margin-bottom: 20px;">Start selling by adding your first product</p>
                                <a href="{{ route('sell.item') }}" class="action-btn" style="display: inline-block; padding: 12px 25px; background: var(--hoockers-green); color: white; text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s ease;">
                                    <i class="bi bi-plus-circle"></i> Add Product
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Overview Modal -->
                <div id="productOverviewModal" class="modal">
                    <div class="modal-content" style="max-width: 1000px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        <div class="modal-header" style="padding: 25px 30px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                            <h2 class="modal-title" style="color: var(--hoockers-green); font-size: 28px; font-weight: 700; margin: 0;">Product Overview</h2>
                            <span class="close" style="color: #666; font-size: 32px; font-weight: 300; cursor: pointer; transition: color 0.3s ease;">&times;</span>
                        </div>
                        <div class="modal-body" style="padding: 30px;">
                            <div class="product-overview-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                                <!-- Left Column - Image -->
                                <div class="product-image-container" style="position: relative;">
                                    <div class="image-wrapper" style="position: relative; width: 100%; height: 400px; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                        <img id="overviewProductImage" src="" alt="Product Image" 
                                            style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                    </div>
                                    <div class="category-badge" style="position: absolute; top: 20px; right: 20px; background: rgba(81, 122, 91, 0.9); color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500; backdrop-filter: blur(4px);">
                                        <span id="overviewProductCategory"></span>
                                    </div>
                                </div>
                                
                                <!-- Right Column - Details -->
                                <div class="product-details" style="display: flex; flex-direction: column; gap: 25px;">
                                    <div class="product-header">
                                        <h3 id="overviewProductTitle" style="font-size: 28px; font-weight: 700; color: #333; margin-bottom: 15px; line-height: 1.3;"></h3>
                                        <div class="price-tag" style="display: inline-block; background: var(--hoockers-green); color: white; padding: 8px 20px; border-radius: 30px; font-size: 24px; font-weight: 700;">
                                            <span id="overviewProductPrice"></span>
                                            <span id="overviewProductUnit" style="font-size: 16px; opacity: 0.9; margin-left: 5px;"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-section" style="background: #f8f9fa; padding: 20px; border-radius: 12px;">
                                        <div class="detail-item" style="margin-bottom: 20px;">
                                            <label style="display: block; font-size: 14px; color: #666; margin-bottom: 8px; font-weight: 500;">
                                                <i class="bi bi-box-seam" style="color: var(--hoockers-green); margin-right: 8px;"></i>Stock
                                            </label>
                                            <span id="overviewProductStock" style="font-size: 18px; color: #333; font-weight: 600;"></span>
                                        </div>
                                        
                                        <div class="detail-item" style="margin-bottom: 20px;">
                                            <label style="display: block; font-size: 14px; color: #666; margin-bottom: 8px; font-weight: 500;">
                                                <i class="bi bi-geo-alt" style="color: var(--hoockers-green); margin-right: 8px;"></i>Location
                                            </label>
                                            <span id="overviewProductLocation" style="font-size: 18px; color: #333; font-weight: 600;"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="description-section">
                                        <label style="display: block; font-size: 14px; color: #666; margin-bottom: 12px; font-weight: 500;">
                                            <i class="bi bi-text-paragraph" style="color: var(--hoockers-green); margin-right: 8px;"></i>Description
                                        </label>
                                        <p id="overviewProductDescription" style="font-size: 16px; color: #333; line-height: 1.6; background: #f8f9fa; padding: 20px; border-radius: 12px;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                // Product Overview Modal Functionality
                function showProductOverview(id) {
                    const button = document.querySelector(`[data-product-id="${id}"]`);
                    if (!button) return;

                    const productData = {
                        id: button.getAttribute('data-product-id'),
                        title: button.getAttribute('data-product-title'),
                        category: button.getAttribute('data-product-category'),
                        location: button.getAttribute('data-product-location'),
                        unit: button.getAttribute('data-product-unit'),
                        quantity: button.getAttribute('data-product-quantity'),
                        price: button.getAttribute('data-product-price'),
                        description: button.getAttribute('data-product-description')
                    };

                    // Update modal content
                    document.getElementById('overviewProductTitle').textContent = productData.title;
                    document.getElementById('overviewProductCategory').textContent = productData.category;
                    document.getElementById('overviewProductPrice').textContent = `₱${parseFloat(productData.price).toFixed(2)}`;
                    document.getElementById('overviewProductUnit').textContent = productData.unit;
                    document.getElementById('overviewProductStock').textContent = `${productData.quantity} units`;
                    document.getElementById('overviewProductLocation').textContent = productData.location;
                    document.getElementById('overviewProductDescription').textContent = productData.description || 'No description available';

                    // Update product image
                    const productImage = button.querySelector('.product-image img');
                    if (productImage) {
                        const overviewImage = document.getElementById('overviewProductImage');
                        overviewImage.src = productImage.src;
                        
                        // Add loading state
                        overviewImage.style.opacity = '0';
                        overviewImage.onload = function() {
                            overviewImage.style.opacity = '1';
                        };
                    }

                    // Show modal with animation
                    const modal = document.getElementById('productOverviewModal');
                    modal.style.display = 'block';
                    modal.style.opacity = '0';
                    setTimeout(() => {
                        modal.style.opacity = '1';
                    }, 10);
                }

                // Close modal when clicking the X button
                document.querySelector('#productOverviewModal .close').addEventListener('click', function() {
                    const modal = document.getElementById('productOverviewModal');
                    modal.style.opacity = '0';
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 300);
                });

                // Close modal when clicking outside
                window.addEventListener('click', function(e) {
                    const modal = document.getElementById('productOverviewModal');
                    if (e.target === modal) {
                        modal.style.opacity = '0';
                        setTimeout(() => {
                            modal.style.display = 'none';
                        }, 300);
                    }
                });

                // Add hover effect to product image
                document.getElementById('overviewProductImage').addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });

                document.getElementById('overviewProductImage').addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
                </script>

                            <div class="empty-state">
                                <i class="bi bi-box"></i>
                                <h3>No products yet</h3>
                                <p>Start selling by adding your first product</p>
                                <a href="{{ route('sell.item') }}" class="action-btn" style="display: inline-block; margin-top: 15px;">
                                    <i class="bi bi-plus-circle"></i> Add Product
                                </a>
                </div>
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

        // Check for delete message in session and show popup
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

        // Update the products stat card click handler
        document.getElementById('productsStatCard').addEventListener('click', function() {
            window.location.href = "{{ route('sell.item') }}";
        });

        // Inventory Management
        const inventoryModal = document.getElementById('inventoryModal');
        const updateStockModal = document.getElementById('updateStockModal');
        const inventoryHistoryModal = document.getElementById('inventoryHistoryModal');
        const inventoryTableBody = document.getElementById('inventory-table-body');
        const inventorySearch = document.getElementById('inventory-search');
        const categoryFilter = document.getElementById('inventory-category-filter');
        const stockFilter = document.getElementById('inventory-stock-filter');
        const selectAllCheckbox = document.getElementById('select-all-inventory');
        const batchUpdateBtn = document.getElementById('batch-update-btn');
        const exportInventoryBtn = document.getElementById('export-inventory-btn');
        const updateStockForm = document.getElementById('updateStockForm');
        const exportHistoryBtn = document.getElementById('export-history-btn');

        let currentPage = 1;
        let totalPages = 1;
        let selectedItems = new Set();

        // Open inventory modal when clicking inventory stat cards
        document.getElementById('inventoryStatCard').addEventListener('click', () => {
            inventoryModal.style.display = 'block';
            loadInventory();
        });

        document.getElementById('inventoryValueCard').addEventListener('click', () => {
            inventoryModal.style.display = 'block';
            loadInventory();
        });

        // Close modals when clicking the X or outside the modal
        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.addEventListener('click', () => {
                inventoryModal.style.display = 'none';
                updateStockModal.style.display = 'none';
                inventoryHistoryModal.style.display = 'none';
            });
        });

        window.addEventListener('click', (e) => {
            if (e.target === inventoryModal) inventoryModal.style.display = 'none';
            if (e.target === updateStockModal) updateStockModal.style.display = 'none';
            if (e.target === inventoryHistoryModal) inventoryHistoryModal.style.display = 'none';
        });

        // Load inventory data
        function loadInventory() {
            const searchTerm = inventorySearch.value;
            const categoryId = categoryFilter.value;
            const stockLevel = stockFilter.value;

            // Show loading state
            inventoryTableBody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">
                        <p>Loading inventory...</p>
                    </td>
                </tr>
            `;

            // Fetch inventory from API
            fetch(`{{ route("api.inventory") }}?page=${currentPage}&search=${searchTerm}&category=${categoryId}&stock=${stockLevel}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                if (!data.success && data.message) {
                    throw new Error(data.message);
                }
                
                if (!data.products) {
                    throw new Error('Invalid response format from server');
                }

                    updateInventoryTable(data.products);
                    updateInventoryStats(data.stats);
                    totalPages = data.total_pages;
                    updatePagination();
                })
                .catch(error => {
                    console.error('Error loading inventory:', error);
                inventoryTableBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">
                            <p style="color: #dc3545;">${error.message || 'Failed to load inventory data.'}</p>
                        </td>
                    </tr>
                `;
                    Swal.fire({
                        title: 'Error!',
                    text: error.message || 'Failed to load inventory data.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
        }

        // Update inventory table with data
        function updateInventoryTable(products) {
            const tbody = document.getElementById('inventory-table-body');
            tbody.innerHTML = '';
            selectedItems = new Set();

            products.forEach(product => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="padding: 12px; text-align: center;">
                        <input type="checkbox" class="product-checkbox" data-id="${product.id}">
                    </td>
                    <td style="padding: 12px;">${product.title}</td>
                    <td style="padding: 12px;">${product.category_name}</td>
                    <td style="padding: 12px; text-align: center;">
                        <span class="stock-indicator ${getStockClass(product.quantity)}">
                            ${product.quantity}
                        </span>
                    </td>
                    <td style="padding: 12px; text-align: right;">₱${product.price}</td>
                    <td style="padding: 12px; text-align: center;">
                        <button class="inventory-action-btn edit-btn" 
                            onclick="editProduct(${product.id})"
                            data-product-id="${product.id}"
                            data-product-title="${product.title}"
                            data-product-category-id="${product.category_id}"
                            data-product-category="${product.category_name}"
                            data-product-location="${product.location}"
                            data-product-unit="${product.unit}"
                            data-product-quantity="${product.quantity}"
                            data-product-price="${product.price}"
                            data-product-description="${product.description}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="inventory-action-btn delete-btn" onclick="deleteProduct(${product.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);

                // Add event listener for checkbox
                const checkbox = tr.querySelector('.product-checkbox');
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        selectedItems.add(product.id);
                    } else {
                        selectedItems.delete(product.id);
                    }
                    updateSelectedItemsCount();
                });
            });
        }

        // Update inventory statistics
        function updateInventoryStats(stats) {
            document.getElementById('dashboard-inventory-value').textContent = `₱${stats.total_value}`;
            document.getElementById('low-stock-count').textContent = stats.low_stock;
            document.getElementById('out-stock-count').textContent = stats.out_of_stock;
        }

        // Get stock level class
        function getStockClass(quantity) {
            if (quantity <= 0) return 'out-of-stock';
            if (quantity < 10) return 'low-stock';
            return 'in-stock';
        }

        // Update pagination controls
        function updatePagination() {
            const prevBtn = document.getElementById('inventory-prev-page-btn');
            const nextBtn = document.getElementById('inventory-next-page-btn');
            const pageInfo = document.getElementById('inventory-pagination-info');

            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;
            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
        }

        // Update selected items count
        function updateSelectedItemsCount() {
            const count = selectedItems.size;
            document.getElementById('selected-items-count').textContent = `${count} items selected`;
            batchUpdateBtn.disabled = count === 0;
        }

        // Event listeners for filters and search
        inventorySearch.addEventListener('input', debounce(loadInventory, 300));
        categoryFilter.addEventListener('change', loadInventory);
        stockFilter.addEventListener('change', loadInventory);

        // Select all checkbox
        selectAllCheckbox.addEventListener('change', (e) => {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
                const productId = checkbox.dataset.id;
                if (e.target.checked) {
                    selectedItems.add(productId);
                } else {
                    selectedItems.delete(productId);
                }
            });
            updateSelectedItemsCount();
        });

        // Pagination buttons
        document.getElementById('inventory-prev-page-btn').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                loadInventory();
            }
        });

        document.getElementById('inventory-next-page-btn').addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                loadInventory();
            }
        });

        // Batch update button
        batchUpdateBtn.addEventListener('click', () => {
            if (selectedItems.size === 0) return;

            const batchUpdateModal = document.getElementById('batchUpdateModal');
            const selectedProductsList = document.getElementById('selected-products-list');
            
            // Update selected products list
            selectedProductsList.innerHTML = '';
            Array.from(selectedItems).forEach(productId => {
                const product = document.querySelector(`.product-checkbox[data-id="${productId}"]`).closest('tr');
                const productName = product.querySelector('td:nth-child(2)').textContent;
                selectedProductsList.innerHTML += `<div>${productName}</div>`;
            });

            // Show the modal
            batchUpdateModal.style.display = 'block';
        });

        // Batch update form submission
        const batchUpdateForm = document.getElementById('batchUpdateForm');
        
        // Handle batch action change
        document.getElementById('batch-action').addEventListener('change', function() {
            const action = this.value;
            const batchValueContainer = document.getElementById('batch-value-container');
            
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
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    `;
                    break;
            }
        });

        batchUpdateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const action = document.getElementById('batch-action').value;
            const notes = document.getElementById('batch-notes').value;
            const productIds = Array.from(selectedItems);
            
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
            fetch('/api/inventory/batch-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('batchUpdateModal').style.display = 'none';
                    
                    Swal.fire({
                        title: 'Success!',
                        text: 'Batch update completed successfully',
                        icon: 'success',
                        confirmButtonColor: '#517A5B'
                    });
                    
                    // Clear selected items
                    selectedItems.clear();
                    updateSelectedItemsCount();
                    
                    // Reload inventory to reflect changes
                    loadInventory(1);
                } else {
                    throw new Error(data.message || 'Failed to complete batch update');
                }
            })
            .catch(error => {
                console.error('Error completing batch update:', error);
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'Something went wrong. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
            });
        });

        // Close batch update modal when clicking outside
        window.addEventListener('click', function(e) {
            const batchUpdateModal = document.getElementById('batchUpdateModal');
            if (e.target === batchUpdateModal) {
                batchUpdateModal.style.display = 'none';
            }
        });

        // Close batch update modal when X is clicked
        document.querySelector('#batchUpdateModal .close').addEventListener('click', function() {
            document.getElementById('batchUpdateModal').style.display = 'none';
        });

        // Export inventory button
        exportInventoryBtn.addEventListener('click', () => {
            const searchTerm = inventorySearch.value;
            const categoryId = categoryFilter.value;
            const stockLevel = stockFilter.value;

            window.location.href = `/api/inventory/export?search=${searchTerm}&category=${categoryId}&stock=${stockLevel}`;
        });

        // Export history button
        exportHistoryBtn.addEventListener('click', () => {
            const productId = document.getElementById('inventory-history-body').dataset.productId;
            window.location.href = `/api/inventory/history/export?product_id=${productId}`;
        });

        // Helper function for debouncing
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Update stock function
        window.updateStock = function(productId, currentStock) {
            document.getElementById('update-product-id').value = productId;
            document.getElementById('update-current-stock').textContent = currentStock;
            updateStockModal.style.display = 'block';
        };

        // View history function
        window.viewHistory = function(productId) {
            fetch(`/api/inventory/history?product_id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    const historyBody = document.getElementById('inventory-history-body');
                    historyBody.dataset.productId = productId;
                    historyBody.innerHTML = '';

                    data.forEach(record => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td style="padding: 12px;">${record.date}</td>
                            <td style="padding: 12px;">${record.product_name}</td>
                            <td style="padding: 12px; text-align: center;">
                                <span class="stock-indicator ${record.action === 'add' ? 'in-stock' : 'out-of-stock'}">
                                    ${record.action}
                                </span>
                            </td>
                            <td style="padding: 12px; text-align: center;">${record.quantity}</td>
                            <td style="padding: 12px;">${record.notes || '-'}</td>
                        `;
                        historyBody.appendChild(row);
                    });

                    inventoryHistoryModal.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error loading history:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to load inventory history.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
        };

        // Update batch stock function
        function updateBatchStock(action, quantity, notes) {
            const productIds = Array.from(selectedItems);
            
            fetch('/api/inventory/batch-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_ids: productIds,
                    action,
                    quantity,
                    notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Stock updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#517A5B'
                    });
                    loadInventory();
                } else {
                    throw new Error(data.message || 'Failed to update stock');
                }
            })
            .catch(error => {
                console.error('Error updating stock:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Failed to update stock.',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
            });
        }

        // Update stock form submission
        updateStockForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(updateStockForm);
            const productId = formData.get('product_id');
            const action = formData.get('stock_action');
            const quantity = formData.get('quantity');
            const notes = formData.get('notes');

            fetch('/api/inventory/update-stock', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    action,
                    quantity,
                    notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Stock updated successfully.',
                        icon: 'success',
                        confirmButtonColor: '#517A5B'
                    });
                    updateStockModal.style.display = 'none';
                    loadInventory();
                } else {
                    throw new Error(data.message || 'Failed to update stock');
                }
            })
            .catch(error => {
                console.error('Error updating stock:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Failed to update stock.',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
            });
        });

        // Add delete product function
        function deleteProduct(productId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form and submit it
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('posts.destroy', '') }}/${productId}`;
                    
                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);
                    
                    // Add method field for DELETE
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    });
    </script>

    <!-- Add new Inventory Management Modal -->
    <div id="inventoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Inventory Management</h2>
                <span class="close">&times;</span>
            </div>

            <!-- Inventory Dashboard Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <div class="dashboard-card inventory-value">
                    <div class="dashboard-card-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h3>Total Value</h3>
                    <p id="dashboard-inventory-value">-</p>
                </div>
                <div class="dashboard-card inventory-status">
                    <div class="dashboard-card-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h3>Stock Alerts</h3>
                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                        <span id="low-stock-count" class="badge badge-warning">0</span>
                        <span id="out-stock-count" class="badge badge-danger">0</span>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div>
                    <label for="inventory-category-filter" style="display: block; font-weight: 600; margin-bottom: 5px;">Category</label>
                    <select id="inventory-category-filter" class="form-control" style="padding: 8px; min-width: 150px;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="inventory-stock-filter" style="display: block; font-weight: 600; margin-bottom: 5px;">Stock Level</label>
                    <select id="inventory-stock-filter" class="form-control" style="padding: 8px; min-width: 150px;">
                        <option value="">All Stock Levels</option>
                        <option value="in-stock">In Stock</option>
                        <option value="low-stock">Low Stock (<10)</option>
                        <option value="out-of-stock">Out of Stock</option>
                    </select>
                </div>
                <div>
                    <label for="inventory-search" style="display: block; font-weight: 600; margin-bottom: 5px;">Search</label>
                    <div style="position: relative;">
                        <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                        <input type="text" id="inventory-search" class="form-control" placeholder="Search products..." style="padding: 8px; padding-left: 35px;">
                    </div>
                </div>
            </div>

            <!-- Inventory Table -->
            <div class="inventory-table-container">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th style="padding: 12px; text-align: left;">
                                <input type="checkbox" id="select-all-inventory">
                            </th>
                            <th style="padding: 12px; text-align: left;">Product</th>
                            <th style="padding: 12px; text-align: left;">Category</th>
                            <th style="padding: 12px; text-align: center; white-space: nowrap;">Stock</th>
                            <th style="padding: 12px; text-align: right;">Price</th>
                            <th style="padding: 12px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="inventory-table-body">
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px;">
                                <p>Loading inventory...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="inventory-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <div class="inventory-summary">
                    <span id="selected-items-count">0 items selected</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <button id="inventory-prev-page-btn" class="pagination-btn" disabled>
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <span id="inventory-pagination-info">Page 1 of 1</span>
                    <button id="inventory-next-page-btn" class="pagination-btn">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Inventory Action Buttons -->
            <div class="inventory-actions">
                <button id="batch-update-btn" class="action-btn" disabled>
                    <i class="bi bi-layers"></i> Batch Update
                </button>
                <button id="export-inventory-btn" class="action-btn">
                    <i class="bi bi-download"></i> Export Inventory
                </button>
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
            <form id="updateStockForm">
                <input type="hidden" name="product_id" id="update-product-id">
                <div class="form-group">
                    <label class="form-label">Current Stock</label>
                    <p id="update-current-stock" style="font-size: 1.2rem; margin-bottom: 10px; padding: 8px; background-color: #f8f9fa; border-radius: 4px;"></p>
                </div>
                <div class="form-group">
                    <label class="form-label" for="stock-action">Action</label>
                    <select name="stock_action" id="stock-action" class="form-control" required>
                        <option value="add">Add Stock</option>
                        <option value="remove">Remove Stock</option>
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

    <!-- Inventory History Modal -->
    <div id="inventoryHistoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Inventory History</h2>
                <span class="close">&times;</span>
            </div>
            <div class="inventory-table-container">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th style="padding: 12px; text-align: left;">Date</th>
                            <th style="padding: 12px; text-align: left;">Product</th>
                            <th style="padding: 12px; text-align: center;">Action</th>
                            <th style="padding: 12px; text-align: center;">Quantity</th>
                            <th style="padding: 12px; text-align: left;">Notes</th>
                        </tr>
                    </thead>
                    <tbody id="inventory-history-body">
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">
                                <p>Loading history...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Export History Button -->
            <div style="margin-top: 20px; text-align: right;">
                <button id="export-history-btn" class="action-btn">
                    <i class="bi bi-download"></i> Export History
                </button>
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

    <!-- Prices Guide Modal -->
    <div id="pricesGuideModal" class="modal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
        <div class="modal-content" style="background-color: white; margin: 50px auto; padding: 20px; width: 90%; max-width: 900px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h2 class="modal-title" style="color: var(--hoockers-green); font-size: 32px; font-weight: 600; margin: 0;">Materials Price Guide</h2>
                <span class="close" style="color: #aaa; float: right; font-size: 36px; font-weight: bold; cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <p style="font-size: 18px; line-height: 28px; margin-bottom: 10px;">This guide provides current market prices for different types of recyclable materials.</p>
                
                <!-- Category tabs -->
                <div style="display: flex; margin-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                    <button id="plasticTabBtn" class="category-tab active-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        Plastic
                        <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>
                    </button>
                    <button id="paperTabBtn" class="category-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        Paper
                    </button>
                    <button id="metalTabBtn" class="category-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        Metal
                    </button>
                    <button id="batteriesTabBtn" class="category-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        Batteries
                    </button>
                    <button id="glassTabBtn" class="category-tab" style="flex: 1; padding: 10px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; position: relative;">
                        Glass
                    </button>
                </div>

                <!-- Price tables -->
                <div id="plasticPricesTable" style="display: block;">
                    <table class="price-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Material</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Price Range (₱/kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">PET Bottles</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱15 - ₱25</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">HDPE Containers</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱20 - ₱30</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">PVC Pipes</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱18 - ₱28</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="paperPricesTable" style="display: none;">
                    <table class="price-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Material</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Price Range (₱/kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Newspaper</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱8 - ₱12</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Cardboard</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱10 - ₱15</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Office Paper</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱12 - ₱18</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="metalPricesTable" style="display: none;">
                    <table class="price-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Material</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Price Range (₱/kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Aluminum Cans</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱45 - ₱60</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Copper Wire</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱300 - ₱400</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Steel</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱25 - ₱35</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="batteriesPricesTable" style="display: none;">
                    <table class="price-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Material</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Price Range (₱/kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Car Batteries</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱80 - ₱100</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">AA/AAA Batteries</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱60 - ₱80</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="glassPricesTable" style="display: none;">
                    <table class="price-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6;">Material</th>
                                <th style="padding: 12px; text-align: right; border-bottom: 2px solid #dee2e6;">Price Range (₱/kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Clear Glass</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱5 - ₱8</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid #dee2e6;">Colored Glass</td>
                                <td style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6;">₱4 - ₱7</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Prices Guide Modal Functionality
        const pricesGuideModal = document.getElementById('pricesGuideModal');
        const pricesGuideBtn = document.getElementById('pricesGuideBtn');
        const pricesGuideCloseBtn = pricesGuideModal.querySelector('.close');
        
        // Tab buttons
        const plasticTabBtn = document.getElementById('plasticTabBtn');
        const paperTabBtn = document.getElementById('paperTabBtn');
        const metalTabBtn = document.getElementById('metalTabBtn');
        const batteriesTabBtn = document.getElementById('batteriesTabBtn');
        const glassTabBtn = document.getElementById('glassTabBtn');
        
        // Price tables
        const plasticPricesTable = document.getElementById('plasticPricesTable');
        const paperPricesTable = document.getElementById('paperPricesTable');
        const metalPricesTable = document.getElementById('metalPricesTable');
        const batteriesPricesTable = document.getElementById('batteriesPricesTable');
        const glassPricesTable = document.getElementById('glassPricesTable');
        
        // Open prices guide modal when button is clicked
        pricesGuideBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent form submission
            pricesGuideModal.style.display = 'block';
        });
        
        // Close prices guide modal when X is clicked
        pricesGuideCloseBtn.addEventListener('click', function() {
            pricesGuideModal.style.display = 'none';
        });
        
        // Close prices guide modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === pricesGuideModal) {
                pricesGuideModal.style.display = 'none';
            }
        });
        
        // Tab switching functionality
        plasticTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'block';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'none';
            
            plasticTabBtn.classList.add('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass';
        });
        
        paperTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'block';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'none';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.add('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass';
        });
        
        metalTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'block';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'none';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.add('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass';
        });
        
        batteriesTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'block';
            glassPricesTable.style.display = 'none';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.add('active-tab');
            glassTabBtn.classList.remove('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
            glassTabBtn.innerHTML = 'Glass';
        });
        
        glassTabBtn.addEventListener('click', function() {
            plasticPricesTable.style.display = 'none';
            paperPricesTable.style.display = 'none';
            metalPricesTable.style.display = 'none';
            batteriesPricesTable.style.display = 'none';
            glassPricesTable.style.display = 'block';
            
            plasticTabBtn.classList.remove('active-tab');
            paperTabBtn.classList.remove('active-tab');
            metalTabBtn.classList.remove('active-tab');
            batteriesTabBtn.classList.remove('active-tab');
            glassTabBtn.classList.add('active-tab');
            
            // Add/remove indicator line
            plasticTabBtn.innerHTML = 'Plastic';
            paperTabBtn.innerHTML = 'Paper';
            metalTabBtn.innerHTML = 'Metal';
            batteriesTabBtn.innerHTML = 'Batteries';
            glassTabBtn.innerHTML = 'Glass <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 3px; background-color: var(--hoockers-green);"></span>';
        });
    </script>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content" style="max-width: 900px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="padding: 25px 30px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h2 class="modal-title" style="color: var(--hoockers-green); font-size: 28px; font-weight: 700; margin: 0;">Add New Product</h2>
                <span class="close" style="color: #666; font-size: 32px; font-weight: 300; cursor: pointer; transition: color 0.3s ease;">&times;</span>
            </div>
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-container" style="padding: 30px;">
                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <!-- Left Column -->
                        <div class="form-column">
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="title" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-tag" style="color: var(--hoockers-green);"></i> Product Title
                                </label>
                                <input type="text" name="title" id="title" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter product title..." required>
                                <div class="form-helper" style="margin-top: 8px; font-size: 13px; color: #666;">Give your product a descriptive title</div>
                                @error('title')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="category" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-grid" style="color: var(--hoockers-green);"></i> Category
                                </label>
                                <select name="category" id="category" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    required>
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
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="location" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-geo-alt" style="color: var(--hoockers-green);"></i> Location
                                </label>
                                <input type="text" name="location" id="location" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter location..." required>
                                @error('location')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="unit" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-rulers" style="color: var(--hoockers-green);"></i> Unit
                                </label>
                                <select name="unit" id="unit" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    required>
                                    <option value="">--Select Unit--</option>
                                    <option value="kg">Per Kilogram (kg)</option>
                                    <option value="g">Per Gram (g)</option>
                                    <option value="piece">Per Piece (pc)</option>
                                    <option value="box">Per Box (box)</option>
                                    <option value="pallet">Per Pallet (pallet)</option>
                                </select>
                                @error('unit')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="form-column">
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="quantity" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-box-seam" style="color: var(--hoockers-green);"></i> Quantity
                                </label>
                                <input type="number" name="quantity" id="quantity" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter quantity..." required>
                                @error('quantity')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="price" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-currency-peso" style="color: var(--hoockers-green);"></i> Price per unit
                                </label>
                                <input type="text" name="price" id="price" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    placeholder="Enter price..." required>
                                <button type="button" id="pricesGuideBtn" class="btn btn-link" 
                                    style="padding: 8px 12px; margin-top: 10px; color: white; background-color: var(--hoockers-green); display: inline-block; text-decoration: none; font-weight: 500; border-radius: 6px; width: auto; text-align: center; transition: all 0.3s ease;">
                                    <i class="bi bi-info-circle"></i> Prices Guide
                                </button>
                                @error('price')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="description" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-text-paragraph" style="color: var(--hoockers-green);"></i> Description
                                </label>
                                <textarea name="description" id="description" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; min-height: 120px; resize: vertical;"
                                    placeholder="Enter description..."></textarea>
                                @error('description')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="image" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-image" style="color: var(--hoockers-green);"></i> Photo
                                </label>
                                <div class="image-upload-container" style="border: 2px dashed #e0e0e0; border-radius: 10px; padding: 20px; text-align: center; transition: all 0.3s ease;">
                                    <input type="file" name="image" id="image" class="image-upload-input" 
                                        style="display: none;" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                                    <label for="image" class="image-upload-label" 
                                        style="cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                        <i class="bi bi-cloud-upload" style="font-size: 32px; color: var(--hoockers-green);"></i>
                                        <span style="font-size: 15px; color: #666;">Click to upload image</span>
                                        <small style="color: #999;">or drag and drop</small>
                                    </label>
                                    <div id="imagePreview" class="image-preview" style="margin-top: 15px;">
                                        <span class="placeholder-text" style="color: #999;">No image selected</span>
                                    </div>
                                </div>
                                @error('image')
                                    <p class="error-message" style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                        <button type="button" class="btn btn-secondary" 
                            style="padding: 12px 25px; border: none; border-radius: 8px; font-size: 15px; font-weight: 500; color: #666; background-color: #f5f5f5; cursor: pointer; transition: all 0.3s ease;"
                            onclick="document.querySelector('#addProductModal .close').click()">
                            <i class="bi bi-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" 
                            style="padding: 12px 25px; border: none; border-radius: 8px; font-size: 15px; font-weight: 500; color: white; background-color: var(--hoockers-green); cursor: pointer; transition: all 0.3s ease;">
                            <i class="bi bi-plus-circle"></i> Add Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image preview functionality
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" 
                            style="max-width: 100%; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    `;
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<span class="placeholder-text" style="color: #999;">No image selected</span>';
            }
        }

        // Form control focus effects
        document.querySelectorAll('.form-control.enhanced').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
        <!-- Add Leaflet CSS and JS dependencies -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

        <div class="modal-content" style="max-width: 900px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="padding: 25px 30px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h2 class="modal-title" style="color: var(--hoockers-green); font-size: 28px; font-weight: 700; margin: 0;">Edit Product</h2>
                <span class="close" style="color: #666; font-size: 32px; font-weight: 300; cursor: pointer; transition: color 0.3s ease;">&times;</span>
            </div>
            <form id="editProductForm" method="POST" action="{{ route('shop.products.update', ['id' => ':id']) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editProductId" name="id">
                <div class="form-container" style="padding: 30px;">
                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <!-- Left Column -->
                        <div class="form-column">
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="editTitle" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-tag" style="color: var(--hoockers-green);"></i> Product Title
                                </label>
                                <input type="text" id="editTitle" name="title" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    required>
                </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="editCategory" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-grid" style="color: var(--hoockers-green);"></i> Category
                                </label>
                                <select id="editCategory" name="category_id" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    required>
                        <option value="">--Select Category--</option>
                        @foreach(\App\Models\Category::where('is_active', true)->orderBy('name')->get() as $category)
                            <option value="{{ $category->id }}" 
                                data-color="{{ $category->color }}"
                                style="background-color: {{ $category->color }}20;">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="editLocation" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-geo-alt" style="color: var(--hoockers-green);"></i> Location
                                </label>
                                <div class="input-group" style="display: flex; gap: 10px;">
                                    <input type="text" id="editLocation" name="location" class="form-control enhanced" 
                                        style="flex: 1; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                        required>
                                    <button type="button" class="btn btn-outline-secondary" onclick="getCurrentLocationForEdit()"
                                        style="padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; background: white; color: var(--hoockers-green); transition: all 0.3s ease;">
                                        <i class="bi bi-geo-alt"></i>
                                    </button>
                </div>
                                <input type="hidden" id="editLatitude" name="latitude">
                                <input type="hidden" id="editLongitude" name="longitude">
                                <div id="editLocationMap" style="height: 300px; width: 100%; border-radius: 10px; border: 2px solid #e0e0e0; margin-top: 10px;"></div>
                                <small class="form-text text-muted" style="display: block; margin-top: 8px; color: #666;">
                                    Click on the map to set the product's location
                                </small>
                            </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="editUnit" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-rulers" style="color: var(--hoockers-green);"></i> Unit
                                </label>
                                <select id="editUnit" name="unit" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    required>
                        <option value="kg">Kilograms (kg)</option>
                        <option value="g">Grams (g)</option>
                        <option value="pcs">Pieces (pcs)</option>
                        <option value="box">Box</option>
                        <option value="sack">Sack</option>
                    </select>
                </div>
                </div>

                        <!-- Right Column -->
                        <div class="form-column">
                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="editQuantity" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-box-seam" style="color: var(--hoockers-green);"></i> Quantity
                                </label>
                                <input type="number" id="editQuantity" name="quantity" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    min="0" step="0.01" required>
                </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="editPrice" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-currency-peso" style="color: var(--hoockers-green);"></i> Price per unit
                                </label>
                                <input type="number" id="editPrice" name="price" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                    min="0" step="0.01" required>
                </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="editDescription" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-text-paragraph" style="color: var(--hoockers-green);"></i> Description
                                </label>
                                <textarea id="editDescription" name="description" class="form-control enhanced" 
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; min-height: 120px; resize: vertical;"
                                    required></textarea>
                    </div>

                            <div class="form-group" style="margin-bottom: 25px;">
                                <label class="form-label" for="editImage" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                    <i class="bi bi-image" style="color: var(--hoockers-green);"></i> Photo (leave blank to keep current image)
                                </label>
                                <div class="image-upload-container" style="border: 2px dashed #e0e0e0; border-radius: 10px; padding: 20px; text-align: center; transition: all 0.3s ease;">
                                    <input type="file" id="editImage" name="image" class="image-upload-input" 
                                        style="display: none;" accept="image/*" onchange="previewImage(this, 'editImagePreview')">
                                    <label for="editImage" class="image-upload-label" 
                                        style="cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                        <i class="bi bi-cloud-upload" style="font-size: 32px; color: var(--hoockers-green);"></i>
                                        <span style="font-size: 15px; color: #666;">Click to upload image</span>
                                        <small style="color: #999;">or drag and drop</small>
                                    </label>
                                    <div id="editImagePreview" class="image-preview" style="margin-top: 15px;">
                                        <span class="placeholder-text" style="color: #999;">No image selected</span>
                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                        <button type="button" class="btn btn-secondary" onclick="closeEditModal()"
                            style="padding: 12px 25px; border: none; border-radius: 8px; font-size: 15px; font-weight: 500; color: #666; background-color: #f5f5f5; cursor: pointer; transition: all 0.3s ease;">
                            <i class="bi bi-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary"
                            style="padding: 12px 25px; border: none; border-radius: 8px; font-size: 15px; font-weight: 500; color: white; background-color: var(--hoockers-green); cursor: pointer; transition: all 0.3s ease;">
                            <i class="bi bi-check2"></i> Update Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Global variables for edit product map
    let editMap = null;
    let editMarker = null;

    // Function to reverse geocode coordinates to address for edit modal
    function reverseGeocodeForEdit(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) {
                    document.getElementById('editLocation').value = data.display_name;
                    document.getElementById('editLatitude').value = lat;
                    document.getElementById('editLongitude').value = lng;
                }
            })
            .catch(error => {
                console.error('Error in reverse geocoding:', error);
            });
    }

    // Function to get current location for edit modal
    function getCurrentLocationForEdit() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    editMap.setView([lat, lng], 16);
                    editMarker.setLatLng([lat, lng]);
                    reverseGeocodeForEdit(lat, lng);
                },
                function(error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error: The Geolocation service failed. ' + error.message,
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                }
            );
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Error: Your browser doesn\'t support geolocation.',
                icon: 'error',
                confirmButtonColor: '#517A5B'
            });
        }
    }

    // Function to edit product
    function editProduct(id) {
        const editModal = document.getElementById('editProductModal');
        const button = document.querySelector(`[data-product-id="${id}"]`);
        
        if (!button) {
            Swal.fire({
                title: 'Error!',
                text: 'Could not find product data',
                icon: 'error',
                confirmButtonColor: '#517A5B'
            });
            return;
        }

        // Get data from button attributes
        const productData = {
            id: button.getAttribute('data-product-id'),
            title: button.getAttribute('data-product-title'),
            category_id: button.getAttribute('data-product-category-id'),
            location: button.getAttribute('data-product-location'),
            unit: button.getAttribute('data-product-unit'),
            quantity: button.getAttribute('data-product-quantity'),
            price: button.getAttribute('data-product-price'),
            description: button.getAttribute('data-product-description')
        };

        // Update form action URL with the product ID
        const form = document.getElementById('editProductForm');
        form.action = form.action.replace(':id', productData.id);

        // Populate form fields
        document.getElementById('editProductId').value = productData.id;
        document.getElementById('editTitle').value = productData.title;
        document.getElementById('editCategory').value = productData.category_id;
        document.getElementById('editLocation').value = productData.location;
        document.getElementById('editUnit').value = productData.unit;
        document.getElementById('editQuantity').value = productData.quantity;
        document.getElementById('editPrice').value = productData.price;
        document.getElementById('editDescription').value = productData.description;

        // Show the modal
        editModal.style.display = 'block';
        
        // Initialize map after a short delay to ensure the modal is fully visible
        setTimeout(() => {
            initEditMap();
            
            // If location exists, try to geocode it
            if (productData.location) {
                // Use the geocoder to find coordinates for the location
                const geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false
                });
                
                geocoder.options.geocoder.geocode(productData.location, function(results) {
                    if (results && results.length > 0) {
                        const latlng = results[0].center;
                        editMap.setView(latlng, 16);
                        editMarker.setLatLng(latlng);
                        document.getElementById('editLatitude').value = latlng.lat;
                        document.getElementById('editLongitude').value = latlng.lng;
                    }
                });
            }
        }, 300);
    }

    // Function to close edit modal
    function closeEditModal() {
        const editModal = document.getElementById('editProductModal');
        editModal.style.display = 'none';
        // Reset form
        document.getElementById('editProductForm').reset();
        document.getElementById('editImagePreview').innerHTML = '';
    }

    // Handle form submission
    document.getElementById('editProductForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Show loading state
        Swal.fire({
            title: 'Updating product...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Submit the form
        this.submit();
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        const editModal = document.getElementById('editProductModal');
        if (e.target === editModal) {
            closeEditModal();
        }
    });

    // Close modal when clicking the X button
    document.querySelector('#editProductModal .close').addEventListener('click', closeEditModal);

    // Image preview functionality
    document.getElementById('editImage').addEventListener('change', function(e) {
        const preview = document.getElementById('editImagePreview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" 
                        style="max-width: 100%; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                `;
            }
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });
    </script>

    <!-- Shop Settings Modal -->
    <div id="shopSettingsModal" class="modal">
        <div class="modal-content" style="max-width: 1000px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="padding: 25px 30px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h2 class="modal-title" style="color: var(--hoockers-green); font-size: 28px; font-weight: 700; margin: 0;">
                    <i class="bi bi-shop me-2"></i> Shop Settings
                </h2>
                <span class="close" style="color: #666; font-size: 32px; font-weight: 300; cursor: pointer; transition: color 0.3s ease;">&times;</span>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="shop-overview">
                    <div id="shopInfoView">
                        <div class="shop-header" style="background: linear-gradient(135deg, #517A5B 0%, #3a5c42 100%); padding: 30px; border-radius: 15px; color: white; margin-bottom: 30px;">
                            <h3 style="font-size: 24px; margin-bottom: 10px;">{{ $shop->shop_name }}</h3>
                            <p style="opacity: 0.9; margin-bottom: 0;">
                                <i class="bi bi-geo-alt me-2"></i>{{ $shop->shop_address }}
                            </p>
                        </div>
                        
                        <div class="shop-details" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px;">
                            <div class="detail-card" style="background: #f8f9fa; padding: 20px; border-radius: 12px; border: 1px solid #eee;">
                                <h4 style="color: var(--hoockers-green); font-size: 18px; margin-bottom: 15px;">
                                    <i class="bi bi-info-circle me-2"></i>Shop Information
                                </h4>
                                <p style="margin-bottom: 10px;">
                                    <strong>Description:</strong><br>
                                    {{ $shop->shop_description ?? 'No description provided' }}
                                </p>
                            </div>
                            
                            <div class="detail-card" style="background: #f8f9fa; padding: 20px; border-radius: 12px; border: 1px solid #eee;">
                                <h4 style="color: var(--hoockers-green); font-size: 18px; margin-bottom: 15px;">
                                    <i class="bi bi-telephone me-2"></i>Contact Details
                                </h4>
                                <p style="margin-bottom: 10px;">
                                    <strong>Contact Number:</strong><br>
                                    {{ $shop->contact_number ?? 'Not provided' }}
                                </p>
                                <p>
                                    <strong>Business Hours:</strong><br>
                                    {{ $shop->business_hours ?? 'Not specified' }}
                                </p>
                            </div>
                        </div>

                        <div class="form-actions" style="margin-top: 20px; text-align: right;">
                            <button type="button" class="btn btn-primary" onclick="toggleEditMode(true)" 
                                style="background: var(--hoockers-green); border: none; padding: 12px 25px; border-radius: 8px; color: white; font-weight: 500; transition: all 0.3s ease;">
                                <i class="bi bi-pencil me-2"></i> Edit Shop Details
                            </button>
                        </div>
                    </div>

                    <form id="updateShopForm" action="{{ route('shop.update') }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                            <div class="form-column">
                                <div class="form-group" style="margin-bottom: 25px;">
                                    <label class="form-label" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                        <i class="bi bi-shop" style="color: var(--hoockers-green);"></i> Shop Name
                                    </label>
                                    <input type="text" name="shop_name" class="form-control enhanced" 
                                        style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                        value="{{ $shop->shop_name }}" required>
                                </div>

                                <div class="form-group" style="margin-bottom: 25px;">
                                    <label class="form-label" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                        <i class="bi bi-geo-alt" style="color: var(--hoockers-green);"></i> Shop Address
                                    </label>
                                    <div class="input-group" style="display: flex; gap: 10px;">
                                        <input type="text" id="shop_address" name="shop_address" class="form-control enhanced" 
                                            style="flex: 1; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                            value="{{ $shop->shop_address }}" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="getCurrentLocation()"
                                            style="padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; background: white; color: var(--hoockers-green); transition: all 0.3s ease;">
                                            <i class="bi bi-geo-alt"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" id="latitude" name="latitude" value="{{ $shop->latitude }}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{ $shop->longitude }}">
                                </div>

                                <div class="form-group" style="margin-bottom: 25px;">
                                    <label class="form-label" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                        <i class="bi bi-map" style="color: var(--hoockers-green);"></i> Location Map
                                    </label>
                                    <div id="map" style="height: 300px; width: 100%; border-radius: 10px; border: 2px solid #e0e0e0;"></div>
                                    <small class="form-text text-muted" style="display: block; margin-top: 8px; color: #666;">
                                        Click on the map to set your shop's location
                                    </small>
                                </div>
                            </div>

                            <div class="form-column">
                                <div class="form-group" style="margin-bottom: 25px;">
                                    <label class="form-label" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                        <i class="bi bi-text-paragraph" style="color: var(--hoockers-green);"></i> Shop Description
                                    </label>
                                    <textarea name="shop_description" class="form-control enhanced" 
                                        style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; min-height: 120px; resize: vertical;"
                                        rows="3">{{ $shop->shop_description }}</textarea>
                                </div>

                                <div class="form-group" style="margin-bottom: 25px;">
                                    <label class="form-label" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                        <i class="bi bi-telephone" style="color: var(--hoockers-green);"></i> Contact Information
                                    </label>
                                    <input type="text" name="contact_number" class="form-control enhanced" 
                                        style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                        value="{{ $shop->contact_number }}" placeholder="Enter contact number">
                                </div>

                                <div class="form-group" style="margin-bottom: 25px;">
                                    <label class="form-label" style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                        <i class="bi bi-clock" style="color: var(--hoockers-green);"></i> Business Hours
                                    </label>
                                    <input type="text" name="business_hours" class="form-control enhanced" 
                                        style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                        value="{{ $shop->business_hours }}" placeholder="e.g., Mon-Fri: 9AM-6PM">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; display: flex; justify-content: flex-end; gap: 15px;">
                            <button type="button" class="btn btn-secondary" onclick="toggleEditMode(false)"
                                style="padding: 12px 25px; border: none; border-radius: 8px; font-size: 15px; font-weight: 500; color: #666; background-color: #f5f5f5; cursor: pointer; transition: all 0.3s ease;">
                                <i class="bi bi-x me-2"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary"
                                style="padding: 12px 25px; border: none; border-radius: 8px; font-size: 15px; font-weight: 500; color: white; background-color: var(--hoockers-green); cursor: pointer; transition: all 0.3s ease;">
                                <i class="bi bi-check2 me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Shop Settings Modal Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const shopSettingsModal = document.getElementById('shopSettingsModal');
            const shopSettingsBtn = document.getElementById('shopSettingsBtn');
            const shopSettingsCloseBtn = shopSettingsModal.querySelector('.close');
            const updateShopForm = document.getElementById('updateShopForm');
            const shopInfoView = document.getElementById('shopInfoView');
            let map, marker;

            // Function to toggle between view and edit modes
            window.toggleEditMode = function(showEdit) {
                const shopInfoView = document.getElementById('shopInfoView');
                const updateShopForm = document.getElementById('updateShopForm');
                
                if (showEdit) {
                    shopInfoView.style.display = 'none';
                    updateShopForm.style.display = 'block';
                    // Reinitialize map when switching to edit mode
                    initMap();
                } else {
                    shopInfoView.style.display = 'block';
                    updateShopForm.style.display = 'none';
                }
            };

            // Handle shop settings form submission
            updateShopForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading state
                Swal.fire({
                    title: 'Updating Shop Settings...',
                    html: 'Please wait while we save your changes.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Create form data object from the form
                const formData = new FormData(updateShopForm);
                
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
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'An error occurred while updating shop settings. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545',
                        customClass: {
                            popup: 'bigger-modal'
                        }
                    });
                });
            });

            // Initialize map when modal is opened
            shopSettingsBtn.addEventListener('click', function(e) {
                e.preventDefault();
                shopSettingsModal.style.display = 'block';
                initMap();
            });

            // Initialize map
            function initMap() {
                if (map) {
                    map.invalidateSize();
                    return;
                }

                // Default to Zamboanga City coordinates
                let initialLat = {{ $shop->latitude ?? 6.9214 }};
                let initialLng = {{ $shop->longitude ?? 122.0790 }};
                let initialZoom = 13;

                // Initialize the map
                map = L.map('map').setView([initialLat, initialLng], initialZoom);

                // Add OpenStreetMap tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Initialize marker
                marker = L.marker([initialLat, initialLng], {
                    draggable: true
                }).addTo(map);

                // Update location when marker is dragged
                marker.on('dragend', function(event) {
                    const position = marker.getLatLng();
                    reverseGeocode(position.lat, position.lng);
                });

                // Add click event to map for positioning marker
                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    reverseGeocode(e.latlng.lat, e.latlng.lng);
                });

                // Initialize the geocoder control
                L.Control.geocoder({
                    defaultMarkGeocode: false
                }).on('markgeocode', function(e) {
                    const latlng = e.geocode.center;
                    marker.setLatLng(latlng);
                    map.setView(latlng, 16);
                    reverseGeocode(latlng.lat, latlng.lng);
                }).addTo(map);
            }

            // Reverse geocode coordinates to address
            function reverseGeocode(lat, lng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            document.getElementById('shop_address').value = data.display_name;
                            document.getElementById('latitude').value = lat;
                            document.getElementById('longitude').value = lng;
                        }
                    })
                    .catch(error => {
                        console.error('Error in reverse geocoding:', error);
                    });
            }

            // Get current location
            window.getCurrentLocation = function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            map.setView([lat, lng], 16);
                            marker.setLatLng([lat, lng]);
                            reverseGeocode(lat, lng);
                        },
                        function(error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Error: The Geolocation service failed. ' + error.message,
                                icon: 'error',
                                confirmButtonColor: '#517A5B'
                            });
                        }
                    );
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error: Your browser doesn\'t support geolocation.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                }
            };

            // Clean up when modal is closed
            shopSettingsCloseBtn.addEventListener('click', function() {
                shopSettingsModal.style.display = 'none';
            });

            // Clean up when clicking outside modal
            window.addEventListener('click', function(e) {
                if (e.target === shopSettingsModal) {
                    shopSettingsModal.style.display = 'none';
                }
            });
        });

        // Initialize map for editing
        function initEditMap() {
            if (editMap) {
                editMap.invalidateSize();
                return;
            }

            // Default to Zamboanga City coordinates
            let initialLat = 6.9214;
            let initialLng = 122.0790;
            let initialZoom = 13;

            // Initialize the map
            editMap = L.map('editLocationMap', {
                center: [initialLat, initialLng],
                zoom: initialZoom,
                zoomControl: true
            });

            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(editMap);

            // Initialize marker
            editMarker = L.marker([initialLat, initialLng], {
                draggable: true
            }).addTo(editMap);

            // Update location when marker is dragged
            editMarker.on('dragend', function(event) {
                const position = editMarker.getLatLng();
                reverseGeocodeForEdit(position.lat, position.lng);
            });

            // Add click event to map for positioning marker
            editMap.on('click', function(e) {
                editMarker.setLatLng(e.latlng);
                reverseGeocodeForEdit(e.latlng.lat, e.latlng.lng);
            });

            // Initialize the geocoder control
            const geocoder = L.Control.geocoder({
                defaultMarkGeocode: false,
                placeholder: 'Search for a location...',
                errorMessage: 'Nothing found.'
            }).on('markgeocode', function(e) {
                const latlng = e.geocode.center;
                editMarker.setLatLng(latlng);
                editMap.setView(latlng, 16);
                reverseGeocodeForEdit(latlng.lat, latlng.lng);
            }).addTo(editMap);

            // Force a resize event after a short delay to ensure proper rendering
            setTimeout(() => {
                editMap.invalidateSize();
            }, 100);
        }
    </script>

    <!-- Earnings Modal -->
    <div id="earningsModal" class="modal">
        <div class="modal-content" style="max-width: 1000px;">
            <div class="modal-header">
                <h2 class="modal-title">Earnings Overview</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Earnings Summary Cards -->
                <div class="earnings-summary-grid">
                    <div class="earnings-summary-card total-earnings" id="totalEarningsCard" style="cursor: pointer;">
                        <div class="card-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="card-content">
                            <h3>Total Earnings</h3>
                            <p class="amount" id="totalEarningsAmount">
                                @php
                                    try {
                                        $totalEarnings = \App\Models\Order::where('seller_id', Auth::id())
                                                    ->where('status', 'completed')
                                                    ->sum('total_amount');
                                        echo '₱' . number_format($totalEarnings ?? 0, 2);
                                    } catch (\Exception $e) {
                                        echo '₱0.00';
                                    }
                                @endphp
                            </p>
                            <span class="label">Before commission</span>
                        </div>
                    </div>
                    
                    <div class="earnings-summary-card net-earnings">
                        <div class="card-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="card-content">
                            <h3>Net Earnings</h3>
                            <p class="amount" id="netEarningsAmount">
                                @php
                                    try {
                                        $totalEarnings = \App\Models\Order::where('seller_id', Auth::id())
                                                    ->where('status', 'completed')
                                                    ->sum('total_amount');
                                        $netEarnings = $totalEarnings * 0.9;
                                        echo '₱' . number_format($netEarnings ?? 0, 2);
                                    } catch (\Exception $e) {
                                        echo '₱0.00';
                                    }
                                @endphp
                            </p>
                            <span class="label">After 10% commission</span>
                        </div>
                    </div>
                    
                    <div class="earnings-summary-card commission-paid">
                        <div class="card-icon">
                            <i class="bi bi-percent"></i>
                        </div>
                        <div class="card-content">
                            <h3>Commission Paid</h3>
                            <p class="amount" id="commissionAmount">
                                @php
                                    try {
                                        $totalEarnings = \App\Models\Order::where('seller_id', Auth::id())
                                                    ->where('status', 'completed')
                                                    ->sum('total_amount');
                                        $commission = $totalEarnings * 0.1;
                                        echo '₱' . number_format($commission ?? 0, 2);
                                    } catch (\Exception $e) {
                                        echo '₱0.00';
                                    }
                                @endphp
                            </p>
                            <span class="label">10% of total earnings</span>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div style="margin: 30px 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3>Earnings Trend</h3>
                        <select id="chartPeriod" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                            <option value="7d">Last 7 Days</option>
                            <option value="30d" selected>Last 30 Days</option>
                            <option value="90d">Last 90 Days</option>
                            <option value="1y">Last Year</option>
                        </select>
                    </div>
                    <div style="position: relative; height: 400px; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <canvas id="earningsChart"></canvas>
                    </div>
                </div>

                <!-- Recent Earnings Table -->
                <div class="recent-earnings">
                    <h3>Recent Earnings</h3>
                    <div class="table-responsive">
                        <table class="earnings-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Commission</th>
                                    <th>Net Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $recentOrders = \App\Models\Order::where('seller_id', Auth::id())
                                        ->where('status', 'completed')
                                        ->latest()
                                        ->take(5)
                                        ->get();
                                @endphp
                                
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>#{{ $order->id }}</td>
                                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                        <td>₱{{ number_format($order->total_amount * 0.1, 2) }}</td>
                                        <td>₱{{ number_format($order->total_amount * 0.9, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No recent earnings</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ... existing script code ...

        // Earnings Modal Functionality
        const earningsModal = document.getElementById('earningsModal');
        const earningsStatCard = document.getElementById('earningsStatCard');
        const earningsCloseBtn = earningsModal.querySelector('.close');
        let earningsChart = null;

        // Open earnings modal when earnings card is clicked
        earningsStatCard.addEventListener('click', function() {
            earningsModal.style.display = 'block';
            initEarningsChart();
        });

        // Close earnings modal when X is clicked
        earningsCloseBtn.addEventListener('click', function() {
            earningsModal.style.display = 'none';
            if (earningsChart) {
                earningsChart.destroy();
                earningsChart = null;
            }
        });

        // Close earnings modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === earningsModal) {
                earningsModal.style.display = 'none';
                if (earningsChart) {
                    earningsChart.destroy();
                    earningsChart = null;
                }
            }
        });

        // Period selector change handler
        document.getElementById('chartPeriod').addEventListener('change', function() {
            loadEarningsData(this.value);
        });

        // Initialize earnings chart
        function initEarningsChart() {
            const ctx = document.getElementById('earningsChart').getContext('2d');
            
            earningsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Total Earnings',
                            data: [],
                            borderColor: '#517A5B',
                            backgroundColor: 'rgba(81, 122, 91, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Net Earnings',
                            data: [],
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4
                        },
                        {
                            label: 'Commission',
                            data: [],
                            borderColor: '#dc2626',
                            backgroundColor: 'rgba(220, 38, 38, 0.1)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Earnings Overview',
                            font: { size: 16, weight: 'bold' }
                        },
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ₱' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Amount (₱)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toFixed(2);
                                }
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                }
            });

            // Load initial data
            loadEarningsData('30d');
        }

        // Load earnings data from API
        function loadEarningsData(period = '30d') {
            console.log('Loading earnings data for period:', period);
            
            fetch(`/shop/earnings-chart?period=${period}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('API Response Status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Earnings API Response:', data);
                
                if (data.success && data.data) {
                    updateChart(data.data);
                    updateSummaryCards(data.summary);
                } else {
                    console.error('API returned error:', data.message);
                    // Use fallback data if API fails
                    generateFallbackData(period);
                }
            })
            .catch(error => {
                console.error('Error loading earnings data:', error);
                // Use fallback data if fetch fails
                generateFallbackData(period);
            });
        }

        // Update chart with new data
        function updateChart(chartData) {
            if (!earningsChart) return;

            const labels = chartData.map(item => {
                const date = new Date(item.date);
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            });

            const totalEarnings = chartData.map(item => item.totalEarnings);
            const netEarnings = chartData.map(item => item.netEarnings);
            const commission = chartData.map(item => item.commission);

            earningsChart.data.labels = labels;
            earningsChart.data.datasets[0].data = totalEarnings;
            earningsChart.data.datasets[1].data = netEarnings;
            earningsChart.data.datasets[2].data = commission;
            
            earningsChart.update();
            console.log('Chart updated with data:', { labels, totalEarnings, netEarnings, commission });
        }

        // Update summary cards
        function updateSummaryCards(summary) {
            if (summary) {
                document.getElementById('totalEarningsAmount').textContent = '₱' + summary.totalEarnings.toFixed(2);
                document.getElementById('netEarningsAmount').textContent = '₱' + summary.netEarnings.toFixed(2);
                document.getElementById('commissionAmount').textContent = '₱' + summary.commission.toFixed(2);
            }
        }

        // Generate fallback data for testing
        function generateFallbackData(period) {
            console.log('Generating fallback data for period:', period);
            
            const days = period === '7d' ? 7 : period === '30d' ? 30 : period === '90d' ? 90 : 365;
            const fallbackData = [];
            
            for (let i = days - 1; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                
                // Generate random earnings data for demonstration
                const totalEarnings = Math.random() * 1000 + 100;
                const commission = totalEarnings * 0.1;
                const netEarnings = totalEarnings - commission;
                
                fallbackData.push({
                    date: date.toISOString().split('T')[0],
                    totalEarnings: totalEarnings,
                    netEarnings: netEarnings,
                    commission: commission,
                    orderCount: Math.floor(Math.random() * 10) + 1
                });
            }
            
            console.log('Generated fallback data:', fallbackData);
            updateChart(fallbackData);
            
            // Update summary with fallback totals
            const summary = {
                totalEarnings: fallbackData.reduce((sum, item) => sum + item.totalEarnings, 0),
                netEarnings: fallbackData.reduce((sum, item) => sum + item.netEarnings, 0),
                commission: fallbackData.reduce((sum, item) => sum + item.commission, 0),
                totalOrders: fallbackData.reduce((sum, item) => sum + item.orderCount, 0)
            };
            updateSummaryCards(summary);
        }

        // ... rest of the existing script code ...
    </script>

    <!-- Detailed Earnings Breakdown Modal -->
    <div id="earningsBreakdownModal" class="modal">
        <div class="modal-content" style="max-width: 1000px;">
            <div class="modal-header">
                <h2 class="modal-title">Detailed Earnings Breakdown</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Summary Stats -->
                <div class="breakdown-summary">
                    <div class="summary-stat">
                        <h4>Total Orders</h4>
                        <p class="stat-value">
                            @php
                                $totalOrders = \App\Models\Order::where('seller_id', Auth::id())
                                    ->where('status', 'completed')
                                    ->count();
                                echo $totalOrders;
                            @endphp
                        </p>
                    </div>
                    <div class="summary-stat">
                        <h4>Average Order Value</h4>
                        <p class="stat-value">
                            @php
                                $avgOrderValue = $totalOrders > 0 ? $totalEarnings / $totalOrders : 0;
                                echo '₱' . number_format($avgOrderValue, 2);
                            @endphp
                        </p>
                    </div>
                    <div class="summary-stat">
                        <h4>Highest Value Order</h4>
                        <p class="stat-value">
                            @php
                                $highestOrder = \App\Models\Order::where('seller_id', Auth::id())
                                    ->where('status', 'completed')
                                    ->orderBy('total_amount', 'desc')
                                    ->first();
                                echo $highestOrder ? '₱' . number_format($highestOrder->total_amount, 2) : '₱0.00';
                            @endphp
                        </p>
                    </div>
                </div>

                <!-- Earnings Timeline -->
                <div class="earnings-timeline">
                    <h3>Earnings Timeline</h3>
                    <div class="timeline-container">
                        @php
                            $orders = \App\Models\Order::where('seller_id', Auth::id())
                                ->where('status', 'completed')
                                ->with(['items.post', 'buyer'])
                                ->latest()
                                ->get();
                        @endphp

                        @forelse($orders as $order)
                            <div class="timeline-item">
                                <div class="timeline-date">
                                    <span class="date">{{ $order->created_at->format('M d, Y') }}</span>
                                    <span class="time">{{ $order->created_at->format('h:i A') }}</span>
                                </div>
                                <div class="timeline-content">
                                    <div class="order-header">
                                        <h4>Order #{{ $order->id }}</h4>
                                        <span class="order-amount">₱{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                    <div class="order-details">
                                        <div class="customer-info">
                                            <i class="bi bi-person"></i>
                                            <span>{{ $order->buyer->firstname }} {{ $order->buyer->lastname }}</span>
                                        </div>
                                        <div class="products-list">
                                            @foreach($order->items as $item)
                                                <div class="product-item">
                                                    <img src="{{ asset('storage/' . $item->post->image) }}" 
                                                         alt="{{ $item->post->title }}"
                                                         onerror="this.src='https://placehold.co/100x100?text=Product'">
                                                    <div class="product-info">
                                                        <span class="product-name">{{ $item->post->title }}</span>
                                                        <span class="product-quantity">x{{ $item->quantity }}</span>
                                                        <span class="product-price">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="order-summary">
                                            <div class="summary-row">
                                                <span>Subtotal</span>
                                                <span>₱{{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                            <div class="summary-row">
                                                <span>Commission (10%)</span>
                                                <span>₱{{ number_format($order->total_amount * 0.1, 2) }}</span>
                                            </div>
                                            <div class="summary-row total">
                                                <span>Net Earnings</span>
                                                <span>₱{{ number_format($order->total_amount * 0.9, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-orders">
                                <i class="bi bi-inbox"></i>
                                <p>No completed orders yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ... existing styles ... */

        /* Detailed Earnings Breakdown Styles */
        .breakdown-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-stat {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .summary-stat h4 {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .summary-stat .stat-value {
            margin: 10px 0 0;
            font-size: 24px;
            font-weight: bold;
            color: #517A5B;
        }

        .earnings-timeline {
            background: white;
            border-radius: 15px;
            padding: 20px;
        }

        .earnings-timeline h3 {
            margin: 0 0 20px;
            color: #333;
        }

        .timeline-container {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .timeline-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .timeline-item:last-child {
            border-bottom: none;
        }

        .timeline-date {
            min-width: 100px;
            text-align: right;
        }

        .timeline-date .date {
            display: block;
            font-weight: 600;
            color: #333;
        }

        .timeline-date .time {
            display: block;
            font-size: 12px;
            color: #666;
        }

        .timeline-content {
            flex: 1;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .order-header h4 {
            margin: 0;
            color: #333;
        }

        .order-amount {
            font-weight: 600;
            color: #517A5B;
        }

        .order-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }

        .customer-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
            color: #666;
        }

        .products-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .product-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px;
            background: white;
            border-radius: 8px;
        }

        .product-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }

        .product-info {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-name {
            font-weight: 500;
            color: #333;
        }

        .product-quantity {
            color: #666;
        }

        .product-price {
            font-weight: 600;
            color: #517A5B;
        }

        .order-summary {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            color: #666;
        }

        .summary-row.total {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-weight: 600;
            color: #333;
        }

        .no-orders {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .no-orders i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #ccc;
        }

        /* Scrollbar Styling */
        .timeline-container::-webkit-scrollbar {
            width: 8px;
        }

        .timeline-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .timeline-container::-webkit-scrollbar-thumb {
            background: #517A5B;
            border-radius: 4px;
        }

        .timeline-container::-webkit-scrollbar-thumb:hover {
            background: #3a5c42;
        }
    </style>

    <script>
        // ... existing script code ...

        // Detailed Earnings Breakdown Modal Functionality
        const earningsBreakdownModal = document.getElementById('earningsBreakdownModal');
        const totalEarningsCard = document.getElementById('totalEarningsCard');
        const earningsBreakdownCloseBtn = earningsBreakdownModal.querySelector('.close');

        // Open detailed earnings modal when total earnings card is clicked
        totalEarningsCard.addEventListener('click', function() {
            earningsBreakdownModal.style.display = 'block';
        });

        // Close detailed earnings modal when X is clicked
        earningsBreakdownCloseBtn.addEventListener('click', function() {
            earningsBreakdownModal.style.display = 'none';
        });

        // Close detailed earnings modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === earningsBreakdownModal) {
                earningsBreakdownModal.style.display = 'none';
            }
        });

        // ... rest of the existing script code ...
    </script>

    <!-- Orders Management Modal -->
    <div id="ordersModal" class="modal">
        <div class="modal-content" style="max-width: 1000px;">
            <div class="modal-header">
                <h2 class="modal-title">Orders Management</h2>
                <div class="export-actions">
                    <button class="export-btn" onclick="exportOrders('pdf')">
                        <i class="bi bi-file-pdf"></i> Export PDF
                    </button>
                    <button class="export-btn" onclick="exportOrders('csv')">
                        <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                    </button>
                    <button class="export-btn" onclick="exportOrders('doc')">
                        <i class="bi bi-file-word"></i> Export DOC
                    </button>
                </div>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Orders Summary Stats -->
                <div class="breakdown-summary">
                    <div class="summary-stat">
                        <h4>Total Orders</h4>
                        <p class="stat-value">
                            @php
                                $totalOrders = \App\Models\Order::where('seller_id', Auth::id())->count();
                                echo $totalOrders;
                            @endphp
                        </p>
                    </div>
                    <div class="summary-stat">
                        <h4>Pending Orders</h4>
                        <p class="stat-value">
                            @php
                                $pendingOrders = \App\Models\Order::where('seller_id', Auth::id())
                                    ->where('status', 'pending')
                                    ->count();
                                echo $pendingOrders;
                            @endphp
                        </p>
                    </div>
                    <div class="summary-stat">
                        <h4>Completed Orders</h4>
                        <p class="stat-value">
                            @php
                                $completedOrders = \App\Models\Order::where('seller_id', Auth::id())
                                    ->where('status', 'completed')
                                    ->count();
                                echo $completedOrders;
                            @endphp
                        </p>
                    </div>
                </div>

                <!-- Orders Timeline -->
                <div class="orders-timeline">
                    <h3>Recent Orders</h3>
                    <div class="timeline-container">
                        @php
                            $orders = \App\Models\Order::where('seller_id', Auth::id())
                                ->with(['items.post', 'buyer'])
                                ->latest()
                                ->get();
                        @endphp

                        @forelse($orders as $order)
                            <div class="timeline-item">
                                <div class="timeline-date">
                                    <span class="date">{{ $order->created_at->format('M d, Y') }}</span>
                                    <span class="time">{{ $order->created_at->format('h:i A') }}</span>
                                </div>
                                <div class="timeline-content">
                                    <div class="order-header">
                                        <h4>Order #{{ $order->id }}</h4>
                                        <span class="order-status status-{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="order-details">
                                        <div class="customer-info">
                                            <i class="bi bi-person"></i>
                                            <span>{{ $order->buyer->firstname }} {{ $order->buyer->lastname }}</span>
                                        </div>
                                        @if($order->status === 'cancelled' && $order->cancellation_reason)
                                            <div class="cancellation-info" style="background: #fff3f3; padding: 10px; border-radius: 5px; margin: 10px 0; border-left: 3px solid #dc3545;">
                                                <i class="bi bi-info-circle" style="color: #dc3545;"></i>
                                                <span style="margin-left: 5px; color: #721c24;">
                                                    <strong>Cancellation Reason:</strong> 
                                                    @if(in_array($order->cancellation_reason, ['no_longer_want', 'wrong_order', 'found_better']))
                                                        @switch($order->cancellation_reason)
                                                            @case('no_longer_want')
                                                                I don't want to buy anymore
                                                                @break
                                                            @case('wrong_order')
                                                                I made a mistake in ordering
                                                                @break
                                                            @case('found_better')
                                                                Found a better deal elsewhere
                                                                @break
                                                        @endswitch
                                                    @else
                                                        {{ $order->cancellation_reason }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                        <div class="products-list">
                                            @foreach($order->items as $item)
                                                <div class="product-item">
                                                    <img src="{{ asset('storage/' . $item->post->image) }}" 
                                                         alt="{{ $item->post->title }}"
                                                         onerror="this.src='https://placehold.co/100x100?text=Product'">
                                                    <div class="product-info">
                                                        <span class="product-name">{{ $item->post->title }}</span>
                                                        <span class="product-quantity">x{{ $item->quantity }}</span>
                                                        <span class="product-price">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="order-summary">
                                            <div class="summary-row">
                                                <span>Subtotal</span>
                                                <span>₱{{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                            <div class="summary-row">
                                                <span>Commission (10%)</span>
                                                <span>₱{{ number_format($order->total_amount * 0.1, 2) }}</span>
                                            </div>
                                            <div class="summary-row total">
                                                <span>Net Amount</span>
                                                <span>₱{{ number_format($order->total_amount * 0.9, 2) }}</span>
                                            </div>
                                        </div>
                                        <!-- @if($order->status === 'pending')
                                            <div class="order-actions" style="margin-top: 15px; display: flex; gap: 10px;">
                                                <button class="action-btn accept-btn" onclick="updateOrderStatus({{ $order->id }}, 'completed')">
                                                    <i class="bi bi-check-circle"></i> Accept Order
                                                </button>
                                                <button class="action-btn reject-btn" onclick="updateOrderStatus({{ $order->id }}, 'cancelled')">
                                                    <i class="bi bi-x-circle"></i> Reject Order
                                                </button>
                                            </div>
                                        @endif -->
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-orders">
                                <i class="bi bi-inbox"></i>
                                <p>No orders yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ... existing styles ... */

        /* Orders Management Modal Styles */
        .order-status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .order-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .accept-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .reject-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .accept-btn:hover {
            background-color: #218838;
        }

        .reject-btn:hover {
            background-color: #c82333;
        }

        /* Export Button Styles */
        .export-actions {
            display: flex;
            gap: 10px;
            margin-right: 20px;
        }

        .export-btn {
            background-color: #517A5B;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9em;
        }

        .export-btn:hover {
            background-color: #446749;
        }

        /* Delete Button Styles */
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>

    <script>
        // ... existing script ...

        // Orders Modal Functionality
        const ordersModal = document.getElementById('ordersModal');
        const ordersStatCard = document.getElementById('ordersStatCard');
        const ordersCloseBtn = ordersModal.querySelector('.close');

        ordersStatCard.addEventListener('click', function() {
            ordersModal.style.display = 'block';
        });

        ordersCloseBtn.addEventListener('click', function() {
            ordersModal.style.display = 'none';
        });

        window.addEventListener('click', function(e) {
            if (e.target === ordersModal) {
                ordersModal.style.display = 'none';
            }
        });

        // Function to update order status
        function updateOrderStatus(orderId, status) {
            Swal.fire({
                title: 'Update Order Status',
                text: `Are you sure you want to ${status === 'completed' ? 'accept' : 'reject'} this order?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#517A5B',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to update order status
                    fetch(`/orders/${orderId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ status: status })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // If the order status is set to completed, update the earnings display
                            if (status === 'completed' && data.orderAmount) {
                                updateEarningsCard(data.orderAmount);
                            }

                            Swal.fire({
                                title: 'Success!',
                                text: `Order has been ${status === 'completed' ? 'accepted' : 'rejected'}`,
                                icon: 'success',
                                confirmButtonColor: '#517A5B'
                            }).then(() => {
                                // Reload the page to show updated status
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Failed to update order status',
                                icon: 'error',
                                confirmButtonColor: '#517A5B'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while updating the order status',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
                        });
                    });
                }
            });
        }

        // Update All Products button to use existing products modal
        document.getElementById('allProductsBtn').addEventListener('click', function() {
            const productsModal = document.getElementById('productsModal');
            if (productsModal) {
                productsModal.style.display = 'block';
                loadProducts(); // This function is already defined in item.blade.php
            }
        });

        // Export Orders Function
        function exportOrders(format) {
            Swal.fire({
                title: 'Preparing Export',
                text: 'Please wait while we prepare your file...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Get the current filter values
            const status = document.getElementById('orderStatusFilter').value;
            const search = document.getElementById('orderSearchInput').value;

            // Construct the URL with filters
            const url = `/orders/export/${format}?status=${status}&search=${search}`;

            // Create a temporary link element
            const link = document.createElement('a');
            link.href = url;
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Show success message
            Swal.fire({
                title: 'Export Started',
                text: 'Your file download should begin shortly.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }

        // Add delete product function to inventory management
        function deleteProduct(productId) {
            Swal.fire({
                title: 'Delete Product',
                text: 'Are you sure you want to delete this product? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit for DELETE request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('posts.destroy', '') }}/${productId}`;
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
        }

        // Modify the updateInventoryTable function to include delete button
        function updateInventoryTable(products) {
            inventoryTableBody.innerHTML = '';
            selectedItems.clear();
            updateSelectedItemsCount();

            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="padding: 12px; text-align: center;">
                        <input type="checkbox" class="product-checkbox" data-id="${product.id}">
                    </td>
                    <td style="padding: 12px;">${product.title}</td>
                    <td style="padding: 12px;">${product.category_name}</td>
                    <td style="padding: 12px; text-align: center;">
                        <span class="stock-indicator ${getStockClass(product.quantity)}">
                            ${product.quantity}
                        </span>
                    </td>
                    <td style="padding: 12px; text-align: right;">₱${product.price}</td>
                    <td style="padding: 12px; text-align: center;">
                        <button class="inventory-action-btn edit-btn" 
                            onclick="editProduct(${product.id})"
                            data-product-id="${product.id}"
                            data-product-title="${product.title}"
                            data-product-category-id="${product.category_id}"
                            data-product-category="${product.category_name}"
                            data-product-location="${product.location}"
                            data-product-unit="${product.unit}"
                            data-product-quantity="${product.quantity}"
                            data-product-price="${product.price}"
                            data-product-description="${product.description}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="inventory-action-btn" onclick="viewHistory(${product.id})">
                            <i class="bi bi-clock-history"></i>
                        </button>
                        <button class="inventory-action-btn delete-btn" onclick="deleteProduct(${product.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                inventoryTableBody.appendChild(row);
            });

            // Add event listeners to checkboxes
            document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', (e) => {
                    const productId = e.target.dataset.id;
                    if (e.target.checked) {
                        selectedItems.add(productId);
                    } else {
                        selectedItems.delete(productId);
                    }
                    updateSelectedItemsCount();
                });
            });
        }
    </script>

    <!-- Orders Management Modal -->
    <div id="ordersManagementModal" class="modal">
        <div class="modal-content" style="max-width: 1000px;">
            <div class="modal-header">
                <h2 class="modal-title">Orders Management</h2>
                <div class="export-actions">
                    <button class="export-btn" onclick="exportOrders('pdf')">
                        <i class="bi bi-file-pdf"></i> Export PDF
                    </button>
                    <button class="export-btn" onclick="exportOrders('csv')">
                        <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                    </button>
                    <button class="export-btn" onclick="exportOrders('doc')">
                        <i class="bi bi-file-word"></i> Export DOC
                    </button>
                </div>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Orders Summary Stats -->
                <div class="breakdown-summary">
                    <div class="summary-stat">
                        <h4>Total Orders</h4>
                        <p class="stat-value">
                            @php
                                $totalOrders = \App\Models\Order::where('seller_id', Auth::id())->count();
                                echo $totalOrders;
                            @endphp
                        </p>
                    </div>
                    <div class="summary-stat">
                        <h4>Pending Orders</h4>
                        <p class="stat-value">
                            @php
                                $pendingOrders = \App\Models\Order::where('seller_id', Auth::id())
                                    ->where('status', 'pending')
                                    ->count();
                                echo $pendingOrders;
                            @endphp
                        </p>
                    </div>
                    <div class="summary-stat">
                        <h4>Completed Orders</h4>
                        <p class="stat-value">
                            @php
                                $completedOrders = \App\Models\Order::where('seller_id', Auth::id())
                                    ->where('status', 'completed')
                                    ->count();
                                echo $completedOrders;
                            @endphp
                        </p>
                    </div>
                </div>

                <!-- Orders Timeline -->
                <div class="orders-timeline">
                    <h3>Recent Orders</h3>
                    <div class="orders-list">
                        @forelse(\App\Models\Order::where('seller_id', Auth::id())->with(['buyer', 'items.post', 'deliveryDetail.deliveryMethod'])->latest()->get() as $order)
                            <div class="order-card">
                                <div class="order-header">
                                    <div class="order-info">
                                        <h4>Order #{{ $order->id }}</h4>
                                        <div class="order-meta">
                                            <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
                                            <span class="buyer-info">
                                                <i class="bi bi-person"></i>
                                                {{ $order->buyer->username }}
                                            </span>
                                            <!-- Delivery Method Indicator -->
                                            @if($order->deliveryDetail && $order->deliveryDetail->deliveryMethod)
                                                <span class="delivery-method-info" style="background: {{ $order->deliveryDetail->deliveryMethod->isPickup() ? '#e8f5e8' : '#e3f2fd' }}; color: {{ $order->deliveryDetail->deliveryMethod->isPickup() ? '#28a745' : '#0d6efd' }}; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 500;">
                                                    @if($order->deliveryDetail->deliveryMethod->isPickup())
                                                        <i class="bi bi-bag-handle"></i> Pickup Order
                                                    @else
                                                        <i class="bi bi-truck"></i> Delivery Order
                                                    @endif
                                                </span>
                                            @endif
                                            <button class="report-btn" data-user-id="{{ $order->buyer->id }}" data-order-id="{{ $order->id }}">
                                                <i class="fas fa-flag"></i> Report User
                                            </button>
                                            @if($order->status === 'processing')
                                                @if($order->deliveryDetail && $order->deliveryDetail->deliveryMethod->isPickup())
                                                    <button onclick="updateOrderStatus({{ $order->id }}, 'delivering')" class="pickup-btn" style="background-color: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                                        <i class="bi bi-bag-check"></i> Ready for Pickup
                                                    </button>
                                                @else
                                                    <button onclick="updateOrderStatus({{ $order->id }}, 'delivering')" class="delivery-btn" style="background-color: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                                        <i class="bi bi-truck"></i> For Delivery
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <span class="order-status {{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="order-details">
                                    @if($order->status === 'cancelled' && $order->cancellation_reason)
                                        <div class="cancellation-info" style="background: #fff3f3; padding: 10px; border-radius: 5px; margin: 10px 0; border-left: 3px solid #dc3545;">
                                            <i class="bi bi-info-circle" style="color: #dc3545;"></i>
                                            <span style="margin-left: 5px; color: #721c24;">
                                                <strong>Cancellation Reason:</strong> 
                                                @if(in_array($order->cancellation_reason, ['no_longer_want', 'wrong_order', 'found_better']))
                                                    @switch($order->cancellation_reason)
                                                        @case('no_longer_want')
                                                            I don't want to buy anymore
                                                            @break
                                                        @case('wrong_order')
                                                            I made a mistake in ordering
                                                            @break
                                                        @case('found_better')
                                                            Found a better deal elsewhere
                                                            @break
                                                    @endswitch
                                                @else
                                                    {{ $order->cancellation_reason }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Delivery Details Section -->
                                    @if($order->deliveryDetail)
                                        <div class="delivery-details" style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                            @if($order->deliveryDetail->deliveryMethod->isPickup())
                                                <h5 style="margin: 0 0 10px 0; color: #28a745; display: flex; align-items: center; gap: 8px;">
                                                    <i class="bi bi-bag-handle"></i> Pickup Information
                                                </h5>
                                                @if($order->deliveryDetail->pickup_date)
                                                    <p style="margin: 5px 0; color: #666;"><strong>Pickup Date:</strong> {{ \Carbon\Carbon::parse($order->deliveryDetail->pickup_date)->format('M d, Y') }}</p>
                                                @endif
                                                @if($order->deliveryDetail->pickup_time_slot)
                                                    <p style="margin: 5px 0; color: #666;"><strong>Time Slot:</strong> {{ $order->deliveryDetail->pickup_time_slot }}</p>
                                                @endif
                                                @if($order->deliveryDetail->pickup_notes)
                                                    <p style="margin: 5px 0; color: #666;"><strong>Notes:</strong> {{ $order->deliveryDetail->pickup_notes }}</p>
                                                @endif
                                                <p style="margin: 5px 0; color: #666;"><strong>Pickup Fee:</strong> ₱{{ number_format($order->deliveryDetail->delivery_fee, 2) }}</p>
                                            @else
                                                <h5 style="margin: 0 0 10px 0; color: #0d6efd; display: flex; align-items: center; gap: 8px;">
                                                    <i class="bi bi-truck"></i> Delivery Information
                                                </h5>
                                                @if($order->deliveryDetail->delivery_address)
                                                    <p style="margin: 5px 0; color: #666;"><strong>Address:</strong> {{ $order->deliveryDetail->delivery_address }}</p>
                                                @endif
                                                <p style="margin: 5px 0; color: #666;"><strong>Delivery Fee:</strong> ₱{{ number_format($order->deliveryDetail->delivery_fee, 2) }}</p>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="products-list">
                                        @foreach($order->items as $item)
                                            <div class="product-item">
                                                <img src="{{ asset('storage/' . $item->post->image) }}" 
                                                     alt="{{ $item->post->title }}"
                                                     onerror="this.src='https://placehold.co/100x100?text=Product'">
                                                <div class="product-info">
                                                    <span class="product-name">{{ $item->post->title }}</span>
                                                    <span class="product-quantity">x{{ $item->quantity }}</span>
                                                    <span class="product-price">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="order-summary">
                                        <div class="summary-row">
                                            <span>Subtotal</span>
                                            <span>₱{{ number_format($order->total_amount - ($order->deliveryDetail ? $order->deliveryDetail->delivery_fee : 35), 2) }}</span>
                                        </div>
                                        <div class="summary-row">
                                            <span>{{ $order->deliveryDetail && $order->deliveryDetail->deliveryMethod->isPickup() ? 'Pickup Fee' : 'Delivery Fee' }}</span>
                                            <span>₱{{ number_format($order->deliveryDetail ? $order->deliveryDetail->delivery_fee : 35, 2) }}</span>
                                        </div>
                                        <div class="summary-row total">
                                            <span>Total Amount</span>
                                            <span>₱{{ number_format($order->total_amount, 2) }}</span>
                                        </div>
                                        <div class="summary-row">
                                            <span>Commission (10%)</span>
                                            <span>-₱{{ number_format($order->total_amount * 0.1, 2) }}</span>
                                        </div>
                                        <div class="summary-row total" style="border-top: 2px solid #28a745; font-weight: 700; color: #28a745;">
                                            <span>Your Earnings</span>
                                            <span>₱{{ number_format($order->total_amount * 0.9, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-orders">
                                <i class="bi bi-inbox"></i>
                                <p>No orders yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Orders Management Modal Styles */
    .orders-timeline {
        margin-top: 30px;
    }

    .order-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .order-info h4 {
        margin: 0;
        color: #333;
    }

    .order-meta {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 8px;
    }

    .delivery-method-info {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 500;
        border-radius: 12px;
        padding: 4px 10px;
        font-size: 11px;
        white-space: nowrap;
    }

    .delivery-details {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .delivery-details h5 {
        margin: 0 0 10px 0;
        font-size: 14px;
        font-weight: 600;
    }

    .delivery-details p {
        margin: 5px 0;
        font-size: 13px;
        line-height: 1.4;
    }

    .pickup-btn {
        background-color: #28a745 !important;
        transition: background-color 0.3s ease;
    }

    .pickup-btn:hover {
        background-color: #218838 !important;
    }

    .delivery-btn {
        background-color: #007bff !important;
        transition: background-color 0.3s ease;
    }

    .delivery-btn:hover {
        background-color: #0056b3 !important;
    }

    .order-status {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
    }

    .order-status.pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .order-status.processing {
        background-color: #cce5ff;
        color: #004085;
    }

    .order-status.delivering {
        background-color: #d4edda;
        color: #155724;
    }

    .order-status.completed {
        background-color: #d4edda;
        color: #155724;
    }

    .order-status.cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .order-details {
        border-top: 1px solid #eee;
        padding-top: 15px;
    }

    .customer-info {
        margin-bottom: 15px;
    }

    .order-items {
        margin-bottom: 15px;
    }

    .order-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .item-details p {
        margin: 0;
        font-size: 0.9em;
    }

    .order-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .accept-btn {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .reject-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .accept-btn:hover {
        background-color: #218838;
    }

    .reject-btn:hover {
        background-color: #c82333;
    }

    .no-orders {
        text-align: center;
        padding: 40px;
        color: #666;
    }

    .no-orders i {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .order-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 5px;
        color: #666;
        font-size: 0.9em;
    }

    .buyer-info {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .buyer-info i {
        color: #517A5B;
    }

    .cancellation-info {
        background: #fff3f3;
        padding: 10px;
        border-radius: 5px;
        margin: 10px 0;
        border-left: 3px solid #dc3545;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .cancellation-info i {
        color: #dc3545;
        font-size: 1.1em;
        margin-top: 2px;
    }

    .cancellation-info span {
        color: #721c24;
        flex: 1;
    }
    </style>

    <script>
    // ... existing code ...

    // Orders Management Modal Functionality
    const ordersManagementModal = document.getElementById('ordersManagementModal');
    const manageOrdersBtn = document.getElementById('manageOrdersBtn');
    const ordersManagementCloseBtn = ordersManagementModal.querySelector('.close');

    // Open orders management modal when Manage Orders button is clicked
    manageOrdersBtn.addEventListener('click', function() {
        ordersManagementModal.style.display = 'block';
    });

    // Close orders management modal when X is clicked
    ordersManagementCloseBtn.addEventListener('click', function() {
        ordersManagementModal.style.display = 'none';
    });

    // Close orders management modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === ordersManagementModal) {
            ordersManagementModal.style.display = 'none';
        }
    });

    // Function to update order status
    function updateOrderStatus(orderId, status) {
        Swal.fire({
            title: 'Update Order Status',
            text: `Are you sure you want to ${status === 'cancelled' ? 'reject' : 'update'} this order?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#517A5B',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, proceed',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update order status
                fetch(`/orders/${orderId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // If the order status is set to completed, update the earnings display
                        if (status === 'completed' && data.orderAmount) {
                            updateEarningsCard(data.orderAmount);
                        }

                        Swal.fire({
                            title: 'Success!',
                            text: 'Order status updated successfully',
                            icon: 'success',
                            confirmButtonColor: '#517A5B'
                        }).then(() => {
                            // Reload the page to show updated status
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Failed to update order status');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#517A5B'
                    });
                });
            }
        });
    }

    // ... existing code ...
    </script>

    <script>
        // ... existing scripts ...

        function showReportModal(orderId, username, userId) {
            console.log('Opening report modal for:', { orderId, username, userId }); // Debug log
            const modal = document.getElementById('reportUserModal');
            document.getElementById('reportedUserId').value = userId;
            document.getElementById('orderId').value = orderId;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeReportModal() {
            const modal = document.getElementById('reportUserModal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            document.getElementById('reportUserForm').reset();
        }

        function submitReport(event) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            // Disable submit button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            
            // Get form data
            const formData = new FormData(form);
            const reportData = {
                reported_id: formData.get('reported_id'),
                order_id: formData.get('order_id'),
                reason: formData.get('reason'),
                description: formData.get('description')
            };
            
            console.log('Submitting report:', reportData);
            
            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!token) {
                console.error('CSRF token not found');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Security token not found. Please refresh the page and try again.'
                });
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                return;
            }
            
            // Submit the report
            fetch('/reports', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify(reportData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json().then(data => {
                    if (!response.ok) {
                        throw { status: response.status, data };
                    }
                    return data;
                });
            })
            .then(data => {
                console.log('Report submitted successfully:', data);
                // Close the modal
                const modal = document.getElementById('reportUserModal');
                const modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Report submitted successfully.'
                });
                
                // Reset the form
                form.reset();
            })
            .catch(error => {
                console.error('Error submitting report:', error);
                let errorMessage = 'An error occurred while submitting the report.';
                
                if (error.status === 422 && error.data?.errors) {
                    // Handle validation errors
                    const errors = error.data.errors;
                    errorMessage = Object.values(errors).flat().join('\n');
                } else if (error.data?.message) {
                    errorMessage = error.data.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            })
            .finally(() => {
                // Re-enable submit button and restore original text
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        }
        // ... existing code ...
    </script>

    <!-- Report User Modal -->
    <div id="reportUserModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h2 class="modal-title">Report User</h2>
                <span class="close" onclick="closeReportModal()">&times;</span>
            </div>
            <form action="{{ route('reports.store') }}" method="POST" id="reportUserForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="reported_id" id="reportedUserId">
                    <input type="hidden" name="order_id" id="reportedOrderId">
                    
                    <div class="form-group">
                        <label for="reason">Reason for Report</label>
                        <select class="form-control" id="reason" name="reason" required>
                            <option value="">Select a reason</option>
                            <option value="fraudulent_activity">Fraudulent Activity</option>
                            <option value="inappropriate_behavior">Inappropriate Behavior</option>
                            <option value="scam_attempt">Scam Attempt</option>
                            <option value="harassment">Harassment</option>
                            <option value="other">Other</option>
                        </select>
                        @error('reason')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required 
                            placeholder="Please provide details about the issue..."></textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="cancel-btn" onclick="closeReportModal()">Cancel</button>
                    <button type="submit" class="submit-btn">Submit Report</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* ... existing styles ... */

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .modal-title {
            margin: 0;
            color: #333;
            font-size: 1.5em;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close:hover {
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #517A5B;
            outline: none;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .cancel-btn,
        .submit-btn {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .cancel-btn {
            background: #f8f9fa;
            border: 1px solid #ddd;
            color: #333;
        }

        .submit-btn {
            background: #dc3545;
            border: none;
            color: white;
        }

        .cancel-btn:hover {
            background: #e9ecef;
        }

        .submit-btn:hover {
            background: #c82333;
        }

        .submit-btn:disabled {
            background: #dc354580;
            cursor: not-allowed;
        }
    </style>

    // ... existing code ...

    <script>
        // Function to open the report modal
        function openReportModal(userId, orderId) {
            document.getElementById('reportedUserId').value = userId;
            document.getElementById('reportedOrderId').value = orderId;
            const modal = document.getElementById('reportUserModal');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Add event listeners when the document is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Add click handlers for report buttons
            const reportButtons = document.querySelectorAll('.report-btn');
            reportButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const orderId = this.getAttribute('data-order-id');
                    openReportModal(userId, orderId);
                });
            });

            // Add submit handler for the report form
            const reportForm = document.getElementById('reportUserForm');
            if (reportForm) {
                reportForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission
                    
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

                    // Get form data
                    const formData = new FormData(this);
                    
                    // Submit the form using fetch
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message || 'Report submitted successfully.'
                            });
                            closeReportModal();
                        } else {
                            throw new Error(data.message || 'Failed to submit report');
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting report:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'An error occurred while submitting the report.'
                        });
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Submit Report';
                    });
                });
            }

            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                const modal = document.getElementById('reportUserModal');
                if (event.target === modal) {
                    closeReportModal();
                }
            });
        });
    </script>

    <script>
        // ... existing code ...

        function updateOrderStatus(orderId, newStatus) {
            Swal.fire({
                title: 'Update Order Status',
                text: `Are you sure you want to mark this order as ${newStatus}?`,
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

                            // Update the status badge in the UI
                            const statusBadge = document.querySelector(`[data-order-id="${orderId}"]`).closest('.order-card').querySelector('.order-status');
                            if (statusBadge) {
                                statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                                statusBadge.className = `order-status ${newStatus}`;
                            }

                            // Update the For Delivery button visibility
                            const deliveryBtn = document.querySelector(`[data-order-id="${orderId}"]`).closest('.order-meta').querySelector('.delivery-btn');
                            if (deliveryBtn) {
                                deliveryBtn.style.display = newStatus === 'processing' ? 'flex' : 'none';
                            }

                            Swal.fire({
                                title: 'Success!',
                                text: 'Order status updated successfully',
                                icon: 'success',
                                confirmButtonColor: '#517A5B'
                            });
                        } else {
                            throw new Error(data.message || 'Failed to update order status');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: error.message || 'Something went wrong. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#517A5B'
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

        // ... existing code ...
    </script>
</body>
</html>
