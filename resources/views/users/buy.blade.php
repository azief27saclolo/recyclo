@extends('components.layout')

@section('content')
<div class="container">
    <div class="flex justify-center items-center max-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300 w-full max-w-screen-md">
            <h2 class="font-bold mb-6 text-center">Create a Buy Request</h2>

            {{-- Session Messages --}}
            @if (session('success'))    
                <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500" />
            @elseif (session('delete'))
                <x-flashMsg msg="{{ session('delete') }}" bg="bg-red-500"/>
            @endif

            <form action="{{ route('buy.store') }}" method="post" enctype="multipart/form-data" x-data="formSubmit" @submit.prevent="submit">
                @csrf

                {{-- Category --}}
                <div class="mb-4">
                    <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                    <select name="category" value="{{ old('category') }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('category') ring-red-500 @enderror">
                        <option value="">--Select--</option>
                        <option value="Metal">Metal</option>
                        <option value="Plastic">Plastic</option>
                        <option value="Paper">Paper</option>
                        <option value="Glass">Glass</option>
                        <option value="Wood">Wood</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fabric">Fabric</option>
                        <option value="Rubber">Rubber</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quantity --}}
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('quantity') ring-red-500 @enderror" placeholder="Enter quantity..."/>
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Unit --}}
                <div class="mb-4">
                    <label for="unit" class="block text-gray-700 font-bold mb-2">Unit</label>
                    <select name="unit" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('unit') ring-red-500 @enderror">
                        <option value="">--Select--</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="g">Gram (g)</option>
                        <option value="lb">Pound (lb)</option>
                        <option value="L">Liter (L)</option>
                        <option value="m3">Cubic Meter (m3)</option>
                        <option value="gal">Gallon (gal)</option>
                        <option value="pc">Per Piece (pc)</option>
                        <option value="dz">Per Dozen (dz)</option>
                        <option value="bndl">Per Bundle (bndl)</option>
                        <option value="sack">Per Sack (sack)</option>
                        <option value="bale">Per Bale (bale)</option>
                        <option value="roll">Per Roll (roll)</option>
                        <option value="drum">Per Drum (drum)</option>
                        <option value="box">Per Box (box)</option>
                        <option value="pallet">Per Pallet (pallet)</option>
                    </select>
                    @error('unit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea name="description" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('description') ring-red-500 @enderror" placeholder="Enter description...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button x-ref="btn" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 w-full">Post Request</button>
            </form>
        </div>
    </div>

    {{-- User Buy Requests --}}
    <h2 class="font-bold mt-8">Your Buy Requests ({{ $buyRequests->count() }})</h2>
    <section class="section shop" id="shop" aria-label="shop">
        <div class="container">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($buyRequests as $buyRequest)
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300">
                        <h3 class="font-bold">{{ $buyRequest->category }}</h3>
                        <p>Quantity: {{ $buyRequest->quantity }} {{ $buyRequest->unit }}</p>
                        <p>Description: {{ $buyRequest->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection
