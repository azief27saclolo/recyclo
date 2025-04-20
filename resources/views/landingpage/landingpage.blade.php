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

        {{-- User's Posts --}}
        <section class="section shop" id="shop" aria-label="shop">
            <div class="container">
                <div class="title-wrapper">
                    <h2 class="h2 section-title">Best Deals</h2>
                    <a href="{{ route('posts') }}" class="btn-link">
                        <span class="span">View More Products</span>
                        <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                    </a>
                </div>
                <ul class="has-scrollbar">
                    @foreach ($posts as $post)       
                        <li class="scrollbar-item">
                            <x-postCard :post="$post"/>
                        </li>
                    @endforeach
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
                                <img src="{{ asset('images/f' . ($loop->iteration % 6 + 1) . '.jpg') }}" width="540" height="720" loading="lazy" alt="{{ $shop->shop_name }}" class="img-cover">
                                @endif
                                <div class="card-actions">
                                    <a href="{{ route('shops.show', $shop->user_id) }}" class="action-btn" aria-label="view shop">
                                        <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                                    </a>
                                    <button class="action-btn" aria-label="favorite shop">
                                        <ion-icon name="heart-outline" aria-hidden="true"></ion-icon>
                                    </button>
                                    <button class="action-btn" aria-label="contact shop">
                                        <ion-icon name="chatbubble-outline" aria-hidden="true"></ion-icon>
                                    </button>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="price">
                                    <span class="span">{{ $shop->shop_name }}</span>
                                </div>
                                <h3>
                                    <a href="{{ route('shops.show', $shop->user_id) }}" class="card-title">
                                        @if($shop->user && $shop->user->profile_picture)
                                        <img src="{{ asset('storage/' . $shop->user->profile_picture) }}" alt="Profile" class="shop-profile-pic" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 8px; vertical-align: middle;">
                                        @endif
                                        {{ $shop->user->username ?? 'Shop' }}'s Shop
                                    </a>
                                </h3>
                                <div class="card-rating">
                                    <div class="rating-wrapper" aria-label="5 start rating">
                                        <ion-icon name="star" aria-hidden="true"></ion-icon>
                                        <ion-icon name="star" aria-hidden="true"></ion-icon>
                                        <ion-icon name="star" aria-hidden="true"></ion-icon>
                                        <ion-icon name="star" aria-hidden="true"></ion-icon>
                                        <ion-icon name="star" aria-hidden="true"></ion-icon>
                                    </div>
                                    <p class="rating-text">{{ random_int(10, 500) }} reviews</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                        @for ($i = 1; $i <= 6; $i++)
                        <li class="scrollbar-item">
                            <div class="shop-card">
                                <div class="card-banner img-holder" style="--width: 540; --height: 720;">
                                    <img src="images/f{{ $i }}.jpg" width="540" height="720" loading="lazy" alt="Shop Image" class="img-cover">
                                    <div class="card-actions">
                                        <button class="action-btn" aria-label="add to cart">
                                            <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                                        </button>
                                        <button class="action-btn" aria-label="add to whishlist">
                                            <ion-icon name="heart-outline" aria-hidden="true"></ion-icon>
                                        </button>
                                        <button class="action-btn" aria-label="compare">
                                            <ion-icon name="repeat-outline" aria-hidden="true"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="price">
                                        <span class="span">Sample Shop {{ $i }}</span>
                                    </div>
                                    <h3>
                                        <a href="#" class="card-title">Sample Shop {{ $i }}</a>
                                    </h3>
                                    <div class="card-rating">
                                        <div class="rating-wrapper" aria-label="5 start rating">
                                            <ion-icon name="star" aria-hidden="true"></ion-icon>
                                            <ion-icon name="star" aria-hidden="true"></ion-icon>
                                            <ion-icon name="star" aria-hidden="true"></ion-icon>
                                            <ion-icon name="star" aria-hidden="true"></ion-icon>
                                            <ion-icon name="star" aria-hidden="true"></ion-icon>
                                        </div>
                                        <p class="rating-text">{{ random_int(10, 500) }} reviews</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endfor
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
  @endsection