@extends('components.layout')

@section('content')
<div class="container">
  <div>
    <section class="section collection" id="collection" aria-label="collection">
      <div class="container">
        <ul class="collection-list">
          <li>
            <div class="collection-card has-before hover:shine">
              <h2 class="h2 card-title">Recyclable Materials</h2>
              <p class="card-text">All sorts of solid waste awaits!</p>
              <a href="#" class="btn-link">
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
              <a href="#" class="btn-link">
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
              <a href="#" class="btn-link">
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
          <h2 class="h2 section-title">Latest Listings</h2>
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
          <h2 class="h2 section-title">Budget Friendly Products</h2>
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

  </div>
@endsection