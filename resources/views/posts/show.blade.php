<x-layout>

    {{-- <x-postCard :post="$post" /> --}}

        <div class="slide active"><img src="{{ asset('storage/' . $post->image) }}" alt="Product Image" class="hero-image"></div>
    
    <div class="shop-info">
        {{-- Title --}}
        <h2 class="font-bold text-xl">{{ $post->title }}</h2>
        
        {{-- Author and Date --}}
        <div class="text-xs font-light mb-4">
            <span>Posted {{ $post->created_at->diffForHumans() }} by</span>
            <a href="{{ route('posts.user', $post->user) }}" class="text-blue-500 font-medium">{{ $post->user->username }}</a>
        </div>
        
        {{-- Category --}}
        <h2 class="waste-filter">{{ $post->category }}</h2>
        
        {{-- Location --}}
        <h2 class="font-thin text-m">Location: {{ $post->location }}</h2>
        
        {{-- Price --}}
        <h2 class="font-thin text-m">Price: {{ $post->price }}</h2>
        
        {{-- Rating --}}
        <span class="rating">★ 5.0</span>
        
        {{--  --}}
    </div>
    
        {{-- <div class="cart-wrapper">
            <div class="quantity-container">
                <button class="quantity-btn" id="minus-btn">-</button>
                <input type="number" id="quantity-input" value="1" min="1" />
                <button class="quantity-btn" id="plus-btn">+</button>
            </div>
        </div> --}}
        
            
        <a href="#">
            <button class="add-to-cart-btn">Add to Cart</button>
        </a>
        
<script src="../scripts/script.js"></script>

</x-layout>