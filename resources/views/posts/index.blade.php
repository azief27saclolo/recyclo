<x-layout>

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
            @foreach ($posts as $post)       
                <li class="scrollbar-item">
                    <x-postCard :post="$post"/>
                </li>
            @endforeach
        </ul>
        </div>
    </section>

   {{-- <div>
       {{ $posts->links() }}
   </div> --}}

</x-layout>