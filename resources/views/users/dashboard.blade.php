<x-layout>
    
    <h1>Hello {{ auth()->user()->username }}</h1>

    {{-- Create Post Form --}}
    <div class="card mb-4">
        <h2 class="font-bold mb-4">Create a new post</h2>

        <form action="{{ route('posts.store') }}" method="post">
            @csrf

            {{-- Post Title --}}
            <div class="mb-4">
                <label for="title">Post Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="border w-full text-base px-2 py-2 focus:outline-none 
                focus:ring-0 focus:border-gray-600 rounded-2xl @error('title') ring-red-500 @enderror" placeholder="Enter title..."/>
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category --}}
            <div class="mb-4">
                <label for="category">Category</label>
                <select name="category" value="{{ old('category') }}" class="border w-full text-base px-2 py-2 focus:outline-none 
                focus:ring-0 focus:border-gray-600 rounded-2xl @error('category') ring-red-500 @enderror" placeholder="Enter title...">
                    <option value="">--Select--</option>
                    <option value="metal">Metal</option>
                    <option value="plastic">Plastic</option>
                    <option value="paper">Paper</option>
                </select>
                @error('category')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Location --}}
            <div class="mb-4">
                <label for="location">Location</label>
                <input type="text" name="location" value="{{ old('location') }}" class="border w-full text-base px-2 py-2 focus:outline-none 
                focus:ring-0 focus:border-gray-600 rounded-2xl @error('location') ring-red-500 @enderror" placeholder="Enter location..."/>
                @error('location')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Price --}}
            <div class="mb-4">
                <label for="price">Price per kilo</label>
                <input type="text" name="price" value="{{ old('price') }}" class="border w-full text-base px-2 py-2 focus:outline-none 
                focus:ring-0 focus:border-gray-600 rounded-2xl @error('price') ring-red-500 @enderror" placeholder="Enter price..."/>
                @error('price')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button class="primary-btn">Create</button>
        </form>
    </div>

</x-layout>