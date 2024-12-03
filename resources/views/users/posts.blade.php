<x-layout>

    <h1 class="title">{{ $user->username }}'s Posts ({{$posts->total()}})</h1>

    {{-- User's Posts --}}
    <div>
        @foreach ($posts as $post)       
            <x-postCard :post="$post"/>
        @endforeach
    </div>

   <div>
       {{ $posts->links() }}
   </div>

</x-layout>