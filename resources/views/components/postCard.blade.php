@props(['post'])

<div class="card">
    {{-- Title --}}
    <h2 class="font-bold text-xl">{{ $post->title }}</h2>
    
    {{-- Author and Date --}}
    <div class="text-xs font-light mb-4">
        <span>Posted {{ $post->created_at->diffForHumans() }} by</span>
        <a href="{{ route('posts.user', $post->user) }}" class="text-blue-500 font-medium">{{ $post->user->username }}</a>
    </div>
    
    {{-- Category --}}
    <h2 class="font-thin text-m">Category: {{ $post->category }}</h2>
    
    {{-- Location --}}
    <h2 class="font-thin text-m">Location: {{ $post->location }}</h2>
    
    {{-- Price --}}
    <h2 class="font-thin text-m">Price: {{ $post->price }}</h2>
</div>