<x-layout>
    @guest

    @endguest

   @auth
   <h1>Latest Post</h1>

    <div>
        @foreach ($posts as $post)       
            <x-postCard :post="$post"/>
        @endforeach
    </div>

   <div>
       {{ $posts->links() }}
   </div>

   @endauth
</x-layout>