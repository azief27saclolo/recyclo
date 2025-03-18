@extends('components.layout')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Your Shopping Cart</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    @if($cart->items->count() > 0)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4>Cart Items ({{ $cart->items->sum('quantity') }} items)</h4>
                    </div>
                    <div class="col-md-6 text-end d-flex justify-content-end">
                        <form action="{{ route('cart.empty') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-3" style="min-width: 120px;" onclick="return confirm('Are you sure you want to empty your cart?')">
                                Empty Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" style="max-width: 80px;">
                                            @else
                                                <img src="{{ asset('images/no-image.jpg') }}" alt="No Image" class="img-thumbnail me-3" style="max-width: 80px;">
                                            @endif
                                            <div>
                                                <h5>{{ $item->product->name }}</h5>
                                                <p class="text-muted">{{ Str::limit($item->product->description, 50) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width: 70px;">
                                            <button type="submit" class="btn btn-secondary ms-2" style="min-width: 80px;">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="min-width: 90px;">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center justify-content-md-start mb-3 mb-md-0">
                        <a href="{{ route('posts') }}" class="btn btn-secondary px-4" style="min-width: 180px;">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                    <div class="col-md-6 d-flex flex-column align-items-center align-items-md-end">
                        <h5>Total: <span class="text-primary">${{ number_format($cart->total, 2) }}</span></h5>
                        <a href="{{ route('checkout.index') }}" class="btn btn-success px-4 mt-2" style="min-width: 200px;">
                            Proceed to Checkout <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
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
@endsection