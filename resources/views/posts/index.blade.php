<x-layout>

   {{-- @auth --}}
   <div class="header">
        <img src="../images/logo1.png" alt="Recyclo Logo" class="logo">
        <h1 class="title">Re<span>cyclo</span></h1>
        <div class="menu">
            <i class="bi bi-list"></i>
        </div>
    </div>

   <h1 class="title">Latest</h1>

    <div>
        @foreach ($posts as $post)       
            <x-postCard :post="$post"/>
        @endforeach
    </div>

   <div>
       {{ $posts->links() }}
   </div>

   {{-- @endauth --}}
</x-layout>