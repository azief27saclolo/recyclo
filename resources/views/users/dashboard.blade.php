<x-layout>
    
    {{-- <h1 class="title">Hello {{ auth()->user()->username }}</h1> --}}

    {{-- Create Post Form --}}
    <div class="flex justify-center items-center max-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300 w-full max-w-screen-md" >
            <h2 class="font-bold mb-6 text-center">Create a new post</h2>

            {{-- Session Messages --}}
            @if (session('success'))    
                <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500" />
            @elseif (session('delete'))
                <x-flashMsg msg="{{ session('delete') }}" bg="bg-red-500"/>
            @endif

            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" x-data="formSubmit" @submit.prevent="submit">
                @csrf

                {{-- Title --}}
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">Post Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('title') ring-red-500 @enderror" placeholder="Enter title..."/>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

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
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="mb-4">
                    <label for="location" class="block text-gray-700 font-bold mb-2" >Location</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('location') ring-red-500 @enderror" placeholder="Enter location..."/>
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price --}}
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 font-bold mb-2">Price per kilo</label>
                    <input type="text" name="price" value="{{ old('price') }}" class="border w-full text-base px-4 py-2 focus:outline-none 
                    focus:ring-2 focus:ring-blue-500 rounded-lg @error('price') ring-red-500 @enderror" placeholder="Enter price..."/>
                    @error('price')
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
                <button x-ref="btn" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 w-full">Create</button>
            </form>
        </div>
    </div>

    {{-- User Posts --}}
    <h2 class="font-bold">Your Latest Posts ({{ $posts->total() }})</h2>

    <section class="section shop" id="shop" aria-label="shop">
        <div class="container">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($posts as $post)       
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300">
                        <x-postCard :post="$post"/>
                        <div class="flex items-center justify-end gap-4 mt-6">
                            {{-- Update post --}}
                            <a href="{{ route('posts.edit', $post) }}"
                                class="bg-green-500 text-white px-2 py-1 text-xs rounded-md">Update</a>
        
                            {{-- Delete post --}}
                            <form action="{{ route('posts.destroy', $post) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-2 py-1 text-xs rounded-md">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- User Orders --}}
    <h2 class="font-bold">Your Orders ({{ $orders->count() }})</h2>

    <section class="section shop" id="shop" aria-label="shop">
        <div class="container">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($orders as $order)
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300">
                        <img src="{{ asset('storage/' . $order->post->image) }}" alt="Post Image" style="width: 100%; height: 150px; object-fit: cover; border-radius: var(--radius-3); margin-bottom: 10px;">
                        <h3 class="font-bold">{{ $order->post->title }}</h3>
                        <p>Posted by: {{ $order->post->user->username }}</p>
                        <p>Quantity: {{ $order->quantity }} kg</p>
                        <p>Price: ₱{{ $order->post->price }}.00 per kg</p>
                        <p>Delivery Fee: ₱35.00</p>
                        <p>Total: ₱{{ ($order->post->price * $order->quantity) + 35 }}.00</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- <div>
        {{ $posts->links() }}
    </div> --}}

</x-layout>