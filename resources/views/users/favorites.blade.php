@extends('components.layout')

@section('content')
<div class="container">
    @if(session('success'))
        <div id="flash-message" class="popup-message {{ session('type') }}">
            {{ session('success') }}
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(function () {
                    var flashMessage = document.getElementById('flash-message');
                    if (flashMessage) {
                        flashMessage.remove();
                    }
                }, 2000); // 2 seconds before removing
            });
        </script>
    @endif

    @if($favorites->isEmpty())
        <p>You have no favorite items.</p>
    @else
        <section class="section shop" id="shop" aria-label="shop">
            <div class="container">
                <div class="title-wrapper">
                    <h2 class="h2 section-title">Your Favorite Listings</h2>
                </div>
                <ul class="has-scrollbar">
                    @foreach ($favorites as $post)       
                        <li class="scrollbar-item">
                            <div class="card h-100">
                                <div class="card-img-container" style="height: 200px; width: 100%; overflow: hidden;">
                                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="object-fit: cover; height: 100%; width: 100%;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">₱{{ $post->price }}.00</p>
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">View</a>
                                    <form action="{{ route('favorites.remove', $post) }}" method="POST" style="margin-top: 10px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="background-color: red; color: white;">Remove from Favorites</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif
</div>

<style>
.popup-message {
    position: fixed;
    top: 20px;
    right: 20px;
    color: white;
    padding: 10px;
    border-radius: 5px;
    z-index: 1000;
}
.popup-message.success {
    background-color: #28a745;
}
.popup-message.error {
    background-color: red;
}
</style>
@endsection