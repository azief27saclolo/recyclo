<x-layout>
    <section class="section orders" id="orders" aria-label="orders">
        <div class="container">
            <h2 class="h2 section-title">Your Orders</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($orders as $order)
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300">
                        <img src="{{ asset('storage/' . $order->post->image) }}" alt="Post Image" style="width: 100%; height: 150px; object-fit: cover; border-radius: var(--radius-3); margin-bottom: 10px;">
                        <h3 class="font-bold">{{ $order->post->title }}</h3>
                        <p>Posted by: {{ $order->post->user->username }}</p>
                        <p>Quantity: {{ $order->quantity }} kg</p>
                        <p>Price: ₱{{ $order->post->price }}.00 per kg</p>
                        <p>Delivery Fee: ₱35.00</p>
                        <p>Total: ₱{{ ($order->post->price * $order->quantity) + 35 }}.00</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>