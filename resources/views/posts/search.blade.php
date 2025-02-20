@extends('components.layout')

@section('content')
<div class="container">
    
    <section class="section shop" id="shop" aria-label="shop">
        <div class="container">
            <h2 class="h2 section-title">Search Results for "{{ $query }}"</h2>

            {{-- Sellers Section --}}
            <h3 class="h3 section-title">Sellers</h3>
            @if($users->isEmpty())
                <p>No sellers found.</p>
            @else
                @foreach ($users as $user)
                    <div class="seller-section">
                        <h4>{{ $user->username }}</h4>
                        <p>{{ $user->email }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($user->posts as $post)
                                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300">
                                    <x-postCard :post="$post"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                {{ $users->links() }}
            @endif

            {{-- Categories Section --}}
            <h3 class="h3 section-title">Categories</h3>
            @if($categories->isEmpty())
                <p>No categories found.</p>
            @else
                @foreach ($categories as $category)
                    <div class="category-section">
                        <h4>{{ $category->category }}</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($posts->where('category', $category->category) as $post)
                                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300">
                                    <x-postCard :post="$post"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                {{ $categories->links() }}
            @endif

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
        </div>
    </section>

</div>
@endsection