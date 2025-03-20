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

    {{-- Category Filter Section --}}
    <section class="section filter-section" aria-label="filter">
      <div class="container">
        <div class="filter-container">
          <h3 class="filter-title">Filters</h3>
          <form action="{{ route('posts') }}" method="GET" class="filter-form">
            <select name="category" id="category-filter" class="category-select">
              <option value="all" {{ (!request('category') || request('category') == 'all') ? 'selected' : '' }}>All Categories</option>
              @foreach ($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
              @endforeach
            </select>
            
            <select name="price_sort" id="price-sort" class="price-sort-select">
              <option value="" {{ !request('price_sort') ? 'selected' : '' }}>Price: Default</option>
              <option value="low_high" {{ request('price_sort') == 'low_high' ? 'selected' : '' }}>Price: Low to High</option>
              <option value="high_low" {{ request('price_sort') == 'high_low' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
            
            <button type="submit" class="filter-btn">
              <ion-icon name="funnel-outline"></ion-icon> Apply Filters
            </button>
          </form>
        </div>
      </div>
    </section>

    {{-- All Products Section in Grid Layout --}}
    <section class="section shop" id="shop" aria-label="shop">
      <div class="container">
        <div class="title-wrapper">
          <h2 class="h2 section-title">
            {{ request('category') && request('category') != 'all' ? ucfirst(request('category')) : 'All' }} Products
          </h2>
        </div>
        
        <div class="products-grid">
          @if($posts->count() > 0)
            @foreach ($posts as $post)       
              <div class="grid-item">
                <x-postCard :post="$post"/>
              </div>
            @endforeach
          @else
            <div class="no-posts-message">
              <p>No products found in this category.</p>
            </div>
          @endif
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
  /* Filter Styles */
  .filter-section {
    margin: 20px 0;
  }
  
  .filter-container {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }
  
  .filter-title {
    margin-bottom: 10px;
    color: #2E7D32;
    font-size: 16px;
    font-weight: bold;
  }
  
  .filter-form {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-direction: row !important; /* Force horizontal layout */
  }
  
  .category-select,
  .price-sort-select {
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #4CAF50;
    background-color: white;
    font-size: 16px;
    width: calc(50% - 40px) !important; /* Explicitly set width */
    color: #333;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234CAF50' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: calc(100% - 15px) center;
    padding-right: 40px;
    max-width: none; /* Remove max-width constraint */
    flex: 1; /* Allow flex grow */
  }
  
  .filter-btn {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: background-color 0.3s;
    white-space: nowrap;
    min-width: 140px; /* Set a minimum width */
  }
  
  .filter-btn:hover {
    background-color: #3b8c3f;
  }
  
  .no-posts-message {
    grid-column: 1 / -1;
    text-align: center;
    padding: 50px 0;
    font-size: 18px;
    color: #666;
  }
  
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
  
  /* Make pagination info display horizontally and larger */
  .pagination-container > div {
    width: 100%;
  }
  
  .pagination-container p.text-sm {
    font-size: 16px !important;
    margin-bottom: 15px;
    text-align: center;
    display: flex;
    justify-content: center;
    gap: 5px;
  }
  
  .pagination-container p.text-sm span {
    display: inline-block;
    font-size: 16px !important;
  }
  
  /* Enhanced themed pagination buttons */
  .pagination-container svg {
    width: 30px;
    height: 30px;
  }
  
  .pagination-container .flex-1 span {
    padding: 10px 16px;
    font-size: 16px;
  }
  
  .pagination-container button, 
  .pagination-container a {
    padding: 8px 14px !important;
    font-size: 16px !important;
    background-color: #f0f7f0 !important; /* Light green background */
    border: 1px solid #4CAF50 !important; /* Green border */
    border-radius: 12px !important; /* Rounder corners for all buttons */
    color: #2E7D32 !important; /* Dark green text */
    transition: all 0.3s ease !important;
    margin: 0 3px !important;
  }
  
  .pagination-container [aria-current="page"] span {
    background-color: #4CAF50 !important;
    color: white !important;
    border-color: #2E7D32 !important;
    font-weight: bold;
    box-shadow: 0 2px 8px rgba(76, 175, 80, 0.4);
    font-size: 20px !important; /* Bigger than regular buttons */
    padding: 6px 12px !important; /* Slightly smaller padding to balance size */
    border-radius: 14px !important; /* Even rounder corners for current page */
  }
  
  /* Regular page numbers bigger than current */
  .pagination-container span[aria-label="pagination.goto"] {
    font-size: 17px !important; 
    padding: 8px 14px !important;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .products-grid {
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 15px;
    }
    
    /* Switch to vertical layout ONLY on mobile */
    .filter-form {
      flex-direction: column !important; /* Override the default row */
      align-items: stretch;
    }
    
    .category-select, 
    .price-sort-select, 
    .filter-btn {
      width: 100% !important;
      margin-bottom: 8px;
    }
  }
  
  /* For medium-sized screens, ensure filters stay horizontal but adapt */
  @media (min-width: 769px) and (max-width: 991px) {
    .filter-form {
      flex-wrap: wrap;
    }
    
    .category-select, 
    .price-sort-select {
      flex: 1;
      min-width: calc(40% - 10px);
    }
    
    .filter-btn {
      margin-left: auto;
    }
  }
</style>

<script>
  // Auto-submit form when changing select values (for better UX)
  document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category-filter');
    const priceSelect = document.getElementById('price-sort');
    
    // Make sure both selects trigger form submit on change
    categorySelect.addEventListener('change', function() {
      this.form.submit();
    });
    
    priceSelect.addEventListener('change', function() {
      this.form.submit();
    });
  });
</script>
@endsection