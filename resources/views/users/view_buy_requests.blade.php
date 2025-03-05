@extends('components.layout')

@section('content')
<div class="container">
    <h2 class="font-bold mt-8">All Buy Requests</h2>
    <section class="section shop" id="shop" aria-label="shop">
        <div class="container">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($buyRequests as $buyRequest)
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300">
                        <h3 class="font-bold">{{ $buyRequest->category }}</h3>
                        <p>Quantity: {{ $buyRequest->quantity }} {{ $buyRequest->unit }}</p>
                        <p>Description: {{ $buyRequest->description }}</p>
                        <p>Requested by: {{ $buyRequest->user->username }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection
