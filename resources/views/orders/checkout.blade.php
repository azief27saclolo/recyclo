@extends('components.layout')

@section('content')
<div class="container">
      
    <section class="section checkout" id="checkout" aria-label="checkout">
        <div class="container">
          <h2 class="h2 section-title" style="margin-bottom: 20px;">Checkout</h2>
          <div class="checkout-details" style="display: flex; flex-wrap: wrap; gap: 20px;">
            <div class="product-details" style="flex: 1; background-color: var(--light-gray); padding: 20px; border-radius: var(--radius-3); box-shadow: var(--shadow-1);">
                <h3 style="color: black;">Product Details</h3>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Product Image" style="width: 100%; height: auto; border-radius: var(--radius-3); margin-bottom: 10px;">
                <h1 style="font-size: var(--fs-5); margin-bottom: 10px; color: black">{{ $post->user->username }}'s Shop</h1>
                <p style="color: black;">{{ $post->title }}</p>
                <p style="color: black;">Price: ₱{{ $post->price }}.00 per kg</p>
                <p style="color: black;">Quantity: {{ $quantity }} kg</p>
            </div>
            
            <div class="payment-details" style="flex: 1; background-color: var(--light-gray); padding: 20px; border-radius: var(--radius-10); box-shadow: var(--shadow-1);">
                <h3 style="color: black;">Payment Method</h3>
                <form>
                    <label style="display: block; margin-bottom: 20px; color: black;" >
                        <input type="radio" name="payment-method" value="cod" checked style="color: black; line-height: 40px;"> Cash on Delivery
                    </label>
                    <label style="display: block; margin-bottom: 20px ; color: black;">
                        <input type="radio" name="payment-method" value="credit-card" style="color: black; line-height: 40px;"> Credit Card
                    </label>
                    <label style="display: block; margin-bottom: 20px; color: black;">
                        <input type="radio" name="payment-method" value="gcash"> Gcash
                    </label>
                    <div id="location-details" style="display: block;">
                        <h3 style="color: black;">Location Details</h3>
                        <label for="address" style="color: black;">Address:</label>
                        <input type="text" id="address" name="address" required style="margin-bottom: 10px; padding: 10px; border: 1px solid var(--hoockers-green_20); border-radius: var(--radius-3);">
                        <label for="city" style="color: black;">City:</label>
                        <input type="text" id="city" name="city" required style="margin-bottom: 10px; padding: 10px; border: 1px solid var(--hoockers-green_20); border-radius: var(--radius-3);">
                  <label for="postal-code" style="color: black;">Postal Code:</label>
                  <input type="text" id="postal-code" name="postal-code" required style="margin-bottom: 10px; padding: 10px; border: 1px solid var(--hoockers-green_20); border-radius: var(--radius-3);">
                </div>
                <div class="buttons" style="display: flex; width: 100%;">
                    <button type="button" class="btn btn-primary" style="width: 400px !important; height: 60px !important; margin-top: 20px; margin-right: 30px; border-radius: 5px" onclick="placeOrder()">Place Order</button>
                    <a href="{{ route('posts') }}" class="btn btn-primary" style="text-align: center;margin-top: 20px;height: 60px !important; border-radius: 5px; line-height: 40px; color: white;">Go Home</a>
                </div>
            </form>
            
        </div>
        <div class="cart-summary" style="flex: 1; background-color: var(--light-gray); padding: 20px; border-radius: var(--radius-3); box-shadow: var(--shadow-1);">
            <h3 style="color: black;">Cart Summary</h3>
            <p style="color: black;">Price: ₱{{ $post->price }}.00 per kg</p>
            <p style="color: black;">Quantity: {{ $quantity }} kg</p>
            <p style="color: black;">Transportation Fee: ₱35.00</p>
            <h3 style="color: black;">Subtotal: ₱{{ $totalPrice }}.00</h3>
        </div>
    </div>
</div>
</section>


<a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="arrow-up" aria-hidden="true"></ion-icon>
</a>
<script src="{{ asset('assets/js/script.js') }}" defer></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script>
    document.querySelectorAll('input[name="payment-method"]').forEach((input) => {
        input.addEventListener('change', function() {
            const locationDetails = document.getElementById('location-details');
            if (this.value === 'cod') {
                locationDetails.style.display = 'block';
            } else {
                locationDetails.style.display = 'none';
            }
        });
    });

    function placeOrder() {
        var quantity = "{{ $quantity }}";
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

</div>
@endsection