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
      <div class="title-wrapper">
        <h2 class="h2 section-title">{{ $shop->username }}'s Shop</h2>
        <a href="{{ route('posts.user', $shop) }}" class="btn-link">
          <span class="span">View All Products</span>
          <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
        </a>
      </div>
      <ul class="has-scrollbar">
        @foreach ($shop->posts as $post)       
          <li class="scrollbar-item">
            <x-postCard :post="$post"/>
          </li>
        @endforeach
        
        @if($shop->posts->isEmpty())
          <li class="scrollbar-item">
            <p>No products available in this shop yet.</p>
          </li>
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
@endsection
