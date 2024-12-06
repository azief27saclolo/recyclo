@props(['post'])

<a href="{{ route('posts.show', $post) }}">
    <div class="shop-card">

        <div class="card-banner img-holder" style="--width: 540; --height: 720;">
          <img src="{{ asset('storage/' . $post->image) }}" width="540" height="720" loading="lazy"
            alt="Facial cleanser" class="img-cover">

          <span class="badge" aria-label="20% off">{{ $post->category }}</span>
          <div class="card-actions">

            <button class="action-btn" aria-label="add to cart">
              <ion-icon name="cart" aria-hidden="true"></ion-icon>
            </button>

            <button class="action-btn" aria-label="add to whishlist">
              <ion-icon name="heart" aria-hidden="true"></ion-icon>
            </button>

            <button class="action-btn" aria-label="compare">
              <ion-icon name="repeat" aria-hidden="true"></ion-icon>
            </button>

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