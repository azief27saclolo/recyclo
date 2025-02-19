@extends('components.layout')

@section('content')
<div class="container">

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

              <h1>Description: </h1>
              <p style="color: black;">{{ $post->description }}</p>

              <div style="display: flex; align-items: center;">
                <h1 style="color: black;">  Quantity (kg): </h1>
                <button onclick="decreaseQuantity()" style="margin-left: 10px;padding: 7px 10px; font-size: 1rem; border-radius: 25px;">-</button>
                <input type="number" id="quantity" value="1" min="1" style="width: 50px; text-align: center; margin: 0 10px; border: 1px solid black; border-radius: 10px; ">
                <button onclick="increaseQuantity()" style="margin-right: 10px; padding: 7px 10px; font-size: 1rem; border-radius: 25px; ">+</button>
                <a href="#" class="btn btn-primary" style="width: 400px; height: 45px; border-radius: 30px; margin-right: 10px;">Add to Cart</a>
                <a href="#" onclick="redirectToCheckout()" class="btn btn-primary" style="width: 400px; height: 45px; border-radius: 30px;">Check Out</a>
              </div>
            </div>
          </div>

        <section class="section shop" id="shop" aria-label="shop">
            <div class="container">
                <ul class="has-scrollbar">
                    @foreach ($posts as $post)       
                        <li class="scrollbar-item">
                            <x-postCard :post="$post"/>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

          <section class="section new-arrivals" id="new-arrivals" aria-label="new arrivals">
            <div class="container">
              <div class="title-wrapper">
                <h2 class="h2 section-title">New Arrivals</h2>
                <a href="#" class="btn-link">
                  <span class="span">View More New Arrivals</span>
                  <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                </a>
              </div>
              <ul class="has-scrollbar">
                <li class="scrollbar-item">
                  <div class="shop-card">
                    <div class="card-banner img-holder" style="--width: 150; --height: 100; border-radius: 5px;">
                      <img src="{{ asset('images/wood.jpg') }}" width="100" height="100" loading="lazy" alt="New Product 1" class="img-cover">
                    </div>
                  </div>
                </li>
                <li class="scrollbar-item">
                  <div class="shop-card">
                    <div class="card-banner img-holder" style="--width: 150; --height: 100; border-radius: 5px;">
                      <img src="{{ asset('images/woods3.jpg') }}" width="100" height="100" loading="lazy" alt="New Product 2" class="img-cover">
                    </div>
                  </div>
                </li>
                <li class="scrollbar-item">
                  <div class="shop-card">
                    <div class="card-banner img-holder" style="--width: 150; --height: 100; border-radius: 5px;">
                      <img src="{{ asset('images/mets.jpg') }}" width="100" height="100" loading="lazy" alt="New Product 3" class="img-cover">
                    </div>
                  </div>
                </li>
                <li class="scrollbar-item">
                  <div class="shop-card">
                    <div class="card-banner img-holder" style="--width: 150; --height: 100; border-radius: 5px;">
                      <img src="{{ asset('images/br.jpg') }}" width="100" height="100" loading="lazy" alt="New Product 4" class="img-cover">
                    </div>
                  </div>
                </li>
                <li class="scrollbar-item">
                    <div class="shop-card">
                      <div class="card-banner img-holder" style="--width: 150; --height: 100; border-radius: 5px;">
                        <img src="{{ asset('images/glass.jpg') }}" width="100" height="100" loading="lazy" alt="New Product 4" class="img-cover">
                      </div>
                    </div>
                  </li>
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
      quantity.value = parseInt(quantity.value) + 1;
    }

    function decreaseQuantity() {
      var quantity = document.getElementById('quantity');
      if (quantity.value > 1) {
        quantity.value = parseInt(quantity.value) - 1;
      }
    }

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
  </script>
  <style>
    button:hover {
      background-color: var(--hoockers-green);
      color: var(--white);
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