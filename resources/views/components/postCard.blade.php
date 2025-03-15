@props(['post', 'class' => ''])

<a href="{{ route('posts.show', $post) }}" class="{{ $class }}">
    <div class="shop-card">

        <div class="card-banner img-holder" style="--width: 270; --height: 360;">
          <img src="{{ asset('storage/' . $post->image) }}" width="270" height="360" loading="lazy"
            alt="Facial cleanser" class="img-cover" style="object-fit: cover; width: 100%; height: 100%;">

          <span class="badge" aria-label="20% off">{{ $post->category }}</span>
          <div class="card-actions">

            <form action="#" method="POST">
              @csrf
              <button class="action-btn" aria-label="add to cart">
                <ion-icon name="cart" aria-hidden="true"></ion-icon>
              </button>
            </form>

            <form action="{{ route('favorites.add', $post) }}" method="POST" id="favorite-form-{{ $post->id }}">
                @csrf
                <button type="submit" class="action-btn" aria-label="add to wishlist">
                    <ion-icon name="heart" aria-hidden="true"></ion-icon>
                </button>
            </form>

            {{-- <button class="action-btn" aria-label="compare">
              <ion-icon name="repeat" aria-hidden="true"></ion-icon>
            </button> --}}

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

@if(session('success'))
    <div id="flash-message" class="popup-message {{ session('type') }}">
        {{ session('success') }}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                var flashMessage = document.getElementById('flash-message');
                if (flashMessage) {
                    flashMessage.remove();
                }
            }, 2000); // 2 seconds before removing
        });
    </script>
@endif

<style>
.popup-message {
    position: fixed;
    top: 20px;
    right: 20px;
    color: white;
    padding: 10px;
    border-radius: 5px;
    z-index: 1000;
}
.popup-message.success {
    background-color: #28a745;
}
.popup-message.error {
    background-color: red;
}

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
</style>