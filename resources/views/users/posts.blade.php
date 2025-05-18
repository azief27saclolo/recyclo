@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $user->username }}'s Shop</h1>
        <p class="text-gray-600 mt-2">Viewing all products from this seller</p>
    </div>

    @if($posts->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">This seller hasn't posted any products yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($posts as $post)
                <x-postCard :post="$post" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection 