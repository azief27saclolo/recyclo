@props(['post', 'class' => ''])

@php
    try {
        // Ensure product relationship is loaded
        if (!$post->relationLoaded('product')) {
            $post->load('product');
        }
        
        // Create product if it doesn't exist
        if (!$post->product) {
            $product = \App\Models\Product::firstOrCreate(
                ['post_id' => $post->id],
                [
                    'name' => $post->title,
                    'description' => $post->description,
                    'price' => $post->price,
                    'image' => $post->image,
                    'user_id' => $post->user_id,
                    'stock' => $post->quantity
                ]
            );
            $post->setRelation('product', $product);
        }

        // Load reviews if not loaded
        if (!$post->relationLoaded('reviews')) {
            $post->load('reviews');
        }

        // Calculate average rating and review count
        $reviews = $post->reviews ?? collect();
        $averageRating = $reviews->avg('rating') ?? 0;
        $reviewCount = $reviews->count();
    } catch (\Exception $e) {
        // If anything fails, set default values
        $averageRating = 0;
        $reviewCount = 0;
        \Log::error('Error in postCard component: ' . $e->getMessage());
    }
@endphp

<a href="{{ route('posts.show', $post) }}" class="{{ $class }}">
    <div class="shop-card">
        <div class="card-banner img-holder" style="--width: 270; --height: 360;">
          <img src="{{ asset('storage/' . $post->image) }}" width="270" height="360" loading="lazy"
            alt="{{ $post->title }}" class="img-cover" style="object-fit: cover; width: 100%; height: 100%; max-height: 360px;">

          <span class="badge" aria-label="20% off">{{ $post->category }}</span>
          <div class="card-actions">
            @if($post->product && $post->product->post)
            <form action="{{ route('cart.add') }}" method="POST" class="cart-form">
              @csrf
              <input type="hidden" name="product_id" value="{{ $post->product->id }}">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" class="action-btn" aria-label="add to cart" 
                data-product-id="{{ $post->product->id }}"
                data-product-name="{{ $post->title }}"
                data-product-image="{{ asset('storage/' . $post->image) }}"
                data-product-price="{{ $post->price }}">
                <ion-icon name="cart" aria-hidden="true"></ion-icon>
              </button>
            </form>
            @endif

            <form action="{{ route('favorites.add', $post) }}" method="POST" id="favorite-form-{{ $post->id }}">
                @csrf
                <button type="submit" class="action-btn" aria-label="add to wishlist">
                    <ion-icon name="heart" aria-hidden="true"></ion-icon>
                </button>
            </form>
          </div>
        </div>

        <div class="card-content">
          <div class="price">
            <span class="span">₱{{ $post->price }}.00</span>
          </div>

          <h3>
            <a href="{{ route('posts.show', $post) }}" class="card-title">{{ $post->title }}</a>
          </h3>
          <h3>
            <a href="{{ route('shops.show', $post->user) }}" class="card-title">{{ $post->user->username }}'s Shop</a>
          </h3>

          <div class="card-rating">
            <div class="rating-wrapper" aria-label="{{ number_format($averageRating, 1) }} star rating">
              @for ($i = 1; $i <= 5; $i++)
                <ion-icon name="star" aria-hidden="true" class="{{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}"></ion-icon>
              @endfor
            </div>

            <p class="rating-text">{{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</p>
          </div>
        </div>
      </div>
</a>

<style>
/* Fix for overlapping buttons */
.card-actions {
    display: flex !important;
    flex-direction: column !important;
    gap: 10px !important;
}
.card-actions form {
    margin: 0;
    padding: 0;
    width: auto;
    height: auto;
}
.card-actions .action-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 48px;
    height: 48px;
}

/* Fix for slider product cards */
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
</style>