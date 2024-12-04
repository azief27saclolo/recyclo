<x-layout>
    
    <h1 class="title">Hello {{ auth()->user()->username }}</h1>

    {{-- Create Post Form --}}
    <div class="card mb-4">
        <h2 class="font-bold mb-4">Create a new post</h2>

        {{-- Session Messages --}}
        @if (session('success'))    
            <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500" />
        @elseif (session('delete'))
            <x-flashMsg msg="{{ session('delete') }}" bg="bg-red-500"/>
        @endif

        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
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

            {{-- Image --}}
            <div class="mb-4">
                <label for="image">Photo</label>
                <input type="file" name="image" id="image">
                @error('image')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button class="primary-btn">Create</button>
        </form>
    </div>

    {{-- User Posts --}}
    <h2 class="font-bold mb-4">Your Latest Posts ({{ $posts->total() }})</h2>

    <div>
        @foreach ($posts as $post)       
            <x-postCard :post="$post">
                {{-- Update Post --}}
                <a href="{{ route('posts.edit', $post) }}" class="bg-green-500 text-white px-2 py-1 text-xs rounded-md">Update</a>
                
                {{-- Delete Post --}}
                <form action="{{ route('posts.destroy', $post) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white px-2 py-1 text-xs rounded-md">Delete</button>
                </form>
            </x-postCard>
        @endforeach
    </div>

    <div>
        {{ $posts->links() }}
    </div>

</x-layout>