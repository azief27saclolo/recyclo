@extends('components.layout')

@section('content')
<style>
    .favorites-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .favorites-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .favorites-title {
        color: var(--hoockers-green);
        font-size: 32px;
        margin-bottom: 10px;
    }

    .favorites-subtitle {
        color: #666;
        font-size: 18px;
    }

    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .favorite-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }

    .favorite-card:hover {
        transform: translateY(-5px);
    }

    .product-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        color: white;
        background: rgba(81, 122, 91, 0.9);
        backdrop-filter: blur(5px);
    }

    .product-info {
        padding: 20px;
    }

    .shop-name {
        color: var(--hoockers-green);
        font-size: 16px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .product-name {
        font-size: 20px;
        margin-bottom: 10px;
        color: #333;
    }

    .product-price {
        color: var(--hoockers-green);
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .product-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .action-btn {
        padding: 8px 15px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 16px;
    }

    .remove-btn {
        color: #dc3545;
        background: none;
    }

    .view-btn {
        background: var(--hoockers-green);
        color: white;
        text-decoration: none;
    }

    .view-btn:hover {
        background: #3a5a40; /* Explicit color instead of var(--hoockers-green_80) */
        color: white !important; /* Force text to stay white with !important */
        text-decoration: none;
    }

    .remove-btn:hover {
        background: #fff5f5;
    }

    .empty-favorites {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .empty-favorites i {
        font-size: 64px;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-favorites h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 24px;
    }

    .empty-favorites p {
        margin-bottom: 20px;
        font-size: 18px;
    }

    .browse-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 25px;
        background: var(--hoockers-green);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 16px;
    }

    .browse-btn:hover {
        background: var(--hoockers-green_80);
        transform: translateY(-2px);
    }

    .popup-message {
        position: fixed;
        top: 20px;
        right: 20px;
        color: white;
        padding: 10px;
        border-radius: 5px;
        z-index: 1000;
        font-size: 16px;
    }
    
    .popup-message.success {
        background-color: #28a745;
    }
    
    .popup-message.error {
        background-color: #dc3545;
    }

    @media (max-width: 768px) {
        .favorites-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }
</style>

<div class="favorites-container">
    <div class="favorites-header">
        <h1 class="favorites-title">My Favorites</h1>
        <p class="favorites-subtitle">Products you've liked and saved for later</p>
    </div>

    @if($favorites->isEmpty())
    <div class="empty-favorites">
        <i class="bi bi-heart"></i>
        <h3>No favorites yet</h3>
        <p>Items you like will appear here</p>
        <a href="{{ route('posts') }}" class="browse-btn">
            <i class="bi bi-shop"></i> Browse Products
        </a>
    </div>
    @else
    <div class="favorites-grid">
        @foreach ($favorites as $post)
        <div class="favorite-card">
            <div class="product-image">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                <span class="category-badge">{{ $post->category }}</span>
            </div>
            <div class="product-info">
                <div class="shop-name">
                    <i class="bi bi-shop"></i> 
                    @if($post->user)
                        {{ $post->user->username ? $post->user->username . "'s Shop" : 'Unknown Seller' }}
                    @else
                        Unknown Seller
                    @endif
                </div>
                <h3 class="product-name">{{ $post->title }}</h3>
                <div class="product-price">₱{{ $post->price }}.00</div>
                <div class="product-actions">
                    <form action="{{ route('favorites.remove', $post) }}" method="POST" class="remove-favorite-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn remove-btn">
                            <i class="bi bi-heart-fill"></i> Remove
                        </button>
                    </form>
                    <a href="{{ route('posts.show', $post) }}" class="action-btn view-btn">
                        <i class="bi bi-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Enhanced removal with AJAX and feedback
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.remove-favorite-form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const card = this.closest('.favorite-card');
                const productName = card.querySelector('.product-name').innerText;
                const formAction = this.getAttribute('action');
                const formData = new FormData(this);
                const method = 'POST';
                
                // Show confirmation modal
                Swal.fire({
                    title: 'Remove from favorites?',
                    text: `Do you want to remove "${productName}" from your favorites?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'Cancel',
                    width: '32em',
                    customClass: {
                        title: 'fs-4 fw-bold',
                        popup: 'swal-large',
                        confirmButton: 'btn-lg',
                        cancelButton: 'btn-lg'
                    },
                    backdrop: `rgba(0,0,0,0.4)`,
                    padding: '2em'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Begin the visual fade out
                        card.style.opacity = '0';
                        card.style.transition = 'opacity 0.3s ease';
                        
                        // Send AJAX request
                        fetch(formAction, {
                            method: method,
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                setTimeout(() => {
                                    // Remove the card from the DOM
                                    card.remove();
                                    
                                    // Check if there are any cards left
                                    const remainingCards = document.querySelectorAll('.favorite-card');
                                    if (remainingCards.length === 0) {
                                        // Reload the page to show the empty state
                                        window.location.reload();
                                    }
                                    
                                    // Show success message
                                    Swal.fire({
                                        title: 'Removed!',
                                        text: `"${productName}" has been removed from your favorites.`,
                                        icon: 'success',
                                        confirmButtonColor: '#28a745',
                                        customClass: {
                                            popup: 'swal-large',
                                            title: 'fs-4 fw-bold',
                                            confirmButton: 'btn-lg'
                                        },
                                        timer: 2000,
                                        timerProgressBar: true
                                    });
                                }, 300);
                            } else {
                                throw new Error('Something went wrong');
                            }
                        })
                        .catch(error => {
                            // Restore opacity if there was an error
                            card.style.opacity = '1';
                            
                            Swal.fire({
                                title: 'Error!',
                                text: 'Could not remove the item. Please try again.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545',
                                customClass: {
                                    popup: 'swal-large'
                                }
                            });
                        });
                    }
                });
            });
        });
    });
</script>

<style>
    /* Custom styles for SweetAlert2 */
    .swal-large {
        font-size: 18px !important;
    }
    
    .swal2-title {
        font-size: 24px !important;
    }
    
    .swal2-html-container {
        font-size: 18px !important;
    }
    
    .swal2-confirm, .swal2-cancel {
        padding: 12px 24px !important;
        font-size: 16px !important;
    }
    
    /* Additional styling for success message */
    .swal2-popup.swal2-toast {
        padding: 0.75em 1.5em;
        font-size: 1.1em;
    }
</style>
@endsection