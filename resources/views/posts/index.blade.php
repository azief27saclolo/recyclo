@extends('components.layout')

@section('content')
<div class="container">
  <div>
    <section class="section collection" id="collection" aria-label="collection">
      <div class="container">
        <ul class="collection-list">
          <li>
            <div class="collection-card has-before hover:shine">
              <h2 class="h2 card-title">Recyclable Materials</h2>
              <p class="card-text">All sorts of solid waste awaits!</p>
              <a href="#" class="btn-link">
                <span class="span">Shop Now</span>
                <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
              </a>
              <div class="has-bg-image" style="background-image: url('images/bos.jpg')"></div>
            </div>
          </li>
          <li>
            <div class="collection-card has-before hover:shine">
              <h2 class="h2 card-title">Thrash?</h2>
              <p class="card-text">No. They are treasures!</p>
              <a href="#" class="btn-link">
                <span class="span">Shop Now</span>
                <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
              </a>
              <div class="has-bg-image" style="background-image: url('images/plastic.jpg')"></div>
            </div>
          </li>
          <li>
            <div class="collection-card has-before hover:shine">
              <h2 class="h2 card-title">Shop in Recyclo</h2>
              <p class="card-text">Budget-friendly & Economic Growth</p>
              <a href="#" class="btn-link">
                <span class="span">Shop Now</span>
                <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
              </a>
              <div class="has-bg-image" style="background-image: url('images/glass.jpg')"></div>
            </div>
          </li>
        </ul>
      </div>
    </section>

    {{-- All Products Section in Grid Layout --}}
    <section class="section shop" id="shop" aria-label="shop">
      <div class="container">
        <div class="title-wrapper">
          <h2 class="h2 section-title">All Products</h2>
        </div>
        
        <div class="products-grid">
          @foreach ($posts as $post)       
            <div class="grid-item">
              <x-postCard :post="$post"/>
            </div>
          @endforeach
        </div>
        
        {{-- Pagination Controls --}}
        <div class="pagination-container">
          {{ $posts->links() }}
        </div>
      </div>
    </section>

  </div>
</div>

<style>
  /* Grid Layout Styles */
  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
  }
  
  .grid-item {
    transition: transform 0.3s ease;
  }
  
  .grid-item:hover {
    transform: translateY(-5px);
  }
  
  /* Pagination Styling */
  .pagination-container {
    margin-top: 40px;
    display: flex;
    justify-content: center;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .products-grid {
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 15px;
    }
  }
  
  @media (max-width: 480px) {
    .products-grid {
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 10px;
    }
  }
</style>
@endsection