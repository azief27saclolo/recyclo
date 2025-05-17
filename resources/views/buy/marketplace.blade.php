@extends('components.layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="section buying-guide" aria-label="buying guide">
    <div class="container">
        <!-- Page Header -->
        <div class="guide-header">
            <h1 class="h2-large section-title">Buy Requests Marketplace</h1>
            <p class="guide-subtitle">Browse through requests from users looking for recyclable materials</p>
        </div>

        <!-- Add Request Button -->
        <div class="post-request-section">
            @auth
                <a href="{{ route('buy.index', ['open_modal' => 'true']) }}" class="post-btn">
                    <i class="bi bi-plus-circle"></i> Post a Buy Request
                </a>
                <a href="{{ route('buy.index') }}" class="post-btn view-btn">
                    <i class="bi bi-list-ul"></i> My Buy Requests
                </a>
            @else
                <a href="{{ route('login') }}" class="post-btn">
                    <i class="bi bi-box-arrow-in-right"></i> Login to Post Buy Requests
                </a>
            @endauth
        </div>

        <!-- Posted Buy Requests -->
        <div class="posted-requests">
            <h2 class="section-title">Available Buy Requests</h2>
            
            @if($buyRequests->count() > 0)
                <div class="requests-grid">
                    @foreach($buyRequests as $request)
                    <div class="request-card">
                        <div class="request-image">
                            @php
                                $categoryImages = [
                                    'Metal' => 'images/metal.jpg',
                                    'Plastic' => 'images/plastic.jpg',
                                    'Paper' => 'images/paper.jpg',
                                    'Glass' => 'images/glass.jpg',
                                    'Wood' => 'images/wood.jpg',
                                    'Electronics' => 'images/electronics.jpg',
                                    'Fabric' => 'images/fabric.jpg',
                                    'Rubber' => 'images/rubber.jpg',
                                ];
                                $imageUrl = isset($categoryImages[$request->category]) 
                                    ? asset($categoryImages[$request->category]) 
                                    : asset('images/categories/default.jpg');
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $request->category }}">
                            <span class="request-category {{ strtolower($request->category) }}">{{ $request->category }}</span>
                        </div>
                        <div class="request-content">
                            <div class="request-header">
                                <div class="user-info">
                                    <img src="{{ $request->user->profile_picture ? asset('storage/' . $request->user->profile_picture) : asset('images/default-avatar.png') }}" alt="{{ $request->user->firstname }} {{ $request->user->lastname }}" class="user-avatar">
                                    <div>
                                        <h4>{{ $request->user->firstname }} {{ $request->user->lastname }}</h4>
                                        <span class="post-date">Posted {{ $request->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="status-badge active">Active</div>
                            </div>
                            
                            <div class="request-details">
                                <div class="request-main-info">
                            <h3 class="request-title">{{ $request->category }}</h3>
                                    <div class="quantity-badge">
                                        <i class="bi bi-box-seam"></i>
                                        <span>{{ $request->quantity }} {{ $request->unit }}</span>
                                    </div>
                                </div>

                                <div class="request-description-box">
                            <p class="request-description">{{ $request->description }}</p>
                                    <button class="read-more-btn" onclick="toggleDescription(this)">
                                        <span>Read More</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </button>
                                </div>

                                <div class="contact-info">
                                    <div class="contact-item">
                                        <i class="bi bi-telephone"></i>
                                        <div class="contact-details">
                                            <span class="contact-label">Contact Number</span>
                                            <span class="contact-value">{{ $request->number }}</span>
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="bi bi-geo-alt"></i>
                                        <div class="contact-details">
                                            <span class="contact-label">Location</span>
                                            <span class="contact-value">{{ $request->location }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="request-actions">
                                <button class="action-btn like-btn" data-likes="0">
                                    <i class="bi bi-heart"></i>
                                    <span>0</span>
                                </button>
                                <button class="action-btn">
                                    <i class="bi bi-chat"></i>
                                    <span>0</span>
                                </button>
                                <button class="action-btn share-btn">
                                    <i class="bi bi-share"></i>
                                </button>
                                
                                @auth
                                    <button class="contact-btn" onclick="notifyBuyer({{ $request->id }}, '{{ $request->user->firstname }} {{ $request->user->lastname }}')">Notify Buyer</button>
                                @else
                                    <a href="{{ route('login') }}" class="contact-btn">Login to Notify</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Enhanced Pagination Container -->
                <div class="pagination-container">
                    {{ $buyRequests->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-basket"></i>
                    <h3>No buy requests available</h3>
                    <p>Be the first to post a buy request!</p>
                    @if(Auth::check())
                        <a href="{{ route('buy.create') }}" class="create-btn"> Request</a>
                    @else
                        <a href="{{ route('login') }}" class="create-btn">Login to Create</a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Guide Steps Section -->
        <div class="guide-header">
            <h2 class="section-title">How Buy Requests Work</h2>
            <p class="guide-subtitle">Connect with buyers looking for recycled materials</p>
        </div>
        
        <div class="guide-steps">
            <div class="step">
                <div class="step-icon">
                    <i class="bi bi-search"></i>
                </div>
                <div class="step-number">01</div>
                <h3>Browse Requests</h3>
                <p>Explore buy requests posted by users looking for specific recyclable materials.</p>
            </div>

            <div class="step">
                <div class="step-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <div class="step-number">02</div>
                <h3>Contact Buyers</h3>
                <p>Reach out to buyers if you have materials that match their requirements.</p>
            </div>

            <div class="step">
                <div class="step-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="step-number">03</div>
                <h3>Arrange Delivery</h3>
                <p>Coordinate with buyers to arrange pickup or delivery of materials.</p>
            </div>

            <div class="step">
                <div class="step-icon">
                    <i class="bi bi-currency-exchange"></i>
                </div>
                <div class="step-number">04</div>
                <h3>Complete Transaction</h3>
                <p>Finalize the sale and help contribute to a more sustainable environment.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Modal -->
<div id="contactModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">
                <i class="bi bi-bell"></i>
                Notify Buyer
            </h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="contactForm" action="{{ route('marketplace.notify') }}" method="POST">
                @csrf
                <input type="hidden" id="requestId" name="request_id">
                <div class="form-group">
                    <label for="message" class="form-label">
                        <i class="bi bi-chat-text"></i>
                        Your Message to <span id="buyerName" class="buyer-name"></span>
                    </label>
                    <textarea name="message" id="message" class="form-control" rows="4" 
                              placeholder="Describe what you can offer and how you can help..." required></textarea>
                    <div class="help-text">Be specific about your offer and include any relevant details</div>
                </div>
                <div class="form-group">
                    <label for="contact_method" class="form-label">
                        <i class="bi bi-telephone"></i>
                        Preferred Contact Method
                    </label>
                    <div class="contact-method-container">
                        <select name="contact_method" id="contact_method" class="form-control" required onchange="toggleContactInput()">
                            <option value="">Select your preferred contact method</option>
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                    </select>
                        <div id="emailInputGroup" class="contact-input-group" style="display: none;">
                            <input type="email" name="contact_email" id="contact_email" class="form-control" 
                                   placeholder="Enter your email address...">
                </div>
                        <div id="phoneInputGroup" class="contact-input-group" style="display: none;">
                            <input type="tel" name="contact_phone" id="contact_phone" class="form-control" 
                                   placeholder="Enter your phone number...">
                        </div>
                    </div>
                    <div class="help-text">Choose how you'd like the buyer to contact you</div>
                </div>
                <div class="form-footer">
                    <button type="button" class="cancel-btn" onclick="closeContactModal()">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                    </button>
                    <button type="submit" class="submit-btn">
                        <i class="bi bi-send"></i>
                        Send Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Post Request Button */
    .post-request-section {
        text-align: center;
        margin-bottom: 40px;
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .post-btn {
        background: var(--hoockers-green);
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 25px;
        font-size: 18px; /* Increased from 1.1rem */
        display: inline-flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .view-btn {
        background: #4dabf7;
    }

    .post-btn:hover {
        background: #3c5c44;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .view-btn:hover {
        background: #3793dd;
    }

    .buying-guide {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .guide-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .guide-subtitle {
        color: #666;
        font-size: 18px; /* Increased from 1.1rem */
        margin-top: 10px;
    }

    /* Request Cards Styling */
    .requests-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-top: 30px;
    }

    .request-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .request-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(81, 122, 91, 0.15);
    }

    .request-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .request-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .request-card:hover .request-image img {
        transform: scale(1.05);
    }

    .request-category {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 16px; /* Increased from 0.9rem */
        font-weight: 500;
        color: white;
        background: rgba(81, 122, 91, 0.9);
        backdrop-filter: blur(5px);
    }

    .request-category.plastic { background: rgba(52, 152, 219, 0.9); }
    .request-category.metal { background: rgba(155, 89, 182, 0.9); }
    .request-category.paper { background: rgba(230, 126, 34, 0.9); }
    .request-category.glass { background: rgba(46, 204, 113, 0.9); }
    .request-category.wood { background: rgba(211, 84, 0, 0.9); }
    .request-category.electronics { background: rgba(41, 128, 185, 0.9); }
    .request-category.fabric { background: rgba(241, 196, 15, 0.9); }
    .request-category.rubber { background: rgba(44, 62, 80, 0.9); }

    .request-content {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        gap: 20px;
    }

    .request-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--hoockers-green);
    }

    .user-info h4 {
        margin: 0;
        font-size: 18px;
        color: #2c3e50;
        font-weight: 600;
    }

    .post-date {
        font-size: 14px;
        color: #6c757d;
    }

    .status-badge {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        background: #e8f5e9;
        color: #2e7d32;
    }

    .request-details {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .request-main-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .request-title {
        font-size: 24px;
        color: #2c3e50;
        margin: 0;
        font-weight: 700;
    }

    .quantity-badge {
        background: rgba(81, 122, 91, 0.1);
        padding: 8px 15px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--hoockers-green);
        font-weight: 500;
    }

    .quantity-badge i {
        font-size: 16px;
    }

    .request-description-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 12px;
        border-left: 4px solid var(--hoockers-green);
        position: relative;
        max-height: 40px; /* Height for two lines */
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .request-description-box.expanded {
        max-height: 200px; /* Allow full content height when expanded */
        overflow-y: auto;
    }

    .request-description {
        color: #495057;
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
        white-space: pre-wrap;
        word-wrap: break-word;
        text-align: justify;
        padding-right: 100px;
        margin-bottom: 5px;
    }

    .read-more-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        background: linear-gradient(90deg, 
            rgba(248, 249, 250, 0) 0%,
            rgba(248, 249, 250, 0.8) 20%,
            rgba(248, 249, 250, 1) 100%
        );
        padding: 5px 15px;
        color: var(--hoockers-green);
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        display: none;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
        height: 30px;
        min-width: 100px;
    }

    .read-more-btn.visible {
        display: flex;
    }

    .read-more-btn:hover {
        color: #3c5c44;
    }

    .read-more-btn i {
        transition: transform 0.3s ease;
    }

    .read-more-btn.expanded i {
        transform: rotate(180deg);
    }

    /* Add fade effect for expanded state */
    .request-description-box.expanded::after {
        display: none; /* Remove fade effect when expanded */
    }

    .request-description-box:not(.expanded)::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 30px;
        background: linear-gradient(transparent, #f8f9fa);
        pointer-events: none;
    }

    .contact-info {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .contact-item i {
        color: var(--hoockers-green);
        font-size: 18px;
        margin-top: 2px;
    }

    .contact-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .contact-label {
        font-size: 13px;
        color: #6c757d;
        font-weight: 500;
    }

    .contact-value {
        font-size: 15px;
        color: #2c3e50;
        font-weight: 500;
    }

    .request-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
        margin-top: auto;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 15px;
        border: 1px solid #e9ecef;
        background: #fff;
        color: #495057;
        font-size: 14px;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background: #f8f9fa;
        color: var(--hoockers-green);
        border-color: var(--hoockers-green);
    }

    .like-btn.active {
        background: #fff5f5;
        color: #e74c3c;
        border-color: #e74c3c;
    }

    .contact-btn {
        margin-left: auto;
        background: var(--hoockers-green);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-btn:hover {
        background: #3c5c44;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        color: white;
    }

    @media (max-width: 768px) {
        .requests-grid {
            grid-template-columns: 1fr;
        }

    .guide-steps {
            grid-template-columns: 1fr;
        }
        
        .post-request-section {
            flex-direction: column;
            gap: 10px;
        }

        /* Pagination responsiveness */
        .pagination-container {
            flex-wrap: wrap;
        }

        .request-main-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .quantity-badge {
            align-self: flex-start;
        }

        .contact-info {
            padding: 12px;
        }

        .request-description-box,
        .description-box {
            max-height: 180px;
        }
        
        .request-description,
        .description-text {
            font-size: 14px;
        }
    }
    
    /* Added section titles font size */
    .section-title {
        font-size: 28px;
    }
    
    .h2-large {
        font-size: 32px;
    }
    
    /* Step headings */
    .step h3 {
        font-size: 20px;
    }
    
    .step p {
        font-size: 16px;
    }

    /* Pagination Styling (copied from the selling page) */
    .pagination-container {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    /* Make pagination info display horizontally and larger */
    .pagination-container > div {
        width: 100%;
    }
    
    .pagination-container p.text-sm {
        font-size: 16px !important;
        margin-bottom: 15px;
        text-align: center;
        display: flex;
        justify-content: center;
        gap: 5px;
    }
    
    .pagination-container p.text-sm span {
        display: inline-block;
        font-size: 16px !important;
    }
    
    /* Enhanced themed pagination buttons */
    .pagination-container svg {
        width: 30px;
        height: 30px;
    }
    
    .pagination-container .flex-1 span {
        padding: 10px 16px;
        font-size: 16px;
    }
    
    .pagination-container button, 
    .pagination-container a {
        padding: 8px 14px !important;
        font-size: 16px !important;
        background-color: #f0f7f0 !important; /* Light green background */
        border: 1px solid #4CAF50 !important; /* Green border */
        border-radius: 12px !important; /* Rounder corners for all buttons */
        color: #2E7D32 !important; /* Dark green text */
        transition: all 0.3s ease !important;
        margin: 0 3px !important;
    }
    
    .pagination-container [aria-current="page"] span {
        background-color: #4CAF50 !important;
        color: white !important;
        border-color: #2E7D32 !important;
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(76, 175, 80, 0.4);
        font-size: 17px !important; /* Changed from 20px to 17px to match other numbers */
        padding: 8px 14px !important; /* Changed from 6px 12px to 8px 14px to match other numbers */
        border-radius: 12px !important; /* Changed from 14px to 12px to match other numbers */
    }
    
    /* Regular page numbers */
    .pagination-container span[aria-label="pagination.goto"] {
        font-size: 17px !important; 
        padding: 8px 14px !important;
    }

    /* Add these styles in the <style> section */
    .contact-info {
        background: #f8f9fa;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .contact-info p {
        margin: 5px 0;
        color: #495057;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-info i {
        color: var(--hoockers-green);
        font-size: 16px;
    }

    /* Add these styles for the contact modal */
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
        width: 90%;
        max-width: 600px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        transform: translateY(0);
        transition: transform 0.3s ease;
    }

    .modal-header {
        background: var(--hoockers-green);
        color: white;
        padding: 20px 25px;
        border-radius: 20px 20px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
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
        font-size: 24px;
    }

    .modal-body {
        padding: 25px;
    }

    .close {
        color: white;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .close:hover {
        opacity: 1;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        font-weight: 600;
        color: #2c3e50;
        font-size: 16px;
    }

    .form-label i {
        color: var(--hoockers-green);
    }

    .buyer-name {
        color: var(--hoockers-green);
        font-weight: 700;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .form-control:focus {
        border-color: var(--hoockers-green);
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(81, 122, 91, 0.1);
        outline: none;
    }

    .help-text {
        font-size: 13px;
        color: #6c757d;
        margin-top: 6px;
    }

    .form-footer {
        display: flex;
        gap: 15px;
        margin-top: 25px;
    }

    .cancel-btn {
        flex: 1;
        padding: 12px;
        border: 2px solid #e9ecef;
        background: #f8f9fa;
        color: #6c757d;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
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

    .submit-btn {
        flex: 1;
        padding: 12px;
        border: none;
        background: var(--hoockers-green);
        color: white;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
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
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .modal-content {
            width: 95%;
            margin: 10px auto;
        }
        
        .form-footer {
            flex-direction: column;
        }
        
        .cancel-btn, .submit-btn {
            width: 100%;
        }
    }

    /* Update the overview modal description box */
    .description-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        margin-top: 10px;
        max-height: 250px;
        overflow-y: auto;
    }

    .description-box::-webkit-scrollbar {
        width: 6px;
    }

    .description-box::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .description-box::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .description-box::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .description-text {
        color: #2c3e50;
        line-height: 1.6;
        margin: 0;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    /* Update the form textarea styles */
    textarea.form-control {
        min-height: 150px;
        max-height: 300px;
        resize: vertical;
        line-height: 1.6;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    /* Add a fade effect to indicate scrollable content */
    .request-description-box::after,
    .description-box::after {
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

    .request-description-box:hover::after,
    .description-box:hover::after {
        opacity: 1;
    }

    /* Add these styles */
    .contact-method-container {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .contact-method-container select {
        flex: 1;
    }

    .contact-input-group {
        flex: 2;
    }

    .contact-input-group input {
        width: 100%;
    }
    
    .response-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .response-meta i {
        color: var(--hoockers-green);
    }

    /* Add these styles for the map and marker */
    #map-container {
        height: 300px;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #eee;
        margin-bottom: 20px;
    }

    .custom-marker {
        background-color: #517A5B;
        border: 2px solid white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .description-box {
        position: relative;
        margin-bottom: 15px;
    }

    .description-text {
        margin: 0;
        line-height: 1.5;
        color: #495057;
        font-size: 15px;
    }

    .expand-button {
        display: none;
        align-items: center;
        gap: 5px;
        color: #517A5B;
        background: none;
        border: none;
        padding: 5px 0;
        cursor: pointer;
        font-size: 14px;
    }

    .expand-button:hover {
        color: #3c5c44;
    }

    .description-box.expanded .description-text {
        white-space: normal;
    }
</style>

<script>
    // Initialize map and marker
    let map, marker;
    let geocoder;

    function initMap() {
        // Default to Zamboanga City coordinates
        const initialLat = 6.9214;
        const initialLng = 122.0790;
        const initialZoom = 13;

        // Initialize the map
        map = L.map('map-container').setView([initialLat, initialLng], initialZoom);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Create custom icon for marker
        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: '<i class="bi bi-geo-alt-fill" style="color: white; font-size: 16px;"></i>',
            iconSize: [30, 30],
            iconAnchor: [15, 15],
            popupAnchor: [0, -15]
        });

        // Initialize marker
        marker = L.marker([initialLat, initialLng], {
            icon: customIcon,
            draggable: true
        }).addTo(map);

        // Initialize geocoder
        geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: 'Search for a location...',
            errorMessage: 'Nothing found.'
        }).on('markgeocode', function(e) {
            const latlng = e.geocode.center;
            marker.setLatLng(latlng);
            map.setView(latlng, 16);
            document.getElementById('location-input').value = e.geocode.name;
        }).addTo(map);

        // Add click event to map
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            reverseGeocode(e.latlng.lat, e.latlng.lng);
        });

        // Add marker drag end event
        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            reverseGeocode(position.lat, position.lng);
        });
    }

    // Function to handle description box expansion
    function handleDescriptionBox(descriptionBox) {
        if (!descriptionBox) return;
        
        const description = descriptionBox.querySelector('.description-text');
        const expandButton = descriptionBox.querySelector('.expand-button');
        
        if (!description || !expandButton) return;
        
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

    // Initialize description boxes and map when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        initMap();

        // Initialize description boxes
        const descriptionBoxes = document.querySelectorAll('.description-box');
        descriptionBoxes.forEach(box => {
            if (box) {
                handleDescriptionBox(box);
            }
        });
    });

    // Handle expand/collapse
    function toggleDescription(button) {
        if (!button) return;
        
        const descriptionBox = button.closest('.description-box');
        if (!descriptionBox) return;
        
        const isExpanded = descriptionBox.classList.contains('expanded');
        
        if (isExpanded) {
            descriptionBox.classList.remove('expanded');
            button.innerHTML = '<span>Read More</span><i class="bi bi-chevron-down"></i>';
        } else {
            descriptionBox.classList.add('expanded');
            button.innerHTML = '<span>Show Less</span><i class="bi bi-chevron-up"></i>';
        }
    }

    // Update the notify buyer functionality
    function notifyBuyer(requestId, buyerName) {
        // Set the request ID and buyer name
            document.getElementById('requestId').value = requestId;
            document.getElementById('buyerName').textContent = buyerName;
        
        // Reset the form
        document.getElementById('contactForm').reset();
        
        // Show the modal
        const modal = document.getElementById('contactModal');
        modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        
        // Focus on the message textarea
        setTimeout(() => {
            document.getElementById('message').focus();
        }, 100);
        }

    function closeContactModal() {
        const modal = document.getElementById('contactModal');
        modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        
        // Reset the form
        document.getElementById('contactForm').reset();
    }

    // Add event listeners when the document is loaded
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('contactModal');
        const closeBtn = modal.querySelector('.close');
        const contactForm = document.getElementById('contactForm');
        
        // Close modal when clicking the X button
        closeBtn.addEventListener('click', closeContactModal);
        
        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeContactModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display === 'flex') {
                closeContactModal();
            }
        });
        
        // Handle form submission
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
            
            const contactMethod = document.getElementById('contact_method').value;
            const contactEmail = document.getElementById('contact_email').value;
            const contactPhone = document.getElementById('contact_phone').value;
            
            // Validate contact details based on selected method
            if (contactMethod === 'email' && !contactEmail) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please provide your email address',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
                return;
            }
            
            if (contactMethod === 'phone' && !contactPhone) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please provide your phone number',
                    icon: 'error',
                    confirmButtonColor: '#517A5B'
                });
                return;
            }
            
                const formData = new FormData(this);
                
            // Ensure contact details are included in formData
            if (contactMethod === 'email') {
                formData.set('contact_email', contactEmail);
                formData.delete('contact_phone');
            } else {
                formData.set('contact_phone', contactPhone);
                formData.delete('contact_email');
            }
            
            const submitBtn = this.querySelector('.submit-btn');
            
            // Disable submit button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Sending...';
            
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                        throw new Error(data.message || 'Something went wrong');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                // Show success message
                        Swal.fire({
                            title: 'Success!',
                    text: data.message || 'Your notification has been sent successfully!',
                            icon: 'success',
                            confirmButtonColor: '#517A5B'
                        });
                        
                        // Close modal and reset form
                closeContactModal();
                })
                .catch(error => {
                // Show error message with custom styling for the "silly" message
                const isSillyMessage = error.message.includes("Hey silly");
                    Swal.fire({
                    title: isSillyMessage ? 'Oops!' : 'Error!',
                    text: error.message || 'Failed to send notification. Please try again.',
                    icon: isSillyMessage ? 'warning' : 'error',
                    confirmButtonColor: '#517A5B',
                    customClass: {
                        popup: 'bigger-modal'
                    }
                });
            })
            .finally(() => {
                // Re-enable submit button and restore original text
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-send"></i> Send Notification';
                });
            });

        // Check each description box for content length
        document.querySelectorAll('.request-description-box').forEach(box => {
            const description = box.querySelector('.request-description');
            const readMoreBtn = box.querySelector('.read-more-btn');
            
            // Get the line height
            const lineHeight = parseInt(window.getComputedStyle(description).lineHeight);
            // Get the actual height of the content
            const contentHeight = description.scrollHeight;
            
            // Show read more button only if content exceeds 2 lines
            if (contentHeight > lineHeight * 2) {
                readMoreBtn.classList.add('visible');
                }
            });
        });

    // Add this function to handle the contact method selection
    function toggleContactInput() {
        const contactMethod = document.getElementById('contact_method').value;
        const emailGroup = document.getElementById('emailInputGroup');
        const phoneGroup = document.getElementById('phoneInputGroup');
        const emailInput = document.getElementById('contact_email');
        const phoneInput = document.getElementById('contact_phone');

        // Hide both groups first
        emailGroup.style.display = 'none';
        phoneGroup.style.display = 'none';

        // Clear both inputs
        emailInput.value = '';
        phoneInput.value = '';

        // Show the selected group
        if (contactMethod === 'email') {
            emailGroup.style.display = 'block';
            emailInput.setAttribute('required', 'required');
            phoneInput.removeAttribute('required');
        } else if (contactMethod === 'phone') {
            phoneGroup.style.display = 'block';
            phoneInput.setAttribute('required', 'required');
            emailInput.removeAttribute('required');
        }
    }
</script>
@endsection
