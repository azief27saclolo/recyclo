@extends('components.layout')

@section('content')
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
                            
                            <h3 class="request-title">{{ $request->category }}</h3>
                            <p class="request-meta">
                                <i class="bi bi-box-seam"></i> {{ $request->quantity }} {{ $request->unit }}
                                @if($request->user->address)
                                <i class="bi bi-geo-alt"></i> {{ $request->user->address }}
                                @endif
                            </p>
                            <p class="request-description">{{ $request->description }}</p>
                            
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
                                    <button class="contact-btn" onclick="notifyBuyer({{ $request->id }}, '{{ $request->user->name }}')">Notify Buyer</button>
                                @else
                                    <a href="{{ route('login') }}" class="contact-btn">Login to Notify</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="pagination-container">
                    {{ $buyRequests->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-basket"></i>
                    <h3>No buy requests available</h3>
                    <p>Be the first to post a buy request!</p>
                    @if(Auth::check())
                        <a href="{{ route('buy.create') }}" class="create-btn">Create Buy Request</a>
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
            <h2 class="modal-title">Notify Buyer</h2>
            <span class="close">&times;</span>
        </div>
        <div id="contactModalContent">
            <form id="contactForm">
                <input type="hidden" id="requestId" name="request_id">
                <div class="form-group">
                    <label for="message">Your Message to <span id="buyerName"></span></label>
                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Describe what you can offer..." required></textarea>
                </div>
                <div class="form-group">
                    <label for="contact_method">Preferred Contact Method</label>
                    <select name="contact_method" id="contact_method" class="form-control" required>
                        <option value="">--Select--</option>
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Send Notification</button>
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
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .request-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-info h4 {
        margin: 0;
        font-size: 17px; /* Increased from 1rem */
        color: #333;
    }

    .post-date {
        font-size: 15px; /* Increased from 0.85rem */
        color: #666;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 15px; /* Increased from 0.85rem */
        font-weight: 500;
    }

    .status-badge.active {
        background: #d4edda;
        color: #155724;
    }

    .request-title {
        font-size: 22px; /* Increased from 1.3rem */
        color: #333;
        margin: 15px 0;
    }

    .request-meta {
        display: flex;
        gap: 20px;
        color: #666;
        font-size: 16px; /* Increased from 0.95rem */
        margin-bottom: 15px;
    }

    .request-meta i {
        margin-right: 5px;
    }

    .request-description {
        color: #555;
        font-size: 16px; /* Increased from 0.95rem */
        line-height: 1.5;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .request-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
        margin-top: auto;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 8px 12px;
        border: none;
        background: none;
        color: #666;
        font-size: 16px; /* Increased from 0.9rem */
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        color: var(--hoockers-green);
    }

    .like-btn.active {
        color: #e74c3c;
    }

    .like-btn.active i {
        animation: likeEffect 0.3s ease;
    }

    .contact-btn {
        margin-left: auto;
        background: var(--hoockers-green);
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 20px;
        font-size: 16px; /* Increased from 0.9rem */
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .contact-btn:hover {
        background: #3c5c44;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        color: white;
    }

    @keyframes likeEffect {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    /* Guide Steps */
    .guide-steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 30px;
        margin-top: 20px;
    }

    .step {
        background: white;
        padding: 30px 20px;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        text-align: center;
        position: relative;
    }

    .step-icon {
        width: 70px;
        height: 70px;
        background: rgba(81, 122, 91, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .step-icon i {
        font-size: 32px; /* Increased from 2rem */
        color: var(--hoockers-green);
    }

    .step-number {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 24px; /* Increased from 1.5rem */
        font-weight: 700;
        color: rgba(81, 122, 91, 0.2);
    }

    .pagination-container {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .empty-state h3 {
        font-size: 24px; /* Increased from 1.5rem */
        color: #333;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #666;
        font-size: 18px; /* Added font size */
        margin-bottom: 20px;
    }

    .empty-state i {
        font-size: 60px; /* Increased from 48px */
        color: #dee2e6;
        display: block;
        margin-bottom: 15px;
    }

    .create-btn {
        background: var(--hoockers-green);
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        font-weight: 500;
        font-size: 16px; /* Added font size */
        transition: all 0.3s ease;
    }

    .create-btn:hover {
        background: #3c5c44;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Modal Styling */
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
    }

    .modal-content {
        background-color: white;
        margin: 50px auto;
        padding: 30px;
        width: 90%;
        max-width: 600px;
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
    }

    .modal-title {
        color: var(--hoockers-green);
        font-size: 28px; /* Increased from 24px */
        font-weight: 600;
        margin: 0;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 32px; /* Increased from 28px */
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
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 18px; /* Added font size */
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 18px; /* Increased from 16px */
    }

    .form-control:focus {
        border-color: var(--hoockers-green);
        outline: none;
    }

    .submit-btn {
        background: var(--hoockers-green);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px; /* Increased from 16px */
        width: 100%;
        transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
        background: #3c5c44;
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
</style>

<script>
    // Contact Modal Functionality
    document.addEventListener('DOMContentLoaded', function() {
        let contactModal = document.getElementById('contactModal');
        let closeBtn = contactModal.querySelector('.close');
        let currentRequestId = null;
        
        // Add notify buyer function to window
        window.notifyBuyer = function(requestId, buyerName) {
            document.getElementById('requestId').value = requestId;
            document.getElementById('buyerName').textContent = buyerName;
            contactModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        closeBtn.addEventListener('click', function() {
            contactModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        window.addEventListener('click', function(e) {
            if (e.target === contactModal) {
                contactModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });

        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Here you would send the data to your server
            // This is a placeholder for the actual AJAX call
            
            alert('Notification sent! The buyer will contact you soon.');
            
            contactModal.style.display = 'none';
            document.body.style.overflow = 'auto';
            this.reset();
        });
        
        // Like button functionality
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.toggle('active');
                const likesSpan = this.querySelector('span');
                const currentLikes = parseInt(likesSpan.textContent);
                
                if (this.classList.contains('active')) {
                    likesSpan.textContent = currentLikes + 1;
                } else {
                    likesSpan.textContent = Math.max(0, currentLikes - 1);
                }
            });
        });

        // Share button functionality
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Basic share implementation
                if (navigator.share) {
                    navigator.share({
                        title: 'Buy Request on Recyclo',
                        text: 'Check out this buy request on Recyclo!',
                        url: window.location.href
                    });
                } else {
                    alert('Sharing is not supported on this browser');
                }
            });
        });
    });
</script>
@endsection
