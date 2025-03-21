@extends('components.layout')

@section('content')
<div class="container">
    <!-- Add SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <section class="section shop" id="shop" aria-label="shop">
        <div class="container">

          <div class="title-wrapper" style="display: flex; align-items: center;">
            <img src="{{ asset('storage/' . $post->image) }}" alt="Shop Image" style="width: 400px; height: 250px; border-radius: 10px; margin-right: 20px;">
            <div>
              <h2 class="h2 section-title">{{ $post->title }}</h2>
              <h1 style="font-weight: 200; margin-bottom: 10px;">
                <i class="bi bi-compass"></i>{{ $post->location }}<br>
                <i class="bi bi-telephone-inbound"></i>{{ $post->user->number }}<br>
              </h1>

              <h1>Price: </h1>
              <h1 style="color: black;">{{ $post->price }}.00</h1>
              
              <h1>Available Stock: </h1>
              <h1 style="color: {{ $post->quantity < 10 ? '#dc3545' : 'black' }};">
                {{ $post->quantity }} {{ $post->unit }}
                @if($post->quantity < 10)
                  <span style="font-size: 18px; color: #dc3545; margin-left: 5px;">(Low Stock)</span>
                @endif
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
        <div class="container" style="border: 2px solid var(--hoockers-green); padding: 10px; border-radius: var(--radius-3); position: relative; height: 400px;">
          <div class="title-wrapper">
            <h2 class="h2 section-title">Feedback & Reviews</h2>
          </div>
      
          
      
          <!-- Feedback List -->
          <ul class="feedback-list" id="feedback-list" style="overflow-y: auto; max-height: 300px; margin-top: 10px; padding: 10px;">
            <!-- Feedback Items (4 shown at a time) -->
            <li class="feedback-item">
              <div class="feedback-card" style="border: 1px solid var(--light-gray); padding: 15px; border-radius: var(--radius-3); display: flex; align-items: center;">
                <img src="{{ asset('images/f2.jpg') }}" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px;">
                <div>
                  <h3 class="feedback-title">Azief</h3>
                  <p class="feedback-text">Great shop! The products are of high quality and the prices are very reasonable. Highly recommend!</p>
                  <div class="feedback-rating" style="color: yellow; display: flex; flex-direction: row;">
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                  </div>
                </div>
              </div>
            </li>
            <li class="feedback-item">
                <div class="feedback-card" style="border: 1px solid var(--light-gray); padding: 15px; border-radius: var(--radius-3); display: flex; align-items: center;">
                  <img src="{{ asset('images/f1.jpg') }}" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px;">
                  <div>
                    <h3 class="feedback-title">Ronald</h3>
                    <p class="feedback-text">Great shop! The products are of high quality and the prices are very reasonable. Highly recommend!</p>
                    <div class="feedback-rating" style="color: yellow; display: flex; flex-direction: row;">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>
                  </div>
                </div>
              </li>
              <li class="feedback-item">
                <div class="feedback-card" style="border: 1px solid var(--light-gray); padding: 15px; border-radius: var(--radius-3); display: flex; align-items: center;">
                  <img src="{{ asset('images/f4.jpg') }}" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px;">
                  <div>
                    <h3 class="feedback-title">Ian</h3>
                    <p class="feedback-text">Great shop! The products are of high quality and the prices are very reasonable. Highly recommend!</p>
                    <div class="feedback-rating" style="color: yellow; display: flex; flex-direction: row;">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>
                  </div>
                </div>
              </li>
              <li class="feedback-item">
                <div class="feedback-card" style="border: 1px solid var(--light-gray); padding: 15px; border-radius: var(--radius-3); display: flex; align-items: center;">
                  <img src="{{ asset('images/f3.jpg') }}" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px;">
                  <div>
                    <h3 class="feedback-title">Jameel</h3>
                    <p class="feedback-text">Great shop! The products are of high quality and the prices are very reasonable. Highly recommend!</p>
                    <div class="feedback-rating" style="color: yellow; display: flex; flex-direction: row;">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>
                  </div>
                </div>
              </li>
              <li class="feedback-item">
                <div class="feedback-card" style="border: 1px solid var(--light-gray); padding: 15px; border-radius: var(--radius-3); display: flex; align-items: center;">
                  <img src="{{ asset('images/f3.jpg') }}" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px;">
                  <div>
                    <h3 class="feedback-title">Jameel</h3>
                    <p class="feedback-text">Great shop! The products are of high quality and the prices are very reasonable. Highly recommend!</p>
                    <div class="feedback-rating" style="color: yellow; display: flex; flex-direction: row;">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>
                  </div>
                </div>
              </li>
              <li class="feedback-item">
                <div class="feedback-card" style="border: 1px solid var(--light-gray); padding: 15px; border-radius: var(--radius-3); display: flex; align-items: center;">
                  <img src="{{ asset('images/f3.jpg') }}" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px;">
                  <div>
                    <h3 class="feedback-title">Jameel</h3>
                    <p class="feedback-text">Great shop! The products are of high quality and the prices are very reasonable. Highly recommend!</p>
                    <div class="feedback-rating" style="color: yellow; display: flex; flex-direction: row;">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                      <ion-icon name="star" aria-hidden="true"></ion-icon>
                    </div>
                  </div>
                </div>
              </li>
            <!-- Add other feedback items here -->
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
      } else {
        alert('Maximum available quantity is ' + maxQuantity + ' {{ $post->unit }}');
      }
    }

    function decreaseQuantity() {
      var quantity = document.getElementById('quantity');
      if (quantity.value > 1) {
        quantity.value = parseInt(quantity.value) - 1;
      }
    }

    // Validate quantity doesn't exceed available stock
    document.getElementById('quantity').addEventListener('change', function() {
      var maxQuantity = {{ $post->quantity }};
      if (parseInt(this.value) > maxQuantity) {
        this.value = maxQuantity;
        alert('Maximum available quantity is ' + maxQuantity + ' {{ $post->unit }}');
      }
    });

    function redirectToCheckout() {
        var quantity = document.getElementById('quantity').value;
        var url = "{{ route('checkout', ['post_id' => $post->id]) }}&quantity=" + quantity;
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
        
        var quantity = document.getElementById('quantity').value;
        
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
                product_id: '{{ $product_id }}',
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message with product details
                Swal.fire({
                    title: '<span style="color: #517A5B"><i class="bi bi-check-circle-fill"></i> Added to Cart!</span>',
                    html: `
                        <div style="display: flex; align-items: center; margin-bottom: 25px; margin-top: 20px;">
                            <img src="{{ asset('storage/' . $post->image) }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px;">
                            <div style="margin-left: 20px; text-align: left;" class="product-details">
                                <div style="font-weight: 700; font-size: 24px;" class="product-name">{{ $post->title }}</div>
                                <div style="font-size: 20px; margin-top: 8px;">Quantity: ${quantity}</div>
                                <div style="font-size: 20px; font-weight: 600; color: #517A5B; margin-top: 5px;">₱{{ $post->price }}</div>
                            </div>
                        </div>
                        <p style="font-size: 20px;">${data.message}</p>
                    `,
                    icon: 'success',
                    confirmButtonColor: '#517A5B',
                    confirmButtonText: 'Continue Shopping',
                    showCancelButton: true,
                    cancelButtonText: 'Go to Cart',
                    cancelButtonColor: '#6c757d',
                    customClass: {
                        popup: 'extra-large-modal',
                        title: 'swal-title-large',
                        confirmButton: 'swal-button-large',
                        cancelButton: 'swal-button-large'
                    }
                }).then((result) => {
                    if (!result.isConfirmed) {
                        // If user clicked "Go to Cart"
                        window.location.href = "{{ route('cart.index') }}";
                    }
                });
                
                // Update cart badge count if it exists
                const cartBadge = document.querySelector('.btn-badge');
                if (cartBadge) {
                    const currentCount = parseInt(cartBadge.textContent || '0');
                    cartBadge.textContent = currentCount + 1;
                }
            } else {
                // Show error message
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Failed to add item to cart',
                    icon: 'error',
                    confirmButtonColor: '#517A5B',
                    customClass: {
                        popup: 'extra-large-modal'
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Something went wrong. Please try again.',
                icon: 'error',
                confirmButtonColor: '#517A5B',
                customClass: {
                    popup: 'extra-large-modal'
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
    
    /* Add styling for stock display */
    .stock-indicator {
      display: inline-block;
      padding: 5px 15px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    .stock-indicator.low {
      background-color: #fff8f8;
      color: #dc3545;
      border: 1px solid #f5c6cb;
    }
    .stock-indicator.good {
      background-color: #f0f8f1;
      color: #517a5b;
      border: 1px solid #c3e6cb;
    }

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

</div>
@endsection