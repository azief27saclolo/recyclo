@extends('components.layout')

@section('content')
<div class="container">
  <section class="section shop" id="shop" aria-label="shop">
    <div class="container">
      <div class="title-wrapper">
        <h2 class="h2 section-title">All Shops</h2>
      </div>
    </div>
  </section>

  @foreach($shops as $shop)
  <section class="section shop" id="shop-{{ $shop->id }}" aria-label="shop">
    <div class="container">
      <div class="shop-title-wrapper">
        <h2 class="h2 shop-name">{{ $shop->username }}'s Shop</h2>
        <a href="{{ route('posts.user', $shop) }}" class="btn-link">
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
      <h3 class="mb-4">No shops available at the moment.</h3>
      <p>Be the first to create a shop and start selling!</p>
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
    margin-top: 5px; /* Reduced to bring slider closer to title */
  }

  /* Custom shop title styling */
  .shop-title-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px; /* Reduced from default to bring slider closer */
    border-bottom: 2px solid #e7e7e7;
    padding-bottom: 6px;
  }

  .shop-name {
    font-size: 2.2rem !important; /* Bigger font size */
    font-weight: 700;
    color: #1e6f31; /* Green to match Recyclo theme */
    margin-bottom: 0;
    text-transform: capitalize;
  }

  /* Keep other styles */
  .shop-slider .scrollbar-item {
    flex: 0 0 auto;
    width: 220px; /* reduced from 300px */
    margin-right: 12px; /* reduced from 15px */
    scroll-snap-align: start;
  }

  .shop-slider .placeholder-item {
    visibility: hidden;
    min-width: 200px; /* reduced from 270px */
  }

  .empty-shop-card {
    width: 200px; /* reduced from 270px */
    height: 280px; /* reduced from 360px */
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px dashed #ccc;
    border-radius: 8px;
    text-align: center;
    padding: 20px;
    background-color: #f9f9f9;
  }

  /* Make sure scrollbar is always visible when needed */
  .has-scrollbar::-webkit-scrollbar {
    height: 6px; /* reduced from 8px */
    width: 6px; /* reduced from 8px */
  }

  /* Shop section margin adjustments */
  #shop .container {
    max-width: 95%; /* increase container width for more items */
  }
  
  .section.shop {
    padding-top: 30px; /* reduced top padding */
    padding-bottom: 30px; /* reduced bottom padding */
  }
  
  /* Adjust spacing between shop sections */
  .section.shop + .section.shop {
    margin-top: 10px;
    padding-top: 15px; /* Further reduce padding between shops */
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
</style>
@endsection
