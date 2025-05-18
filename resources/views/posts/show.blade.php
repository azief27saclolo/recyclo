@extends('components.layout')

@section('content')
<div class="container">
    <!-- Add SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <section class="section shop" id="shop" aria-label="shop">
        <div class="container">

          <div class="title-wrapper" style="display: flex; align-items: flex-start;">
            <div class="image-container" style="width: 500px; height: 350px; margin-right: 25px; overflow: hidden; border-radius: 12px; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9;">
              <img src="{{ asset('storage/' . $post->image) }}" alt="Shop Image" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            <div>
              <h2 class="h2 section-title">{{ $post->title }}</h2>
              <h1 style="font-weight: 200; margin-bottom: 10px;">
                <i class="bi bi-compass"></i>{{ $post->location }}<br>
                <i class="bi bi-telephone-inbound"></i>{{ $post->user->number }}<br>
              </h1>

              <h1>Price: </h1>
              <h1 style="color: black;">{{ $post->price }}.00</h1>
              
              <h1>Available Stock: </h1>
              <h1 style="color: black;">
                {{ $post->quantity }} {{ $post->unit }}
              </h1>

              <h1>Description: </h1>
              <p style="color: black;">{{ $post->description }}</p>

              <div style="display: flex; align-items: center;">
                <h1 style="color: black;">  Quantity ({{ $post->unit }}): </h1>
                <button onclick="decreaseQuantity()" style="margin-left: 10px;padding: 7px 10px; font-size: 1rem; border-radius: 25px;">-</button>
                <input type="number" id="quantity" value="1" min="1" max="{{ $post->quantity }}" style="width: 50px; text-align: center; margin: 0 10px; border: 1px solid black; border-radius: 10px; ">
                <button onclick="increaseQuantity()" style="margin-right: 10px; padding: 7px 10px; font-size: 1rem; border-radius: 25px; ">+</button>
                <a href="#" class="btn btn-primary" onclick="addToCart(event)" style="width: 400px; height: 45px; border-radius: 30px; margin-right: 10px;">Add to Cart</a>
                <a href="#" onclick="redirectToCheckout()" class="btn btn-primary" style="width: 400px; height: 45px; border-radius: 30px;">Check Out</a>
              </div>
              <div id="stockWarning" style="margin-top: 10px; color: #dc3545; font-weight: 500; display: none;"></div>
            </div>
          </div>

        <!-- Similar Products section with shops-style slider -->
        <section class="section similar-products" id="similar-products" aria-label="similar products">
            <div class="container">
                <div class="shop-title-wrapper">
                    <h2 class="h2 shop-name">More {{ ucfirst($post->category) }} Products</h2>
                    <a href="{{ route('posts', ['category' => $post->category]) }}" class="btn-link">
                        <span class="span">View All {{ ucfirst($post->category) }}</span>
                        <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                    </a>
                </div>
                <ul class="has-scrollbar shop-slider">
                    @php
                        // Filter posts to only include those with the same category
                        $similarCategoryPosts = $posts->filter(function($similarPost) use ($post) {
                            return $similarPost->id != $post->id && $similarPost->category == $post->category;
                        });
                        
                        // Count how many valid products we have
                        $displayCount = $similarCategoryPosts->count();
                    @endphp
                    
                    @if($displayCount > 0)
                        @foreach($similarCategoryPosts as $similarPost)
                            <li class="scrollbar-item">
                                <x-postCard :post="$similarPost"/>
                            </li>
                        @endforeach
                        
                        {{-- Add placeholder items if needed to maintain slider appearance --}}
                        @if($displayCount < 5)
                            @for($i = 0; $i < (5 - $displayCount); $i++)
                                <li class="scrollbar-item placeholder-item"></li>
                            @endfor
                        @endif
                    @else
                        <li class="scrollbar-item">
                            <div class="empty-shop-card">
                                <p>No other {{ $post->category }} products available at the moment.</p>
                            </div>
                        </li>
                        {{-- Add placeholders to maintain slider width --}}
                        @for($i = 0; $i < 4; $i++)
                            <li class="scrollbar-item placeholder-item"></li>
                        @endfor
                    @endif
                </ul>
            </div>
        </section>
        </div>
      </section>

      <section class="section feedback" id="feedback" aria-label="feedback">
        <div class="container" style="border: 2px solid var(--hoockers-green); padding: 20px; border-radius: var(--radius-3); position: relative; min-height: 400px;">
          <div class="title-wrapper">
            <h2 class="h2 section-title">Feedback & Reviews</h2>
          </div>

          @auth
            <div class="review-form" style="margin-bottom: 30px; padding: 25px; background: #f9f9f9; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.1);">
              <h3 style="margin-bottom: 20px; color: var(--hoockers-green); font-size: 1.5rem;">Write a Review</h3>
              <form action="{{ route('reviews.store', $post) }}" method="POST" id="reviewForm">
                @csrf
                <div style="margin-bottom: 20px;">
                  <label style="display: block; margin-bottom: 10px; font-weight: 500; color: #333;">Rating:</label>
                  <div class="rating" style="display: flex; gap: 5px; font-size: 30px; position: relative;">
                    @for($i = 5; $i >= 1; $i--)
                      <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                      <label for="star{{ $i }}" style="cursor: pointer; color: #ddd; transition: all 0.2s ease; position: relative; z-index: 1;">★</label>
                    @endfor
                    <div id="ratingHighlight" style="position: absolute; top: 0; left: 0; height: 100%; background: linear-gradient(90deg, #ffd700 0%, #ffd700 0%, #ddd 0%); transition: width 0.3s ease; pointer-events: none; z-index: 0;"></div>
                  </div>
                  <div id="ratingText" style="margin-top: 5px; color: #666; font-size: 0.9rem;"></div>
                </div>
                <div style="margin-bottom: 20px;">
                  <label for="comment" style="display: block; margin-bottom: 10px; font-weight: 500; color: #333;">Your Review:</label>
                  <textarea name="comment" id="comment" rows="4" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; resize: vertical; transition: border-color 0.3s;" required minlength="10" maxlength="500" placeholder="Share your experience with this product..."></textarea>
                  <div id="charCount" style="text-align: right; margin-top: 5px; color: #666; font-size: 0.9rem;">0/500 characters</div>
                </div>
                <button type="submit" class="btn btn-primary" style="background-color: var(--hoockers-green); color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;">Submit Review</button>
              </form>
            </div>
          @endauth
      
          <!-- Feedback List -->
          <ul class="feedback-list" id="feedback-list" style="overflow-y: auto; max-height: 400px; margin-top: 20px; padding: 10px;">
            @forelse($post->reviews()->with('user')->latest()->get() as $review)
              <li class="feedback-item" style="margin-bottom: 20px;">
                <div class="feedback-card" style="border: 1px solid var(--light-gray); padding: 20px; border-radius: 12px; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                  <div style="display: flex; align-items: flex-start; gap: 15px;">
                    <img src="{{ asset('images/default-avatar.jpg') }}" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    <div style="flex: 1;">
                      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <h3 class="feedback-title" style="margin: 0; color: #333; font-size: 1.25rem; font-weight: 600;">{{ $review->user->firstname }} {{ $review->user->lastname }}</h3>
                        <div class="feedback-rating" style="display: inline-flex; align-items: center; gap: 3px;">
                          @for($i = 1; $i <= 5; $i++)
                            <ion-icon name="star" aria-hidden="true" style="color: {{ $i <= $review->rating ? '#ffd700' : '#ddd' }}; font-size: 1.4rem;"></ion-icon>
                          @endfor
                        </div>
                      </div>
                      <p class="feedback-text" style="margin: 0 0 12px 0; color: #444; line-height: 1.6; font-size: 1.1rem;">{{ $review->comment }}</p>
                      <small style="color: #777; font-size: 0.95rem; font-weight: 500;">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                  </div>
                </div>
              </li>
            @empty
              <li class="feedback-item">
                <div class="feedback-card" style="border: 1px solid var(--light-gray); padding: 20px; border-radius: 12px; text-align: center; background: white;">
                  <p style="margin: 0; color: #666;">No reviews yet. Be the first to review this product!</p>
                </div>
              </li>
            @endforelse
          </ul>
        </div>
      </section>

      <script src="./assets/js/script.js" defer></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script>
    function increaseQuantity() {
      var quantity = document.getElementById('quantity');
      var maxQuantity = {{ $post->quantity }};
      if (parseInt(quantity.value) < maxQuantity) {
        quantity.value = parseInt(quantity.value) + 1;
        updateStockWarning();
      } else {
        Swal.fire({
            title: 'Stock Limit',
            text: 'Not enough stock! Only ' + maxQuantity + ' {{ $post->unit }} available.',
            icon: 'warning',
            confirmButtonColor: '#517A5B',
            customClass: {
                popup: 'extra-large-modal'
            }
        });
      }
    }

    function decreaseQuantity() {
      var quantity = document.getElementById('quantity');
      if (quantity.value > 1) {
        quantity.value = parseInt(quantity.value) - 1;
        updateStockWarning();
      }
    }

    // Validate quantity doesn't exceed available stock
    document.getElementById('quantity').addEventListener('change', function() {
      var maxQuantity = {{ $post->quantity }};
      if (parseInt(this.value) > maxQuantity) {
        this.value = maxQuantity;
        Swal.fire({
            title: 'Stock Limit',
            text: 'Not enough stock! Only ' + maxQuantity + ' {{ $post->unit }} available.',
            icon: 'warning',
            confirmButtonColor: '#517A5B',
            customClass: {
                popup: 'extra-large-modal'
            }
        });
      }
      updateStockWarning();
    });

    function updateStockWarning() {
      var quantity = parseInt(document.getElementById('quantity').value);
      var maxQuantity = {{ $post->quantity }};
      var stockWarning = document.getElementById('stockWarning');
      
      if (quantity > maxQuantity) {
        stockWarning.style.display = 'block';
        stockWarning.innerHTML = 'Not enough stock! Only ' + maxQuantity + ' {{ $post->unit }} available.';
      } else {
        stockWarning.style.display = 'none';
      }
    }

    function redirectToCheckout() {
        var quantity = document.getElementById('quantity').value;
        var url = "{{ route('orders.checkout') }}?post_id={{ $post->id }}&quantity=" + quantity + "&direct=1";
        window.location.href = url;
    }

    function placeOrder() {
        var quantity = document.getElementById('quantity').value;
        var post_id = "{{ $post->id }}";
        fetch("{{ route('orders.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ post_id: post_id, quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Order placed successfully!");
                window.location.href = "{{ route('posts') }}";
            } else {
                alert("Failed to place order.");
            }
        });
    }

    // New function to add item to cart with SweetAlert2
    function addToCart(event) {
        event.preventDefault();
        
        var quantity = parseInt(document.getElementById('quantity').value);
        var maxQuantity = {{ $post->quantity }};
        
        // Check if quantity exceeds available stock
        if (quantity > maxQuantity) {
            Swal.fire({
                title: 'Error',
                text: 'Not enough stock! Only ' + maxQuantity + ' {{ $post->unit }} available.',
                icon: 'error',
                confirmButtonColor: '#517A5B',
                customClass: {
                    popup: 'extra-large-modal'
                }
            });
            return;
        }
        
        // Show loading indicator via SweetAlert2
        Swal.fire({
            title: 'Adding to Cart...',
            text: 'Please wait',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            },
            heightAuto: false,
            customClass: {
                popup: 'bigger-modal'
            }
        });
        
        // Send AJAX request to add to cart
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: '{{ $post->product->id }}',
                quantity: quantity
            })
        })
        .then(response => {
            if (response.status === 401) {
                // Handle unauthenticated error
                Swal.fire({
                    title: 'Login Required',
                    text: 'You must be login to buy',
                    icon: 'warning',
                    confirmButtonColor: '#517A5B',
                    customClass: {
                        popup: 'bigger-modal'
                    }
                }).then(() => {
                    // Add 3 second delay before redirecting
                    Swal.fire({
                        title: 'Redirecting...',
                        text: 'Please wait while we redirect you to the login page',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        customClass: {
                            popup: 'bigger-modal'
                        }
                    }).then(() => {
                        window.location.href = '{{ route("login") }}';
                    });
                });
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message || 'Item added to cart successfully!',
                    icon: 'success',
                    confirmButtonColor: '#517A5B',
                    customClass: {
                        popup: 'bigger-modal'
                    }
                }).then(() => {
                    window.location.href = '{{ route("cart.index") }}';
                });
            } else {
                throw new Error(data.message || 'Failed to add item to cart');
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: error.message || 'Something went wrong. Please try again.',
                icon: 'error',
                confirmButtonColor: '#517A5B',
                customClass: {
                    popup: 'bigger-modal'
                }
            });
        });
    }
  </script>
  
  <!-- Success/error messages handling -->
  @if(session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#517A5B',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'bigger-modal'
            }
        });
    </script>
  @endif
  
  @if(session('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonColor: '#517A5B',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'bigger-modal'
            }
        });
    </script>
  @endif

  <style>
    button:hover {
      background-color: var(--hoockers-green);
      color: var(--white);
    }
    
    /* Remove stock indicator styling that's no longer needed */
    
    /* Similar Products section styling */
    .similar-products {
      margin: 40px 0;
    }
    
    .similar-products .has-scrollbar {
      display: flex;
      gap: 15px;
      overflow-x: auto;
      scrollbar-width: thin;
      padding: 10px 0;
    }
    
    .similar-products .has-scrollbar::-webkit-scrollbar {
      height: 8px;
    }
    
    .similar-products .has-scrollbar::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    
    .similar-products .has-scrollbar::-webkit-scrollbar-thumb {
      background: var(--hoockers-green);
      border-radius: 10px;
    }
    
    .similar-products .shop-card {
      min-width: 220px;
      transition: transform 0.3s ease;
    }
    
    .similar-products .shop-card:hover {
      transform: translateY(-5px);
    }
    
    .similar-products .card-banner {
      position: relative;
      overflow: hidden;
      border-radius: 8px;
    }
    
    .similar-products .card-actions {
      position: absolute;
      bottom: 10px;
      right: 10px;
      display: flex;
      gap: 5px;
    }
    
    .similar-products .action-btn {
      background-color: white;
      color: var(--hoockers-green);
      width: 35px;
      height: 35px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: all 0.3s ease;
    }
    
    .similar-products .action-btn:hover {
      background-color: var(--hoockers-green);
      color: white;
    }

    /* Shop-style slider styling for similar products */
    .shop-slider {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        margin-top: 5px;
    }

    /* Custom shop title styling */
    .shop-title-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        border-bottom: 2px solid #e7e7e7;
        padding-bottom: 6px;
    }

    .shop-name {
        font-size: 2.2rem !important;
        font-weight: 700;
        color: #1e6f31;
        margin-bottom: 0;
        text-transform: capitalize;
    }

    /* Shop slider item styling */
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
        height: 6px;
        width: 6px;
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
    
    /* Adjust spacing for similar products section */
    .section.similar-products {
        padding-top: 30px;
        padding-bottom: 30px;
        background-color: #f9f9f9;
        border-radius: 15px;
        margin-top: 40px;
        margin-bottom: 40px;
    }
    
    /* Remove old similar products styling that conflicts with new design */
    .similar-products .shop-card,
    .similar-products .card-banner,
    .similar-products .card-actions,
    .similar-products .action-btn {
        /* Reset conflicting styles */
        min-width: unset;
        position: unset;
        border-radius: unset;
        width: unset;
        height: unset;
    }
    
    /* Keep hover effect but apply to new structure */
    .shop-slider .scrollbar-item:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }

    /* Fix for category blinking issue */
    .shop-title-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        border-bottom: 2px solid #e7e7e7;
        padding-bottom: 6px;
        transition: none; /* Prevent unwanted transitions */
    }

    .shop-name {
        font-size: 2.2rem !important;
        font-weight: 700;
        color: #1e6f31;
        margin-bottom: 0;
        text-transform: capitalize;
        transition: none; /* Prevent unwanted transitions */
    }

    .btn-link {
        display: flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        color: #1e6f31;
        font-weight: 600;
        transition: color 0.2s ease-in-out;
    }

    .btn-link:hover {
        color: #124a1e;
        text-decoration: none;
        transform: none; /* Prevent unwanted transformations */
    }

    .btn-link .span {
        transition: none; /* Prevent unwanted transitions */
    }

    /* Fix for similar products section */
    .similar-products {
        margin: 40px 0;
        position: relative;
    }

    /* Ensure no unwanted hover effects on shop items */
    .shop-slider .scrollbar-item {
        flex: 0 0 auto;
        width: 220px;
        margin-right: 12px;
        scroll-snap-align: start;
        transition: transform 0.3s ease;
    }

    /* Apply hover effect only to card inside scrollbar-item */
    .shop-slider .scrollbar-item > * {
        transition: transform 0.3s ease;
    }
    
    .shop-slider .scrollbar-item:hover > * {
        transform: translateY(-5px);
    }

    /* Remove the transform on the scrollbar-item itself */
    .shop-slider .scrollbar-item:hover {
        transform: none;
    }

    /* Enhanced SweetAlert2 modal styling */
    .swal2-popup.extra-large-modal {
        width: 48em !important; /* Increased from 42em */
        max-width: 95% !important;
        font-size: 1.4rem !important; /* Increased from 1.3rem */
        padding: 3em !important; /* Increased from 2.5em */
        border-radius: 18px !important; /* More rounded corners */
    }
    
    .swal-title-large {
        font-size: 32px !important; /* Increased from 28px */
        margin-bottom: 25px !important; /* Increased from 20px */
    }
    
    .swal-button-large {
        border-radius: 30px !important;
        font-size: 20px !important; /* Increased from 18px */
        padding: 16px 32px !important; /* Increased from 14px 28px */
        font-weight: 600 !important;
        letter-spacing: 0.5px !important;
        min-width: 180px !important; /* Ensure buttons have good width */
    }
    
    /* Success alert styling adjustments */
    .swal2-success-ring {
        width: 90px !important;
        height: 90px !important;
    }
    
    .swal2-icon.swal2-success [class^=swal2-success-line] {
        height: 6px !important; /* Thicker checkmark */
    }
    
    .swal2-icon.swal2-success .swal2-success-line-tip {
        width: 30px !important;
    }
    
    .swal2-icon.swal2-success .swal2-success-line-long {
        width: 60px !important;
    }
    
    .swal2-icon {
        width: 90px !important; /* Bigger icon */
        height: 90px !important;
        margin: 0.5em auto 1.5em !important; /* More space above and below */
    }

    /* Add responsive image container styles */
    .image-container {
      transition: all 0.3s ease;
    }
    
    .image-container:hover {
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* Ensure SweetAlert2 product image is also not stretched */
    .swal2-popup .product-details img {
      object-fit: contain !important;
      background-color: #f9f9f9;
      border-radius: 8px;
    }
    
    /* Make sure the similar products images are displayed correctly */
    .shop-slider .scrollbar-item img {
      object-fit: cover;
      width: 100%;
      height: 100%;
      aspect-ratio: 1/1;
    }

    /* Updated image container styles */
    .image-container {
      transition: all 0.3s ease;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    }
    
    .image-container:hover {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    /* Make SweetAlert2 product image match main image display style */
    .swal2-popup .product-details img {
      object-fit: contain !important;
      background-color: #f9f9f9;
      border-radius: 8px;
      width: 140px !important;
      height: 140px !important;
    }
    
    /* Responsive adjustments for larger image */
    @media (max-width: 992px) {
      .title-wrapper {
        flex-direction: column;
      }
      
      .image-container {
        width: 100% !important;
        height: 320px !important;
        margin-right: 0 !important;
        margin-bottom: 25px;
      }
    }

    /* Rating stars styling */
    .rating {
      position: relative;
      display: inline-flex;
      gap: 5px;
    }
    
    .rating input {
      display: none;
    }
    
    .rating label {
      cursor: pointer;
      transition: all 0.2s ease;
      position: relative;
      z-index: 1;
    }
    
    .rating label:hover,
    .rating label:hover ~ label,
    .rating input:checked ~ label {
      color: #ffd700;
      transform: scale(1.1);
    }
    
    #ratingHighlight {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      background: linear-gradient(90deg, #ffd700 0%, #ffd700 0%, #ddd 0%);
      transition: width 0.3s ease;
      pointer-events: none;
      z-index: 0;
      border-radius: 4px;
    }
    
    /* Review form styling */
    .review-form {
      transition: all 0.3s ease;
    }
    
    .review-form:hover {
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    
    .review-form textarea:focus {
      outline: none;
      border-color: var(--hoockers-green);
      box-shadow: 0 0 0 2px rgba(81, 122, 91, 0.1);
    }
    
    .review-form button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(81, 122, 91, 0.2);
    }

    /* Feedback list styling */
    .feedback-list::-webkit-scrollbar {
      width: 8px;
    }
    
    .feedback-list::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    
    .feedback-list::-webkit-scrollbar-thumb {
      background: var(--hoockers-green);
      border-radius: 10px;
    }
    
    .feedback-list::-webkit-scrollbar-thumb:hover {
      background: #3a5a4a;
    }
  </style>
      
      <script>
        const feedbackList = document.getElementById('feedback-list');
      
        function scrollUp() {
          feedbackList.scrollBy({ top: -100, behavior: 'smooth' });
        }
      
        function scrollDown() {
          feedbackList.scrollBy({ top: 100, behavior: 'smooth' });
        }
      </script>

      <script>
        // Handle review form submission
        document.getElementById('reviewForm')?.addEventListener('submit', function(e) {
          e.preventDefault();
          
          const formData = new FormData(this);
          
          fetch(this.action, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              rating: formData.get('rating'),
              comment: formData.get('comment')
            })
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            if (data.success) {
              Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonColor: '#517A5B',
                customClass: {
                  popup: 'bigger-modal'
                }
              }).then(() => {
                window.location.reload();
              });
            } else {
              throw new Error(data.message || 'Failed to submit review');
            }
          })
          .catch(error => {
            Swal.fire({
              title: 'Error!',
              text: error.message || 'Something went wrong. Please try again.',
              icon: 'error',
              confirmButtonColor: '#517A5B',
              customClass: {
                popup: 'bigger-modal'
              }
            });
          });
        });

        // Handle star rating hover and click
        const ratingInputs = document.querySelectorAll('.rating input');
        const ratingLabels = document.querySelectorAll('.rating label');
        const ratingText = document.getElementById('ratingText');
        const ratingHighlight = document.getElementById('ratingHighlight');
        
        function updateRatingDisplay(rating) {
          const percentage = (rating / 5) * 100;
          ratingText.textContent = `${percentage}% - ${getRatingText(rating)}`;
          ratingHighlight.style.background = `linear-gradient(90deg, #ffd700 0%, #ffd700 ${percentage}%, #ddd ${percentage}%)`;
          
          // Add highlight effect to selected stars
          ratingLabels.forEach((label, index) => {
            const starRating = 5 - index;
            if (starRating <= rating) {
              label.style.color = '#ffd700';
              label.style.transform = 'scale(1.1)';
            } else {
              label.style.color = '#ddd';
              label.style.transform = 'scale(1)';
            }
          });
        }
        
        ratingInputs.forEach((input, index) => {
          input.addEventListener('change', () => {
            const rating = 5 - index;
            updateRatingDisplay(rating);
          });
        });

        ratingLabels.forEach((label, index) => {
          label.addEventListener('mouseover', () => {
            const rating = 5 - index;
            updateRatingDisplay(rating);
          });
        });

        document.querySelector('.rating').addEventListener('mouseleave', () => {
          const checkedInput = document.querySelector('.rating input:checked');
          if (checkedInput) {
            const rating = parseInt(checkedInput.value);
            updateRatingDisplay(rating);
          } else {
            ratingText.textContent = '';
            ratingHighlight.style.background = 'linear-gradient(90deg, #ffd700 0%, #ffd700 0%, #ddd 0%)';
            ratingLabels.forEach(label => {
              label.style.color = '#ddd';
              label.style.transform = 'scale(1)';
            });
          }
        });

        function getRatingText(rating) {
          const texts = {
            1: 'Poor',
            2: 'Fair',
            3: 'Good',
            4: 'Very Good',
            5: 'Excellent'
          };
          return texts[rating] || '';
        }

        // Handle character count for comment
        const commentTextarea = document.getElementById('comment');
        const charCount = document.getElementById('charCount');

        commentTextarea.addEventListener('input', () => {
          const length = commentTextarea.value.length;
          charCount.textContent = `${length}/500 characters`;
          
          if (length > 500) {
            charCount.style.color = '#dc3545';
          } else {
            charCount.style.color = '#666';
          }
        });
      </script>

</div>
@endsection