@extends('components.layout')

@section('content')
<div class="container">
  <section class="section shop" id="shop" aria-label="shop">
    <div class="container">
      <div class="title-wrapper">
        <h2 class="h2 section-title">Available shops for you to check out</h2>
        <p class="section-subtitle">Discover our verified sellers and their products</p>
      </div>
    </div>
  </section>

  @foreach($shops as $shop)
    <section class="section shop" id="shop-{{ $shop->id }}" aria-label="shop">
      <div class="container">
        <div class="shop-title-wrapper">
          <div class="shop-info">
            <h2 class="h2 shop-name">{{ $shop->shop->shop_name ?? $shop->username }}'s Shop</h2>
            <p class="shop-location">
              <ion-icon name="location-outline"></ion-icon>
              {{ $shop->shop->shop_address ?? 'Location not specified' }}
            </p>
          </div>
          <a href="{{ route('shops.show', $shop) }}" class="btn-link">
            <span class="span">View Shop</span>
            <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
          </a>
        </div>
        <ul class="has-scrollbar shop-slider">
          @foreach ($shop->posts as $post)       
            <li class="scrollbar-item">
              <x-postCard :post="$post"/>
            </li>
          @endforeach
          
          @if($shop->posts->isEmpty())
            <li class="scrollbar-item">
              <div class="empty-shop-card">
                <ion-icon name="alert-circle-outline" class="empty-icon"></ion-icon>
                <p>No products available in this shop yet.</p>
              </div>
            </li>
          @endif
          
          {{-- Add placeholder items for shops with few products to ensure slider works --}}
          @if($shop->posts->count() > 0 && $shop->posts->count() < 5)
            @for($i = 0; $i < (5 - $shop->posts->count()); $i++)
              <li class="scrollbar-item placeholder-item"></li>
            @endfor
          @endif
        </ul>
      </div>
    </section>
  @endforeach

  @if($shops->isEmpty())
    <div class="container text-center py-8">
      <div class="empty-state">
        <ion-icon name="storefront-outline" class="empty-icon"></ion-icon>
        <h3 class="mb-4">No shops available at the moment.</h3>
        <p>Be the first to create a shop and start selling!</p>
      </div>
    </div>
  @endif
</div>

<style>
  /* Ensure slider works with any number of products */
  .shop-slider {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    margin-top: 5px;
    padding: 10px 0;
  }

  /* Custom shop title styling */
  .shop-title-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    border-bottom: 2px solid #e7e7e7;
    padding-bottom: 12px;
  }

  .shop-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .shop-name {
    font-size: 2.2rem !important;
    font-weight: 700;
    color: #1e6f31;
    margin-bottom: 0;
    text-transform: capitalize;
  }

  .shop-location {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #666;
    font-size: 0.9rem;
    margin: 0;
  }

  .section-subtitle {
    color: #666;
    text-align: center;
    margin-top: 8px;
  }

  /* Keep other styles */
  .shop-slider .scrollbar-item {
    flex: 0 0 auto;
    width: 220px;
    margin-right: 12px;
    scroll-snap-align: start;
  }

  .shop-slider .placeholder-item {
    visibility: hidden;
    min-width: 200px;
  }

  .empty-shop-card {
    width: 200px;
    height: 280px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 1px dashed #ccc;
    border-radius: 8px;
    text-align: center;
    padding: 20px;
    background-color: #f9f9f9;
    gap: 8px;
  }

  .empty-icon {
    font-size: 2rem;
    color: #999;
  }

  .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    padding: 40px 20px;
    background: #f9f9f9;
    border-radius: 12px;
    margin: 20px 0;
  }

  .empty-state .empty-icon {
    font-size: 4rem;
    color: #1e6f31;
  }

  /* Make sure scrollbar is always visible when needed */
  .has-scrollbar::-webkit-scrollbar {
    height: 6px;
    width: 6px;
  }

  /* Shop section margin adjustments */
  #shop .container {
    max-width: 95%;
  }
  
  .section.shop {
    padding-top: 30px;
    padding-bottom: 30px;
  }
  
  /* Adjust spacing between shop sections */
  .section.shop + .section.shop {
    margin-top: 10px;
    padding-top: 15px;
  }

  /* Scrollbar styles */
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

  /* Button link styling */
  .btn-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 8px 16px;
    background-color: #1e6f31;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s ease;
  }

  .btn-link:hover {
    background-color: #155028;
  }

  .btn-link ion-icon {
    font-size: 1.2rem;
  }
</style>
@endsection
