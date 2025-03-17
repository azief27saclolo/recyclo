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

        <h2 class="section-title">Shop Products</h2>
        
        @if(isset($posts) && count($posts) > 0)
            <div class="products-container">
                @foreach($posts as $post)
                    <div class="product-card">
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             alt="{{ $post->title }}"
                             onerror="this.onerror=null; this.src='https://placehold.co/200x200?text=Product';">
                        <h3>{{ $post->title }}</h3>
                        <p class="price">₱{{ $post->price }}.00</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-shop-message">
                <p>No products available from this seller yet.</p>
            </div>
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
</style>
@endsection
