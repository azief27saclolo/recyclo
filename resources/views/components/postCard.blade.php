@props(['post', 'class' => ''])

<a href="{{ route('posts.show', $post) }}" class="{{ $class }}">
    <div class="shop-card">
        <div class="card-banner img-holder" style="--width: 270; --height: 360;">
          <img src="{{ asset('storage/' . $post->image) }}" width="270" height="360" loading="lazy"
            alt="{{ $post->title }}" class="img-cover" style="object-fit: cover; width: 100%; height: 100%; max-height: 360px;">

          <span class="badge" aria-label="20% off">{{ $post->category }}</span>
          <div class="card-actions">
            <form action="{{ route('cart.index') }}" method="POST" class="cart-form">
              @csrf
              <input type="hidden" name="product_id" value="{{ 
                \App\Models\Product::firstOrCreate(
                    ['name' => $post->title, 'user_id' => $post->user_id],
                    [
                        'description' => $post->description,
                        'price' => $post->price,
                        'image' => $post->image,
                        'stock' => !empty($post->quantity) && is_numeric($post->quantity) ? (int)$post->quantity : 1
                    ]
                )->id 
              }}">
              <input type="number" name="quantity" value="1" hidden>
              <button type="button" class="action-btn" aria-label="add to cart" 
                     data-product-id="{{ 
                        \App\Models\Product::firstOrCreate(
                            ['name' => $post->title, 'user_id' => $post->user_id],
                            [
                                'description' => $post->description,
                                'price' => $post->price,
                                'image' => $post->image,
                                'stock' => !empty($post->quantity) && is_numeric($post->quantity) ? (int)$post->quantity : 1
                            ]
                        )->id 
                     }}"
                     data-product-name="{{ $post->title }}"
                     data-product-image="{{ asset('storage/' . $post->image) }}"
                     data-product-price="{{ number_format($post->price, 2) }}">
                <ion-icon name="cart" aria-hidden="true"></ion-icon>
              </button>
            </form>

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
            <a href="{{ route('posts.user', $post->user) }}" class="card-title">{{ $post->user->username }}'s Shop</a>
          </h3>

          <div class="card-rating">
            <div class="rating-wrapper" aria-label="5 start rating">
              <ion-icon name="star" aria-hidden="true"></ion-icon>
              <ion-icon name="star" aria-hidden="true"></ion-icon>
              <ion-icon name="star" aria-hidden="true"></ion-icon>
              <ion-icon name="star" aria-hidden="true"></ion-icon>
              <ion-icon name="star" aria-hidden="true"></ion-icon>
            </div>

            <p class="rating-text">5170 reviews</p>
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