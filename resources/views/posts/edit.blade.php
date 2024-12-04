<x-layout>

    <a href="{{ route('dashboard') }}" class="block mb-2 text-xs text-blue-500">&larr; Go back</a>

    <div class="card">
        <h2 class="font-bold mb-4">Update your post</h2>

        <form action="{{ route('posts.update', $post) }}" method="post">
            @csrf
            @method('PUT')
            
            {{-- Post Title --}}
            <div class="mb-4">
                <label for="title">Post Title</label>
                <input type="text" name="title" value="{{ $post->title }}" class="border w-full text-base px-2 py-2 focus:outline-none 
                focus:ring-0 focus:border-gray-600 rounded-2xl @error('title') ring-red-500 @enderror" placeholder="Enter title..."/>
                @error('title')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Category --}}
            <div class="mb-4">
                <label for="category">Category</label>
                <select name="category" value="{{ $post->category }}" class="border w-full text-base px-2 py-2 focus:outline-none 
                focus:ring-0 focus:border-gray-600 rounded-2xl @error('category') ring-red-500 @enderror" placeholder="Enter title...">
                <option value="">--Select--</option>
                <option value="Metal">Metal</option>
                <option value="Plastic">Plastic</option>
                <option value="Paper">Paper</option>
            </select>
            @error('category')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Location --}}
        <div class="mb-4">
            <label for="location">Location</label>
            <input type="text" name="location" value="{{ $post->location }}" class="border w-full text-base px-2 py-2 focus:outline-none 
            focus:ring-0 focus:border-gray-600 rounded-2xl @error('location') ring-red-500 @enderror" placeholder="Enter location..."/>
            @error('location')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Price --}}
        <div class="mb-4">
            <label for="price">Price per kilo</label>
            <input type="text" name="price" value="{{ $post->price }}" class="border w-full text-base px-2 py-2 focus:outline-none 
            focus:ring-0 focus:border-gray-600 rounded-2xl @error('price') ring-red-500 @enderror" placeholder="Enter price..."/>
            @error('price')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Submit Button --}}
        <button class="primary-btn">Update</button>
        </form>
    </div>

</x-layout>