<x-layout>

    <h1 class="title">{{ $user->username }}'s Posts ({{$posts->total()}})</h1>

    {{-- User's Posts --}}
        <section class="section shop" id="shop" aria-label="shop">
            <div class="container">
              <div class="title-wrapper">
                <h2 class="h2 section-title">Best Deals</h2>
    
                <a href="{{ route('posts') }}" class="btn-link">
                  <span class="span">View More Products</span>
    
                  <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                </a>
              </div>
            <ul class="has-scrollbar">
                <li class="scrollbar-item">
                    @foreach ($posts as $post)       
                        <x-postCard :post="$post"/>
                    @endforeach
                </li>
            </ul>
            </div>
        </section>

   <div>
       {{ $posts->links() }}
   </div>

</x-layout>