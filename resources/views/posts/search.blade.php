@extends('components.layout')

@section('content')
<div class="container">
    
    <section class="section shop" id="shop" aria-label="shop">
        <div class="container">
            <h2 class="h2 section-title">Search Results for "{{ $query }}"</h2><br>

            {{-- Products Section --}}
            <h3 class="h3 section-title">Products</h3>
            @if($posts->isEmpty())
                <p>No products found.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($posts as $post)
                        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300">
                            <x-postCard :post="$post"/>
                        </div>
                    @endforeach
                </div>
                {{ $posts->links() }}
            @endif

            <br>

            {{-- Buy Requests Section --}}
            <h3 class="h3 section-title">Buy Requests</h3>
            @if($buyRequests->isEmpty())
                <p>No buy requests found.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($buyRequests as $buyRequest)
                        <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300">
                            <h4>{{ $buyRequest->category }}</h4>
                            <p>{{ $buyRequest->description }}</p>
                            <p>Quantity: {{ $buyRequest->quantity }} {{ $buyRequest->unit }}</p>
                        </div>
                    @endforeach
                </div>
                {{ $buyRequests->links() }}
            @endif
        </div>
    </section>

</div>
@endsection