<x-layout>

    {{-- <x-postCard :post="$post" /> --}}

    <div class="slideshow-container">
        <div class="slide active"><img src="../images/metals1.jpg" alt="Product Image" class="hero-image"></div>
        <div class="slide"><img src="../images/metals2.jpg" alt="Product Image" class="hero-image"></div>
        <div class="slide"><img src="../images/metals3.jpg" alt="Product Image" class="hero-image"></div>
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
    </div>
    
    {{-- <div class="header" style="width: 100%; padding: 20px; display: flex; align-items: center; position: absolute; top: 0; z-index: 1000;">
        <div class="nav">
            <a href="index.html" class="return-link"><i class="bi bi-arrow-return-left"></i></a>
            
            <a href="#" class="return-link"><i class="bi bi-share"></i></a>
            <a href="#" class="return-link"><i class="bi bi-three-dots-vertical"></i></i></a>
        </div>
    </div> --}}
    
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