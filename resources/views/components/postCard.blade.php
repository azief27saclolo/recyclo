@props(['post'])

<a href="{{ route('posts.show', $post) }}">
    <div class="shop-card">
        {{-- Image --}}
        <img src="{{ asset('storage/' . $post->image) }}" alt="Plastic Waste">
        
        <span class="star-icon">★</span>
        
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
        </div>

        <div class="flex items-center justify-end gap-4 mt-40">
            {{ $slot }}
        </div>
    </div>
</a>