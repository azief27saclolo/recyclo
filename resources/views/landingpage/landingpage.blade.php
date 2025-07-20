@extends('components.layout')

@section('content')
<div class="container">
    <article>
        <section class="section hero" id="home" aria-label="hero">
            <div class="container">
                <ul class="has-scrollbar">
                    <li class="scrollbar-item">
                        <div class="hero-card has-bg-image" style="background-image: url('images/sss.jpg')">
                            <div class="card-content">
                                <h1 class="h1 hero-title">
                                    Reduce, Reuse,<br>
                                    Recycle
                                </h1>
                                <p class="hero-text" style="color: black">
                                    Solid recyclable materials available for you! So what are you waiting for?
                                </p>
                                <p class="price" style="color: black;">Starting at ₱ 15.00</p>
                                <a href="{{ route('posts') }}" class="btn btn-primary" style="display: flex; align-items: center; justify-content: center;">Shop Now</a>
                            </div>
                        </div>
                    </li>
                    <li class="scrollbar-item">
                        <div class="hero-card has-bg-image" style="background-image: url('images/mm.jpg')">
                            <div class="card-content">
                                <h1 class="h1 hero-title">
                                    Plastic? Metals? <br>
                                    Woods & more?
                                </h1>
                                <p class="hero-text" style="color: black">
                                    Recyclo has a lot to offer of different kinds of recyclable materials!
                                </p>
                                <p class="price">Starting at ₱ 15.00</p>
                                <a href="{{ route('posts') }}" class="btn btn-primary" style="display: flex; align-items: center; justify-content: center;">Shop Now</a>
                            </div>
                        </div>
                    </li>
                    <li class="scrollbar-item">
                        <div class="hero-card has-bg-image" style="background-image: url('images/bboo.jpg')">
                            <div class="card-content">
                                <h1 class="h1 hero-title">
                                    Reveal The <br>
                                    Beauty of Skin
                                </h1>
                                <p class="hero-text" style="color: black">
                                    Made using clean, non-toxic ingredients, our products are designed for everyone.
                                </p>
                                <p class="price">Starting at ₱ 15.00</p>
                                <a href="{{ route('posts') }}" class="btn btn-primary" style="display: flex; align-items: center; justify-content: center;">Shop Now</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <section class="section collection" id="collection" aria-label="collection">
            <div class="container">
                <ul class="collection-list">
                    <li>
                        <div class="collection-card has-before hover:shine">
                            <h2 class="h2 card-title">Recyclable Materials</h2>
                            <p class="card-text">All sorts of solid waste awaits!</p>
                            <a href="{{ route('posts') }}" class="btn-link">
                                <span class="span">Shop Now</span>
                                <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                            </a>
                            <div class="has-bg-image" style="background-image: url('images/bos.jpg')"></div>
                        </div>
                    </li>
                    <li>
                        <div class="collection-card has-before hover:shine">
                            <h2 class="h2 card-title">Thrash?</h2>
                            <p class="card-text">No. They are treasures!</p>
                            <a href="{{ route('posts') }}" class="btn-link">
                                <span class="span">Shop Now</span>
                                <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                            </a>
                            <div class="has-bg-image" style="background-image: url('images/plastic.jpg')"></div>
                        </div>
                    </li>
                    <li>
                        <div class="collection-card has-before hover:shine">
                            <h2 class="h2 card-title">Shop in Recyclo</h2>
                            <p class="card-text">Budget-friendly & Economic Growth</p>
                            <a href="{{ route('posts') }}" class="btn-link">
                                <span class="span">Shop Now</span>
                                <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                            </a>
                            <div class="has-bg-image" style="background-image: url('images/glass.jpg')"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        {{-- Best Deals Section --}}
        @if($bestDeals->count() > 0)
        <section class="section shop" id="best-deals" aria-label="best deals">
            <div class="container">
                <div class="title-wrapper">
                    <h2 class="h2 section-title">🔥 Best Deals</h2>
                    <a href="{{ route('deals.index') }}" class="btn-link">
                        <span class="span">View All Deals</span>
                        <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                    </a>
                </div>
                <ul class="has-scrollbar product-slider">
                    @foreach ($bestDeals as $deal)       
                        <li class="scrollbar-item">
                            <a href="{{ route('posts.show', $deal) }}" class="shop-card-link">
                                <div class="shop-card" style="position: relative;">
                                    <!-- Deal Badge -->
                                    @if($deal->discount_percentage > 0)
                                    <div style="position: absolute; top: 10px; right: 10px; background: linear-gradient(45deg, #ff416c, #ff4b2b); color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 700; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                                        {{ number_format($deal->discount_percentage, 0) }}% OFF
                                    </div>
                                    @endif
                                    
                                    <!-- Featured Badge -->
                                    @if($deal->is_featured_deal)
                                    <div style="position: absolute; top: 10px; left: 10px; background: linear-gradient(45deg, #ffd700, #ffed4e); color: #333; padding: 4px 8px; border-radius: 12px; font-size: 10px; font-weight: 700; z-index: 10;">
                                        ⭐ FEATURED
                                    </div>
                                    @endif
                                    
                                    <div class="card-banner img-holder" style="--width: 270; --height: 360;">
                                        @if($deal->image)
                                            <img src="{{ asset('storage/' . $deal->image) }}" width="270" height="360" loading="lazy"
                                                alt="{{ $deal->title }}" class="img-cover" style="object-fit: cover; width: 100%; height: 100%; max-height: 360px;">
                                        @else
                                            <img src="{{ asset('images/default-product.jpg') }}" width="270" height="360" loading="lazy"
                                                alt="{{ $deal->title }}" class="img-cover" style="object-fit: cover; width: 100%; height: 100%; max-height: 360px;">
                                        @endif
                                        <span class="badge" aria-label="category">{{ $deal->category }}</span>
                                        
                                        <!-- Deal Score Badge -->
                                        <div style="position: absolute; bottom: 10px; left: 10px; background: rgba(0,0,0,0.8); color: white; padding: 3px 6px; border-radius: 8px; font-size: 10px; font-weight: 600;">
                                            🔥 {{ number_format($deal->deal_score, 1) }}
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="price">
                                            @if($deal->original_price && $deal->original_price > $deal->price)
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <span style="color: #ff416c; font-weight: 700;">₱{{ number_format($deal->price, 2) }}</span>
                                                <span style="color: #999; text-decoration: line-through; font-size: 14px;">₱{{ number_format($deal->original_price, 2) }}</span>
                                            </div>
                                            <div style="color: #28a745; font-size: 12px; font-weight: 600; margin-top: 2px;">
                                                Save ₱{{ number_format($deal->savings_amount, 2) }}
                                            </div>
                                            @else
                                            <span style="color: #ff416c; font-weight: 700;">₱{{ number_format($deal->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <h3 class="h3">
                                            <span class="card-title">{{ Str::limit($deal->title, 40) }}</span>
                                        </h3>
                                        <p class="card-text" style="font-size: 14px; color: #666; margin-top: 5px;">
                                            <i class="bi bi-shop" style="margin-right: 4px;"></i>{{ $deal->user->username ?? 'Unknown' }}
                                            <span style="margin-left: 10px;">
                                                <i class="bi bi-geo-alt" style="margin-right: 4px;"></i>{{ Str::limit($deal->location, 15) }}
                                            </span>
                                        </p>
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; font-size: 12px; color: #666;">
                                            <span><i class="bi bi-box" style="margin-right: 3px;"></i>{{ $deal->quantity }} left</span>
                                            <span><i class="bi bi-eye" style="margin-right: 3px;"></i>{{ $deal->views_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
        @endif

        {{-- Recent Posts --}}
        <section class="section shop" id="shop" aria-label="shop">
            <div class="container">
                <div class="title-wrapper">
                    <h2 class="h2 section-title">Recent Products</h2>
                    <a href="{{ route('posts') }}" class="btn-link">
                        <span class="span">View More Products</span>
                        <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                    </a>
                </div>
                <ul class="has-scrollbar product-slider">
                    @forelse ($posts as $post)       
                        <li class="scrollbar-item">
                            <a href="{{ route('posts.show', $post) }}" class="shop-card-link">
                                <div class="shop-card">
                                    <div class="card-banner img-holder" style="--width: 270; --height: 360;">
                                        @if($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" width="270" height="360" loading="lazy"
                                                alt="{{ $post->title }}" class="img-cover" style="object-fit: cover; width: 100%; height: 100%; max-height: 360px;">
                                        @else
                                            <img src="{{ asset('images/default-product.jpg') }}" width="270" height="360" loading="lazy"
                                                alt="{{ $post->title }}" class="img-cover" style="object-fit: cover; width: 100%; height: 100%; max-height: 360px;">
                                        @endif
                                        <span class="badge" aria-label="category">{{ $post->category_name }}</span>
                                    </div>
                                    <div class="card-content">
                                        <div class="price">
                                            <span class="span">₱{{ number_format($post->price, 2) }}</span>
                                        </div>
                                        <h3 class="card-title">{{ $post->title }}</h3>
                                        <div class="shop-info">
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('images/default-profile.png') }}" 
                                                     alt="{{ $post->user->username }}" 
                                                     class="w-6 h-6 rounded-full object-cover">
                                                <a href="{{ route('shops.show', $post->user->id) }}" class="hover:text-primary-600" id="owner-name">
                                                    {{ $post->user->username }}
                                                </a>
                                            </div>
                                            @if($post->user && $post->user->location)
                                                <div class="location-info">
                                                    <ion-icon name="location-outline"></ion-icon>
                                                    <span>{{ Str::limit($post->user->location, 20) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-stats">
                                            <span class="quantity">Available: {{ $post->quantity }} {{ $post->unit }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="scrollbar-item">
                            <div class="shop-card">
                                <div class="card-content">
                                    <p>No products available at the moment.</p>
                                </div>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </section>

        <section class="section shop" id="shop" aria-label="shop">
            <div class="container">
                <div class="title-wrapper">
                    <h2 class="h2 section-title">Shops For You</h2>
                    <a href="{{ route('shops') }}" class="btn-link">
                        <span class="span">View More Shops</span>
                        <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                    </a>
                </div>
                <ul class="has-scrollbar">
                    @forelse ($shops as $shop)
                    <li class="scrollbar-item">
                        <div class="shop-card">
                            <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                                @if($shop->image)
                                    <img src="{{ asset('storage/' . $shop->image) }}" width="540" height="720" loading="lazy" alt="{{ $shop->shop_name }}" class="img-cover">
                                @elseif($shop->user && $shop->user->profile_picture)
                                    <img src="{{ asset('storage/' . $shop->user->profile_picture) }}" width="540" height="720" loading="lazy" alt="{{ $shop->shop_name }}" class="img-cover">
                                @else
                                    <img src="{{ asset('images/default-shop.jpg') }}" width="540" height="720" loading="lazy" alt="{{ $shop->shop_name }}" class="img-cover">
                                @endif
                                <div class="card-actions">
                                    <a href="{{ route('shops.show', $shop->user_id) }}" class="action-btn" aria-label="view shop">
                                        <ion-icon name="eye-outline" aria-hidden="true"></ion-icon>
                                    </a>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="shop-header">
                                    <div class="shop-name">
                                        <span class="shop-label">Shop Name</span>
                                        <h3 class="shop-title">{{ $shop->shop_name }}</h3>
                                    </div>
                                    <div class="shop-owner">
                                        <span class="owner-label">Owner</span>
                                        <a href="{{ route('shops.show', $shop->user_id) }}" class="owner-name">
                                            @if($shop->user && $shop->user->profile_picture)
                                                <img src="{{ asset('storage/' . $shop->user->profile_picture) }}" alt="Profile" class="owner-avatar">
                                            @endif
                                            <span class="owner-name">{{ $shop->user->username ?? 'Shop Owner' }}</span>
                                        </a>
                                    </div>
                                </div>
                                
                                @if($shop->user && $shop->user->location)
                                    <div class="shop-info">
                                        <div class="info-item">
                                            <ion-icon name="location-outline"></ion-icon>
                                            <div class="info-content">
                                                <span class="info-label">Location</span>
                                                <span class="info-text">{{ $shop->user->location }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($shop->shop_description)
                                    <div class="shop-description">
                                        <span class="description-label">About Shop</span>
                                        <p class="description-text">{{ Str::limit($shop->shop_description, 100) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="scrollbar-item">
                        <div class="shop-card">
                            <div class="card-content">
                                <p>No shops available at the moment.</p>
                            </div>
                        </div>
                    </li>
                    @endforelse
                </ul>
            </div>
        </section>

        <section class="section banner" aria-label="banner">
            <div class="container">
                <ul class="banner-list">
                    <li>
                        <div class="banner-card banner-card-1 has-before hover:shine">
                            <p class="card-subtitle" style="color: whitesmoke;">Make an Order in Recyclo</p>
                            <h2 class="h2 card-title" style="color: whitesmoke;">Budget-Friendly Prices!</h2>
                            <a href="#" class="btn btn-secondary" style="display: flex; align-items: center; justify-content: center;">Order Now</a>
                            <div class="has-bg-image" style="background-image: url('images/rec.jpg')"></div>
                        </div>
                    </li>
                    <li>
                        <div class="banner-card banner-card-2 has-before hover:shine">
                            <h2 class="h2 card-title" style="color: green;">Recyclo</h2>
                            <p class="card-text">
                                In Recyclo, We practice proper and innovative ways to use recyclable materials.
                            </p>
                            <a href="#" class="btn btn-secondary" style="display: flex; align-items: center; justify-content: center;">Shop Sale</a>
                            <div class="has-bg-image" style="background-image: url('images/bag.jpg')"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <section class="section feature" aria-label="feature">
            <div class="container">
                <h2 class="h2-large section-title">Why Use Recyclo?</h2>
                <ul class="flex-list">
                    <li class="flex-item">
                        <div class="feature-card">
                            <img src="images/c1.png" width="204" height="236" loading="lazy" alt="Guaranteed PURE" class="card-icon">
                            <h3 class="h3 card-title">100% Recyclable Materials</h3>
                            <p class="card-text">
                                Throwaway materials can be much more and can be use in many different ways.
                            </p>
                        </div>
                    </li>
                    <li class="flex-item">
                        <div class="feature-card">
                            <img src="images/c2.png" width="204" height="236" loading="lazy" alt="Completely Cruelty-Free" class="card-icon">
                            <h3 class="h3 card-title">Pollution-Free</h3>
                            <p class="card-text">
                                We care not only for our users but for the entire world. Hence, we support a greener planet!
                            </p>
                        </div>
                    </li>
                    <li class="flex-item">
                        <div class="feature-card">
                            <img src="images/c3.png" width="204" height="236" loading="lazy" alt="Ingredient Sourcing" class="card-icon">
                            <h3 class="h3 card-title">Innovation</h3>
                            <p class="card-text">
                                An innovation lies hidden among these scraps.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        
        <section class="section offer" id="offer" aria-label="offer">
            <div class="container">
                <figure class="offer-banner">
                    <img src="images/r2.jpg" width="305" height="408" loading="lazy" alt="offer products" class="w-100">
                    <img src="images/r1.jpg" width="450" height="625" loading="lazy" alt="offer products" class="w-100">
                </figure>
                <div class="offer-content">
                    <p class="offer-subtitle">
                        <span class="span">Budget-Friendly Prices</span>
                        <span class="badge" aria-label="20% off">Plastic</span>
                        <span class="badge" aria-label="20% off">Wood</span>
                        <span class="badge" aria-label="20% off">Metals</span>
                        <span class="badge" aria-label="20% off">More!</span>
                    </p>
                    <h2 class="h2-large section-title">Products That Are Made Out Ff Solid Waste</h2>
                    <p class="section-text" style="color: black;">
                        Here are some examples of products that are recycled up using recyclable materials.
                    </p>
                    <div class="countdown">
                        <span class="time" aria-label="days">Reduce</span>
                        <span class="time" aria-label="hours">Reuse</span>
                        <span class="time" aria-label="minutes">Recycle</span>
                    </div>
                    <a href="#" class="btn btn-primary recyclo-shop-btn" style="display: flex; align-items: center; justify-content: center; padding: 12px 30px; text-align: center; width: 220px;">Shop Now In Recyclo</a>
                </div>
            </div>
        </section>
        
        <section class="section blog" id="blog" aria-label="blog">
            <div class="container">
                <h2 class="h2-large section-title">More about <span><img src="images/mainlogo.png" alt="logo" style="width: 50px; height: 50px; margin-left: 600px;"></span></h2>
                <ul class="flex-list">
                    <li class="flex-item">
                        <div class="blog-card">
                            <figure class="card-banner img-holder has-before hover:shine" style="--width: 700; --height: 450;">
                                <img src="images/m1.jpg" width="700" height="450" loading="lazy" alt="Find a Store" class="img-cover">
                            </figure>
                            <h3 class="h3">
                                <a href="#" class="card-title">Our Mission</a>
                            </h3>
                            <a href="#" class="btn-link">
                                <span class="span">View</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </li>
                    <li class="flex-item">
                        <div class="blog-card">
                            <figure class="card-banner img-holder has-before hover:shine" style="--width: 700; --height: 450;">
                                <img src="images/m2.jpg" width="700" height="450" loading="lazy" alt="From Our Blog" class="img-cover">
                            </figure>
                            <h3 class="h3">
                                <a href="#" class="card-title">Our Goals</a>
                            </h3>
                            <a href="#" class="btn-link">
                                <span class="span">View</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </li>
                    <li class="flex-item">
                        <div class="blog-card">
                            <figure class="card-banner img-holder has-before hover:shine" style="--width: 700; --height: 450;">
                                <img src="images/blog-3.jpg" width="700" height="450" loading="lazy" alt="Our Story" class="img-cover">
                            </figure>
                            <h3 class="h3">
                                <a href="#" class="card-title">Our Vision</a>
                            </h3>
                            <a href="#" class="btn-link">
                                <span class="span">View</span>
                                <ion-icon name="arrow-forward-outline" aria-hidden="true"></ion-icon>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </article>
</div>

<style>
/* Product slider fixes */
.product-slider {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    padding: 1rem 0;
    margin: 0 -8px;
    scroll-snap-type: x mandatory;
}

.product-slider .scrollbar-item {
    scroll-snap-align: start;
    flex: 0 0 auto;
}

.has-scrollbar {
    gap: 15px;
    scroll-padding-inline: 15px;
}

@media (min-width: 768px) {
    .has-scrollbar::-webkit-scrollbar-thumb { 
        background-color: hsl(0, 0%, 80%);
    }
}

/* Shop card fixes */
.shop-card {
    height: 100%;
    display: flex;
    flex-direction: column;
}
.card-banner {
    height: 360px;
    overflow: hidden;
}
.card-banner img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    object-position: center;
}
.card-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}
.scrollbar-item {
    width: calc(20% - 16px);
    min-width: 250px;
    margin-right: 16px;
}

@media (max-width: 992px) {
    .scrollbar-item {
        width: calc(33.333% - 16px);
    }
}

@media (max-width: 768px) {
    .scrollbar-item {
        width: calc(50% - 16px);
    }
}

@media (max-width: 480px) {
    .scrollbar-item {
        width: calc(100% - 16px);
    }
}

/* Additional styles for the Best Deals section */
.shop-info {
    margin: 10px 0;
    font-size: 0.9rem;
}

.shop-link {
    display: flex;
    align-items: center;
    color: var(--hoockers-green);
    text-decoration: none;
    margin-bottom: 5px;
    margin:auto;
    font-size: 16px;
}

.shop-link:hover {
    text-decoration: underline;
}

.location-info {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #666;
    font-size: 0.85rem;
}

.product-stats {
    margin-top: 10px;
    font-size: 0.9rem;
    color: #666;
}

.quantity {
    display: inline-block;
    padding: 4px 8px;
    background-color: #f5f5f5;
    border-radius: 4px;
    font-size: 16px;
    margin:auto;
}

.badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: var(--hoockers-green);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    text-transform: uppercase;
}

/* Best Deals Card Styles */
.shop-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.shop-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.card-banner {
    position: relative;
    overflow: hidden;
}

.card-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
}

.shop-card:hover .card-actions {
    opacity: 1;
    transform: translateX(0);
}

.action-btn {
    background: white;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: var(--hoockers-green);
    color: white;
}
#owner-name{
    margin:50px;
    font-size: 16px;
}
/* Shop Card Styles */
.shop-stats-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    padding: 20px;
    color: white;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.stat-item ion-icon {
    font-size: 20px;
}

.shop-preview {
    margin-top: 15px;
}

.preview-products {
    display: flex;
    gap: 8px;
}

.preview-product {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid var(--hoockers-green);
}

.preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Shop Card Styles */
.shop-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.shop-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.card-banner {
    position: relative;
    overflow: hidden;
    height: 360px;
}

.card-banner img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    object-position: center;
}

.card-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
}

.shop-card:hover .card-actions {
    opacity: 1;
    transform: translateX(0);
}

.action-btn {
    background: white;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: var(--hoockers-green);
    color: white;
}

.card-content {
    padding: 10px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.shop-header {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.shop-name {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.owner-name{
    margin:auto;
}

.shop-label, .owner-label, .info-label, .description-label {
    font-size: 14px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.shop-title {
    font-size: 24px;
    font-weight: 700;
    color: var(--rich-black-fogra-29);
    margin: 0;
    line-height: 1.2;
}

.shop-owner {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.owner-name {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: var(--hoockers-green);
    font-weight: 600;
    font-size: 18px;
}

.owner-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
}

.shop-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.info-item ion-icon {
    font-size: 20px;
    color: var(--hoockers-green);
    margin-top: 2px;
}

.info-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.info-text {
    font-size: 16px;
    color: var(--rich-black-fogra-29);
    line-height: 1.4;
}

.shop-description {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.description-text {
    font-size: 15px;
    color: #666;
    line-height: 1.5;
    margin: 0;
}

.scrollbar-item {
    width: calc(20% - 16px);
    min-width: 300px;
    margin-right: 16px;
}

@media (max-width: 992px) {
    .scrollbar-item {
        width: calc(33.333% - 16px);
    }
}

@media (max-width: 768px) {
    .scrollbar-item {
        width: calc(50% - 16px);
    }
}

@media (max-width: 480px) {
    .scrollbar-item {
        width: calc(100% - 16px);
    }
}

/* Add these new styles */
.shop-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}

.shop-card-link:hover {
    text-decoration: none;
    color: inherit;
}

.shop-card {
    height: 100%;
    cursor: pointer;
}

.shop-link {
    position: relative;
    z-index: 2;
}
</style>
@endsection