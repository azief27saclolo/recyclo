<x-layout>

    <a href="{{ route('dashboard') }}" class="block mb-2 text-xs text-blue-500">&larr; Go back</a>

    <div class="flex justify-center items-center max-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300 w-full max-w-screen-md" >
            <h2 class="font-bold mb-6 text-center">Update your post</h2>

            {{-- Session Messages --}}
            @if (session('success'))    
                <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500" />
            @elseif (session('delete'))
                <x-flashMsg msg="{{ session('delete') }}" bg="bg-red-500"/>
            @endif

            <form action="{{ route('posts.update', $post) }}" method="post" enctype="multipart/form-data" x-data="formSubmit" @submit.prevent="submit">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">Post Title</label>
                    <input type="text" name="title" value="{{ $post->title }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('title') ring-red-500 @enderror" placeholder="Enter title..."/>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div class="mb-4">
                    <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                    <select name="category" value="{{ $post->category }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('category') ring-red-500 @enderror">
                        <option value="">--Select--</option>
                        <option value="Metal">Metal</option>
                        <option value="Plastic">Plastic</option>
                        <option value="Paper">Paper</option>
                        <option value="Glass">Glass</option>
                        <option value="Wood">Wood</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="mb-4">
                    <label for="location" class="block text-gray-700 font-bold mb-2" >Location</label>
                    <input type="text" name="location" value="{{ $post->location }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('location') ring-red-500 @enderror" placeholder="Enter location..."/>
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Unit --}}
                <div class="mb-4">
                    <label for="unit" class="block text-gray-700 font-bold mb-2">Unit</label>
                    <select name="unit" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('unit') ring-red-500 @enderror">
                        <option value="">--Select--</option>
                        <option value="kg" {{ $post->unit == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                        <option value="g" {{ $post->unit == 'g' ? 'selected' : '' }}>Gram (g)</option>
                        <option value="lb" {{ $post->unit == 'lb' ? 'selected' : '' }}>Pound (lb)</option>
                        <option value="L" {{ $post->unit == 'L' ? 'selected' : '' }}>Liter (L)</option>
                        <option value="m3" {{ $post->unit == 'm3' ? 'selected' : '' }}>Cubic Meter (m3)</option>
                        <option value="gal" {{ $post->unit == 'gal' ? 'selected' : '' }}>Gallon (gal)</option>
                        <option value="pc" {{ $post->unit == 'pc' ? 'selected' : '' }}>Per Piece (pc)</option>
                        <option value="dz" {{ $post->unit == 'dz' ? 'selected' : '' }}>Per Dozen (dz)</option>
                        <option value="bndl" {{ $post->unit == 'bndl' ? 'selected' : '' }}>Per Bundle (bndl)</option>
                        <option value="sack" {{ $post->unit == 'sack' ? 'selected' : '' }}>Per Sack (sack)</option>
                        <option value="bale" {{ $post->unit == 'bale' ? 'selected' : '' }}>Per Bale (bale)</option>
                        <option value="roll" {{ $post->unit == 'roll' ? 'selected' : '' }}>Per Roll (roll)</option>
                        <option value="drum" {{ $post->unit == 'drum' ? 'selected' : '' }}>Per Drum (drum)</option>
                        <option value="box" {{ $post->unit == 'box' ? 'selected' : '' }}>Per Box (box)</option>
                        <option value="pallet" {{ $post->unit == 'pallet' ? 'selected' : '' }}>Per Pallet (pallet)</option>
                    </select>
                    @error('unit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quantity --}}
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity</label>
                    <input type="number" name="quantity" value="{{ $post->quantity }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('quantity') ring-red-500 @enderror" placeholder="Enter quantity..."/>
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price --}}
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 font-bold mb-2">Price per kilo</label>
                    <input type="text" name="price" value="{{ $post->price }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('price') ring-red-500 @enderror" placeholder="Enter price..."/>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea value="{{ $post->description }}" name="description" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('description') ring-red-500 @enderror" placeholder="Enter description..."></textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image --}}
                <label>Cover Photo</label>
                <img class="h-1/2 w-1/2 mb-4" src="{{ asset('storage/' . $post->image) }}" alt="Plastic Waste">

                {{-- Upload Image --}}
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-bold mb-2">Photo</label>
                    <input type="file" name="image" id="image" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('image') ring-red-500 @enderror"/>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button x-ref="btn" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 w-full">Update</button>
            </form>
        </div>
    </div>


</x-layout>