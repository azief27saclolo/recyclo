@extends('components.layout')

@section('content')
<div class="container">
    @if(isset($shop))
        <div class="shop-header">
            <div class="shop-info">
                {{-- Use a simple fallback image with full URL --}}
                <img src="{{ $shop->profile_picture ? asset('storage/' . $shop->profile_picture) : asset('images/default-shop.jpg') }}" 
                     alt="{{ $shop->username }}'s Shop" 
                     class="shop-image"
                     onerror="this.onerror=null; this.src='https://placehold.co/300x300?text=Shop';">
                
                <div class="shop-details">
                    <h1 class="shop-name">{{ $shop->username }}'s Shop</h1>
                    
                    <div class="shop-stats">
                        <div class="stat-item">
                            <i class="bi bi-box"></i>
                            <span>{{ $posts->count() }} products</span>
                        </div>
                        <div class="stat-item">
                            <i class="bi bi-calendar"></i>
                            <span>Joined {{ $shop->created_at->format('M Y') }}</span>
                        </div>
                    </div>

                    <div class="contact-info">
                        @if($shop->location)
                        <div class="contact-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ $shop->location }}</span>
                        </div>
                        @endif
                        @if($shop->number)
                        <div class="contact-item">
                            <i class="bi bi-telephone"></i>
                            <span>{{ $shop->number }}</span>
                        </div>
                        @endif
                        <div class="contact-item">
                            <i class="bi bi-envelope"></i>
                            <span>{{ $shop->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="section shop" id="shop" aria-label="shop">
            <div class="container">
                <div class="title-wrapper shop-products-title">
                    <h2 class="h2 section-title">Shop Products</h2>
                </div>
                
                @if(isset($posts) && count($posts) > 0)
                    <div class="products-grid">
                        @foreach($posts as $post)
                            <div class="grid-item">
                                <x-postCard :post="$post" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-shop-message">
                        <p>No products available from this seller yet.</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- New Arrivals Section (if needed) -->
        @if(count($latestPosts) > 0 && $latestPosts->count() != $posts->count())
            <section class="section shop" id="new-arrivals" aria-label="new arrivals">
                <div class="container">
                    <div class="title-wrapper">
                        <h2 class="h2 section-title">New Arrivals</h2>
                        <a href="{{ route('posts.user', $shop) }}" class="btn-link">
                            <span class="span">View All</span>
                            <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                        </a>
                    </div>
                    
                    <ul class="has-scrollbar">
                        @foreach($latestPosts as $post)
                            <li class="scrollbar-item">
                                <x-postCard :post="$post" />
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endif
    @else
        <div class="alert alert-danger">
            Shop information could not be loaded.
        </div>
    @endif
</div>

<style>
    /* Simple standalone styling that doesn't rely on external CSS */
    .shop-header {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .shop-info {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 30px;
        align-items: start;
    }

    @media (max-width: 768px) {
        .shop-info {
            grid-template-columns: 1fr;
        }
    }

    .shop-image {
        width: 100%;
        height: 300px;
        border-radius: 10px;
        object-fit: cover;
    }

    .shop-details {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .shop-name {
        font-size: 2.2rem;
        color: #333;
        margin-bottom: 10px;
    }

    .shop-stats {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }

    .section-title {
        font-size: 1.8rem;
        margin: 20px 0;
        color: #1e6f31;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 15px 0;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }

    .products-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .product-card {
        width: 200px;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        background: white;
    }

    .product-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .product-card h3 {
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .product-card .price {
        font-weight: bold;
        color: #1e6f31;
    }

    .empty-shop-message {
        text-align: center;
        padding: 40px;
        background: #f9f9f9;
        border-radius: 8px;
        margin: 20px 0;
    }

    /* Ensure slider works with any number of products */
    .has-scrollbar {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        padding: 10px 0;
        margin: 0 -5px;
    }

    .scrollbar-item {
        flex: 0 0 auto;
        width: 250px;
        margin: 0 10px;
        scroll-snap-align: start;
    }

    /* Make sure scrollbar is always visible when needed */
    .has-scrollbar::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }

    .has-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 25px;
    }

    .has-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 25px;
    }

    .has-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Product Grid Styles - Adjusted Card Size */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); /* Increased from 200px */
        gap: 18px; /* Increased from 15px */
        margin-top: 10px; /* Reduced from 20px to bring grid closer to title */
    }

    .grid-item {
        display: flex;
        justify-content: center;
    }

    /* Make cards slightly bigger */
    .products-grid .shop-card {
        width: 95%;  /* Increased from 90% */
        height: auto;
        margin: 0 auto;
        transform-origin: center top;
    }

    .products-grid .card-banner {
        height: 230px; /* Increased from 210px */
    }

    .products-grid .card-content {
        padding: 12px; /* Increased from 10px */
    }

    .products-grid .card-title {
        font-size: 1rem; /* Increased from 0.9rem */
        margin-bottom: 6px;
    }

    .products-grid .price {
        font-size: 1.1rem; /* Increased from 1rem */
    }

    /* Media queries for responsive grid with adjusted card sizes */
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px;
        }
    }

    /* Make sure the post cards display properly in the grid */
    .products-grid .shop-card {
        width: 100%;
        height: 100%;
        margin: 0;
    }

    /* Enhanced Shop Products Title */
    .shop-products-title {
        margin-bottom: 10px; /* Reduced from default to bring closer to products */
    }
    
    .shop-products-title .section-title {
        font-size: 2.4rem; /* Increased from 1.8rem */
        font-weight: 700;
        color: #1e6f31;
        margin: 10px 0; /* Reduced top/bottom margin */
    }
</style>
@endsection
