<x-layout>

    <h1 style="font-weight:bold; font-size:20px; margin-left:20px;">{{ $user->username }}'s Posts ({{ $posts->total() }})</h1>

    {{-- User's Posts --}}
    <section class="section shop" id="shop" aria-label="shop">
      <div class="container">

        <div class="title-wrapper" style="display: flex; align-items: center;">
          <img src="images/f2.jpg" alt="Shop Image" style="width: 400px; height: 250px; border-radius: 10px; margin-right: 20px;">
          <div>
            <h2 class="h2 section-title">Ronald's Organic Shop</h2>
            <h1 style="font-weight: 200; margin-bottom: 10px;">
              <i class="bi bi-compass"></i>Gov. Alvarez Street, Camino Nuevo, Zamboanga City<br>
              <i class="bi bi-telephone-inbound"></i>+63 9295 190 987<br>
              We sell recyclable materials where you can create the best out of it! <br>
              Order now from our shop and start doing innovative products where people can have benefits from it.
            </h1>
          </div>
        </div>

      <section class="section shop" id="shop" aria-label="shop">
          <div class="container">
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