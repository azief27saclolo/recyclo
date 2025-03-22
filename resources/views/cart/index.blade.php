@extends('components.layout')

@section('content')
<style>
    .cart-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .cart-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .cart-title {
        color: var(--hoockers-green);
        font-size: 32px; /* Changed from 2rem */
        margin-bottom: 10px;
    }
    
    .cart-subtitle {
        font-size: 18px; /* Added bigger font size */
    }

    .cart-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }

    .cart-items {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #eee;
        gap: 20px;
    }

    .item-image {
        width: 120px;
        height: 120px;
        border-radius: 10px;
        object-fit: cover;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-size: 20px; /* Changed from 1.2rem */
        margin-bottom: 5px;
        color: #333;
    }

    .shop-name {
        color: var(--hoockers-green);
        font-size: 16px; /* Changed from 0.9rem */
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .quantity-controls {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
        margin: 15px 0;
    }
    
    .quantity-controls form {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
    }

    .qty-btn {
        padding: 5px 12px;
        border: none;
        background: var(--hoockers-green);
        color: white;
        border-radius: 5px;
        cursor: pointer;
        height: 35px;
        width: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qty-input {
        width: 50px;
        text-align: center;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        height: 35px;
        font-size: 16px; /* Added font size */
    }

    .item-price {
        font-size: 20px; /* Changed from 1.2rem */
        color: var(--hoockers-green);
        font-weight: 600;
    }

    .remove-btn {
        color: #dc3545;
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .remove-btn:hover {
        background: #fff5f5;
    }

    .cart-summary {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        height: fit-content;
    }

    .summary-title {
        font-size: 22px; /* Changed from 1.3rem */
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        color: #666;
        font-size: 16px; /* Added font size */
    }

    .summary-total {
        font-size: 20px; /* Changed from 1.2rem */
        color: var(--hoockers-green);
        font-weight: 600;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #eee;
    }

    .checkout-btn {
        width: 100%;
        padding: 15px;
        background: var(--hoockers-green);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px; /* Changed from 1.1rem */
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    .checkout-btn:hover {
        background: var(--hoockers-green_80);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .cart-content {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="cart-container">
    <div class="cart-header">
        <h1 class="cart-title">Shopping Cart</h1>
        <p class="cart-subtitle">Review your items before checkout</p>
    </div>

    @if($cart->items->count() > 0)
        <div class="cart-content">
            <div class="cart-items">
                @foreach($cart->items as $item)
                    <div class="cart-item">
                        @if($item->product)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="item-image">
                            <div class="item-details">
                                <div class="shop-name">
                                    <i class="bi bi-shop"></i> {{ $item->product->user->shop->name ?? 'Unknown Shop' }}
                                </div>
                                <h3 class="item-name">{{ $item->product->name }}</h3>
                                <div class="quantity-controls">
                                    <button class="qty-btn" type="button" onclick="updateCartItem({{ $item->id }}, '-')">-</button>
                                    <input type="number" id="qty-input-{{ $item->id }}" class="qty-input" value="{{ $item->quantity }}" min="1" readonly>
                                    <button class="qty-btn" type="button" onclick="updateCartItem({{ $item->id }}, '+')">+</button>
                                </div>
                                <div class="item-price">₱{{ number_format($item->price, 2) }} per kg</div>
                            </div>
                        @else
                            <div class="item-image text-center">
                                <i class="bi bi-exclamation-triangle" style="font-size: 2rem; color: #dc3545;"></i>
                            </div>
                            <div class="item-details">
                                <h3 class="item-name" style="color: #dc3545;">Product no longer available</h3>
                                <p>This product has been removed or is no longer available</p>
                                <div class="item-price">₱{{ number_format($item->price, 2) }}</div>
                            </div>
                        @endif
                        <button type="button" class="remove-btn" onclick="confirmRemoveItem({{ $item->id }}, '{{ $item->product ? $item->product->name : 'Unavailable Product' }}')">
                            <i class="bi bi-trash"></i> Remove
                        </button>
                        <!-- Hidden form for item removal -->
                        <form id="remove-form-{{ $item->id }}" action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <h2 class="summary-title">Order Summary</h2>
                <div class="summary-row">
                    <span>Subtotal ({{ $cart->items->sum('quantity') }} items)</span>
                    <span>₱{{ number_format($cart->total, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Service Fee</span>
                    <span>₱5.00</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>₱{{ number_format($cart->total + 5, 2) }}</span>
                </div>
                <button class="checkout-btn" onclick="beforeCheckout()">
                    Proceed to Checkout
                </button>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart fa-5x text-muted"></i>
            </div>
            <h3>Your cart is empty</h3>
            <p class="text-muted">Looks like you have not added any products to your cart yet.</p>
            <div style="display: flex; justify-content: center; align-items: center;">
                <a href="{{ route('posts') }}" class="btn btn-primary mt-3" style="min-width: 200px; font-size: 1.2rem; padding: 10px 20px; font-weight: 500;">
                    <i class="fas fa-shopping-bag"></i> Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Add SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Enhanced SweetAlert2 styling */
    .swal2-popup.bigger-modal {
        width: 42em !important; /* Increased from 36em */
        max-width: 95% !important;
        font-size: 1.3rem !important; /* Increased from 1.2rem */
        padding: 2.5em !important; /* Increased from 2em */
        border-radius: 15px !important;
    }
    
    .swal2-title {
        font-size: 28px !important; /* Increased from 24px */
        margin-bottom: 20px !important; /* Increased from 15px */
    }
    
    .swal2-html-container {
        font-size: 1.2rem !important;
    }
    
    .swal2-confirm, .swal2-cancel {
        border-radius: 30px !important;
        font-size: 18px !important; /* Increased from 16px */
        padding: 14px 28px !important; /* Increased from 12px 24px */
        font-weight: 600 !important;
        letter-spacing: 0.5px !important;
    }
</style>

<script>
    // Show success message if session has 'success' notification
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#517A5B',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'bigger-modal'
            }
        });
    @endif

    // Show error message if session has 'error' notification
    @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonColor: '#517A5B',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'bigger-modal'
            }
        });
    @endif

    function updateCartItem(itemId, action) {
        const input = document.getElementById(`qty-input-${itemId}`);
        let value = parseInt(input.value);
        
        if (action === '+') {
            value += 1;
        } else if (action === '-' && value > 1) {
            value -= 1;
        } else {
            return; // Don't proceed if trying to go below 1
        }
        
        // Show loading state
        input.disabled = true;
        
        // Use a simple form submission instead of fetch API
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/cart/update/${itemId}`;
        form.style.display = 'none';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        
        const quantityField = document.createElement('input');
        quantityField.type = 'hidden';
        quantityField.name = 'quantity';
        quantityField.value = value;
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        form.appendChild(quantityField);
        
        document.body.appendChild(form);
        form.submit();
    }

    // Confirmation function for removing cart items
    function confirmRemoveItem(itemId, productName) {
        Swal.fire({
            title: 'Remove Item?',
            html: `Are you sure you want to remove <strong>${productName}</strong> from your cart?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'No, keep it',
            customClass: {
                popup: 'bigger-modal'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the hidden form to remove the item
                document.getElementById(`remove-form-${itemId}`).submit();
            }
        });
    }

    // Remove the event listeners that interfere with form submission
    // This code was conflicting with the form submission from the modal
    /*
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.cart-item');
            item.style.opacity = '0';
            setTimeout(() => item.remove(), 300);
        });
    });
    */

    // Check for unavailable products before proceeding to checkout
    function beforeCheckout() {
        @if($cart->items->contains(function($item) { return $item->product === null; }))
            Swal.fire({
                title: 'Unavailable Products',
                text: 'Your cart contains products that are no longer available. Please remove them before checkout.',
                icon: 'warning',
                confirmButtonColor: '#517A5B',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'bigger-modal'
                }
            });
        @else
            window.location.href = '{{ route("checkout") }}';
        @endif
    }
</script>
@endsection