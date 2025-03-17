@extends('components.layout')

@section('content')
<div class="container">
    <section class="section checkout" id="checkout" aria-label="checkout">
        <div class="container">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 class="h2 section-title">Checkout</h2>
                <p style="color: #666; margin-top: 5px;">Complete your purchase</p>
            </div>

            <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
                <!-- Order Summary -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 25px; overflow: hidden;">
                    <div style="background: #517a5b; color: white; padding: 15px 20px;">
                        <h3 style="margin: 0; font-size: 1.2rem;">Order Summary</h3>
                    </div>
                    <div style="padding: 20px;">
                        <div style="display: flex; gap: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Product Image" 
                                 style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;">
                            <div style="flex: 1;">
                                <div style="color: #517a5b; font-size: 0.9rem; margin-bottom: 5px;">{{ $post->user->username }}'s Shop</div>
                                <h4 style="margin: 5px 0; font-size: 1.1rem;">{{ $post->title }}</h4>
                                <div style="color: #666; font-size: 1rem;">₱{{ $post->price }}.00 × {{ $quantity }}kg</div>
                            </div>
                        </div>

                        <div style="margin-top: 20px;">
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; color: #666;">
                                <span>Subtotal</span>
                                <span>₱{{ $post->price * $quantity }}.00</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; color: #666;">
                                <span>Delivery Fee</span>
                                <span>₱35.00</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-top: 2px solid #eee; margin-top: 10px; padding-top: 15px; font-weight: 600; color: #517a5b; font-size: 1.2rem;">
                                <span>Total</span>
                                <span>₱{{ $totalPrice }}.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 25px; overflow: hidden;">
                    <div style="background: #517a5b; color: white; padding: 15px 20px;">
                        <h3 style="margin: 0; font-size: 1.2rem;">Payment Details</h3>
                    </div>
                    <div style="padding: 20px;">
                        <div style="background: #f8f9fa; border-radius: 10px; padding: 30px; margin-bottom: 20px; text-align: center;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
                                <img src="{{ asset('assets/images/mon.jpg') }}" alt="GCash" style="height: 80px; width: auto; object-fit: contain;">
                                <div style="width: 100%; text-align: center; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                                    <p style="color: #666; margin-bottom: 10px; font-size: 1rem;">Scan / Send payment to:</p>
                                    <p style="font-size: 1.8rem; font-weight: 600; color: #517a5b; margin: 10px 0;">0929 519 0987</p>
                                    <p style="color: #333; font-size: 1.2rem; font-weight: 500;">{{ $post->user->username }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div style="margin: 25px 0; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                            <h4 style="color: #517a5b; margin-bottom: 15px;">Pickup Information</h4>
                            <p style="margin-bottom: 10px; color: #333;">{{ $post->user->username }}'s Shop<br>{{ $post->location }}</p>
                            <p style="color: #666; font-size: 0.9rem;">Please pick up your order within 3 days after payment confirmation.</p>
                        </div>

                        <div style="display: grid; gap: 15px; margin-top: 25px;">
                            <button type="button" onclick="placeOrder()" 
                                    style="background: #517a5b; color: white; border: none; padding: 15px; border-radius: 8px; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; width: 100%;">
                                Complete Order
                            </button>
                            <button type="button" onclick="window.location.href='{{ route('posts') }}'" 
                                    style="background: none; border: 2px solid #517a5b; color: #517a5b; padding: 15px; border-radius: 8px; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; width: 100%;">
                                Continue Shopping
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
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
@endsection