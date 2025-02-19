@extends('components.layout')

@section('content')
<div class="container">
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
                            <x-postCard :post="$post"/>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif
</div>
@endsection