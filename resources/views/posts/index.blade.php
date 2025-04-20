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
          <form action="{{ route('posts') }}" method="GET" class="filter-form" id="filter-form">
            <select name="category" id="category-filter" class="category-select">
              <option value="all" {{ (!request('category') || request('category') == 'all') ? 'selected' : '' }}>All Categories</option>
              @foreach ($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
              @endforeach
            </select>
            
            <div class="price-range-container">
              <div class="price-inputs">
                <input type="number" name="min_price" id="min-price" placeholder="Min Price" class="price-input" value="{{ request('min_price') }}" min="0">
                <span class="price-separator">to</span>
                <input type="number" name="max_price" id="max-price" placeholder="Max Price" class="price-input" value="{{ request('max_price') }}" min="0">
              </div>
            </div>
            
            <select name="price_sort" id="price-sort" class="price-sort-select">
              <option value="" {{ !request('price_sort') ? 'selected' : '' }}>Price: Default</option>
              <option value="low_high" {{ request('price_sort') == 'low_high' ? 'selected' : '' }}>Price: Low to High</option>
              <option value="high_low" {{ request('price_sort') == 'high_low' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
            
            <button type="submit" class="filter-btn" id="apply-filters">
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
        
        <div class="products-grid" id="products-container">
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
        <div class="pagination-container" id="pagination-container">
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
    width: calc(25% - 20px) !important; /* Adjusted width for new layout */
    color: #333;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234CAF50' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: calc(100% - 15px) center;
    padding-right: 40px;
    max-width: none; /* Remove max-width constraint */
    flex: 1; /* Allow flex grow */
  }

  /* New price range container styles */
  .price-range-container {
    flex: 2;
    display: flex;
    align-items: center;
  }

  .price-inputs {
    display: flex;
    align-items: center;
    width: 100%;
    border-radius: 8px;
    border: 1px solid #4CAF50;
    background-color: white;
    padding: 5px 10px;
  }

  .price-input {
    flex: 1;
    padding: 5px 10px;
    font-size: 16px;
    border: none;
    color: #333;
    outline: none;
    width: calc(50% - 10px);
    text-align: center;
  }

  .price-separator {
    margin: 0 10px;
    color: #4CAF50;
    font-weight: bold;
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
    justify-content: center; /* Add center alignment */
    gap: 5px;
    transition: background-color 0.3s;
    white-space: nowrap;
    min-width: 140px; /* Set a minimum width */
    text-align: center; /* Ensure text is centered */
  }
  
  .filter-btn ion-icon {
    font-size: 18px; /* Standardize icon size */
    margin-right: 2px; /* Small margin to balance visual alignment */
    flex-shrink: 0; /* Prevent icon from shrinking */
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
    .price-range-container,
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
  
  /* SweetAlert2 custom styling - Enhanced sizes */
  .swal2-popup.bigger-modal {
    width: 42em !important; /* Increased from 36em */
    max-width: 95% !important;
    font-size: 1.3rem !important; /* Increased from 1.2rem */
    padding: 2.5em !important; /* Increased from 2em */
    border-radius: 15px !important;
  }
  
  .swal-title {
    font-size: 28px !important; /* Increased from 24px */
    margin-bottom: 20px !important; /* Increased from 15px */
  }
  
  .swal-button {
    border-radius: 30px !important;
    font-size: 18px !important; /* Increased from 16px */
    padding: 14px 28px !important; /* Increased from 12px 24px */
    font-weight: 600 !important;
    letter-spacing: 0.5px !important;
  }
  
  /* Make product image in alert larger */
  .swal2-html-container img {
    width: 100px !important; /* Increased from 80px */
    height: 100px !important; /* Increased from 80px */
    object-fit: cover !important;
  }
  
  /* Make product details text larger */
  .swal2-html-container .product-details {
    font-size: 1.2rem !important;
  }
  
  .swal2-html-container .product-name {
    font-size: 22px !important;
  }
</style>

<!-- Make sure SweetAlert2 is loaded -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category-filter');
    const priceSelect = document.getElementById('price-sort');
    const filterForm = document.getElementById('filter-form');
    
    // Remove auto-submit when changing select values
    // We'll handle it through the Apply Filters button now
    
    // Don't auto-submit for price range inputs
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    
    if (minPriceInput && maxPriceInput) {
      // Validate that max price is greater than min price
      maxPriceInput.addEventListener('change', function() {
        const minPrice = parseInt(minPriceInput.value) || 0;
        const maxPrice = parseInt(this.value) || 0;
        
        if (maxPrice > 0 && maxPrice < minPrice) {
          alert('Maximum price must be greater than minimum price');
          this.value = '';
        }
      });
    }
    
    // Handle filter form submission
    if (filterForm) {
      filterForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        // Show loading indicator
        const productsContainer = document.getElementById('products-container');
        productsContainer.innerHTML = '<div class="loading-indicator"><p>Loading products...</p></div>';
        
        // Get form data
        const formData = new FormData(filterForm);
        const searchParams = new URLSearchParams(formData);
        const url = `{{ route('posts') }}?${searchParams.toString()}`;
        
        // Update URL without refreshing
        window.history.pushState({ path: url }, '', url);
        
        // Make AJAX request
        fetch(url, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.text())
        .then(html => {
          // Create a temporary element to parse the HTML
          const tempDiv = document.createElement('div');
          tempDiv.innerHTML = html;
          
          // Extract the products grid from the response
          const newProductsGrid = tempDiv.querySelector('#products-container');
          const newPagination = tempDiv.querySelector('#pagination-container');
          const newTitle = tempDiv.querySelector('.title-wrapper');
          
          if (newProductsGrid) {
            productsContainer.innerHTML = newProductsGrid.innerHTML;
            
            // Update title and pagination as well
            if (newTitle) {
              document.querySelector('.title-wrapper').innerHTML = newTitle.innerHTML;
            }
            
            if (newPagination) {
              document.getElementById('pagination-container').innerHTML = newPagination.innerHTML;
              
              // Reinitialize pagination links to use AJAX
              setupPaginationLinks();
            }
            
            // Re-initialize add to cart functionality for the new products
            initAddToCartButtons();
          } else {
            productsContainer.innerHTML = '<div class="no-posts-message"><p>Error loading products. Please try again.</p></div>';
          }
        })
        .catch(error => {
          console.error('Error:', error);
          productsContainer.innerHTML = '<div class="no-posts-message"><p>Error loading products. Please try again.</p></div>';
        });
      });
    }
    
    // Set up pagination links to use AJAX
    function setupPaginationLinks() {
      const paginationLinks = document.querySelectorAll('.pagination-container a');
      paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          
          const url = this.getAttribute('href');
          
          // Update URL without refreshing
          window.history.pushState({ path: url }, '', url);
          
          // Show loading indicator
          const productsContainer = document.getElementById('products-container');
          productsContainer.innerHTML = '<div class="loading-indicator"><p>Loading products...</p></div>';
          
          // Make AJAX request to get the new page
          fetch(url, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.text())
          .then(html => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            const newProductsGrid = tempDiv.querySelector('#products-container');
            const newPagination = tempDiv.querySelector('#pagination-container');
            
            if (newProductsGrid) {
              productsContainer.innerHTML = newProductsGrid.innerHTML;
              
              if (newPagination) {
                document.getElementById('pagination-container').innerHTML = newPagination.innerHTML;
                setupPaginationLinks();
              }
              
              // Re-initialize add to cart functionality
              initAddToCartButtons();
            }
          })
          .catch(error => {
            console.error('Error:', error);
            productsContainer.innerHTML = '<div class="no-posts-message"><p>Error loading products. Please try again.</p></div>';
          });
        });
      });
    }
    
    // Initialize add to cart buttons
    function initAddToCartButtons() {
      document.querySelectorAll('[aria-label="add to cart"]').forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          
          const productId = this.getAttribute('data-product-id');
          const productName = this.getAttribute('data-product-name');
          const productImage = this.getAttribute('data-product-image');
          const productPrice = this.getAttribute('data-product-price');
          const quantity = 1; // Default quantity
          
          // Show loading indicator
          Swal.fire({
            title: 'Adding to Cart...',
            text: 'Please wait',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
              Swal.showLoading();
            },
            heightAuto: false,
            customClass: {
              popup: 'bigger-modal'
            }
          });
          
          // Send AJAX request to add to cart
          fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              product_id: productId,
              quantity: quantity
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Show success message with product details
              Swal.fire({
                title: '<span style="color: #517A5B"><i class="bi bi-check-circle-fill"></i> Added to Cart!</span>',
                html: `
                  <div style="display: flex; align-items: center; margin-bottom: 25px; margin-top: 20px;">
                    <img src="${productImage}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                    <div style="margin-left: 20px; text-align: left;" class="product-details">
                      <div style="font-weight: 700; font-size: 22px;" class="product-name">${productName}</div>
                      <div style="font-size: 18px; margin-top: 8px;">Quantity: ${quantity}</div>
                      <div style="font-size: 18px; font-weight: 600; color: #517A5B; margin-top: 5px;">₱${productPrice}</div>
                    </div>
                  </div>
                  <p style="font-size: 18px;">${data.message}</p>
                `,
                icon: 'success',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'Continue Shopping',
                showCancelButton: true,
                cancelButtonText: 'Go to Cart',
                cancelButtonColor: '#6c757d',
                customClass: {
                  popup: 'bigger-modal',
                  title: 'swal-title',
                  confirmButton: 'swal-button',
                  cancelButton: 'swal-button'
                }
              }).then((result) => {
                if (!result.isConfirmed) {
                  // If user clicked "Go to Cart"
                  window.location.href = "{{ route('cart.index') }}";
                }
              });
              
              // Update cart badge count
              const cartBadge = document.querySelector('.btn-badge');
              if (cartBadge) {
                const currentCount = parseInt(cartBadge.textContent || '0');
                cartBadge.textContent = currentCount + 1;
              }
            } else {
              // Show error message
              Swal.fire({
                title: 'Error',
                text: data.message || 'Failed to add item to cart',
                icon: 'error',
                confirmButtonColor: '#517A5B'
              });
            }
          })
          .catch(error => {
            console.error('Error:', error);
            Swal.fire({
              title: 'Error',
              text: 'Something went wrong. Please try again.',
              icon: 'error',
              confirmButtonColor: '#517A5B'
            });
          });
        });
      });
    }
    
    // Set up pagination links on initial load
    setupPaginationLinks();
    
    // Initialize add to cart buttons on initial load
    initAddToCartButtons();
  });
</script>
@endsection