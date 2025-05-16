@extends('components.layout')

@section('content')
    <article>
        <!-- Add intro banner -->
        <div class="order-banner" style="background-color: #f8f9fa; padding: 40px 0; text-align: center; margin-bottom: 30px;">
            <div class="container">
                <h1 style="font-size: 36px; margin-bottom: 10px;">My Orders</h1>
                <p style="font-size: 18px; color: #666;">Track and manage your recyclable material orders</p>
            </div>
        </div>

        <section class="section orders" aria-label="orders" data-section>
            <div class="container">
                <!-- Order Stats -->
                <div class="order-stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div class="stat-card" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; align-items: center;">
                        <ion-icon name="bag-handle-outline" style="font-size: 40px; color: #517a5b; margin-right: 15px;"></ion-icon>
                        <div class="stat-info">
                            <h3 style="font-size: 24px; margin: 0;">{{ $orders->whereIn('status', ['processing', 'approved'])->count() }}</h3>
                            <p style="margin: 0; color: #666;">Active Orders</p>
                        </div>
                    </div>
                    <div class="stat-card" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; align-items: center;">
                        <ion-icon name="time-outline" style="font-size: 40px; color: #517a5b; margin-right: 15px;"></ion-icon>
                        <div class="stat-info">
                            <h3 style="font-size: 24px; margin: 0;">{{ $orders->where('status', 'delivering')->count() }}</h3>
                            <p style="margin: 0; color: #666;">In Transit</p>
                        </div>
                    </div>
                    <div class="stat-card" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; align-items: center;">
                        <ion-icon name="checkmark-circle-outline" style="font-size: 40px; color: #517a5b; margin-right: 15px;"></ion-icon>
                        <div class="stat-info">
                            <h3 style="font-size: 24px; margin: 0;">{{ $orders->where('status', 'delivered')->count() }}</h3>
                            <p style="margin: 0; color: #666;">Completed</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Tab Design -->
                <div class="order-tabs" style="display: flex; overflow-x: auto; gap: 10px; margin-bottom: 30px; padding-bottom: 5px;">
                    <button class="tab-btn active" data-tab="pending" style="background: #517a5b; color: white; border: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; white-space: nowrap; cursor: pointer;">
                        <ion-icon name="hourglass-outline" style="margin-right: 5px;"></ion-icon>
                        Pending
                        <span class="badge" style="background: white; color: #517a5b; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; justify-content: center; align-items: center; margin-left: 5px; font-size: 12px;">{{ $orders->where('status', 'pending')->count() }}</span>
                    </button>
                    <button class="tab-btn" data-tab="new" style="background: #f1f1f1; color: #333; border: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; white-space: nowrap; cursor: pointer;">
                        <ion-icon name="file-tray-outline" style="margin-right: 5px;"></ion-icon>
                        Processing
                        <span class="badge" style="background: #517a5b; color: white; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; justify-content: center; align-items: center; margin-left: 5px; font-size: 12px;">{{ $orders->whereIn('status', ['processing', 'approved'])->count() }}</span>
                    </button>
                    <button class="tab-btn" data-tab="to-ship" style="background: #f1f1f1; color: #333; border: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; white-space: nowrap; cursor: pointer;">
                        <ion-icon name="airplane-outline" style="margin-right: 5px;"></ion-icon>
                        Delivering
                        <span class="badge" style="background: #517a5b; color: white; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; justify-content: center; align-items: center; margin-left: 5px; font-size: 12px;">{{ $orders->where('status', 'delivering')->count() }}</span>
                    </button>
                    <button class="tab-btn" data-tab="to-receive" style="background: #f1f1f1; color: #333; border: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; white-space: nowrap; cursor: pointer;">
                        <ion-icon name="checkbox-outline" style="margin-right: 5px;"></ion-icon>
                        For Pick Up
                        <span class="badge" style="background: #517a5b; color: white; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; justify-content: center; align-items: center; margin-left: 5px; font-size: 12px;">{{ $orders->where('status', 'for_pickup')->count() }}</span>
                    </button>
                    <button class="tab-btn" data-tab="completed" style="background: #f1f1f1; color: #333; border: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; white-space: nowrap; cursor: pointer;">
                        <ion-icon name="checkmark-done-outline" style="margin-right: 5px;"></ion-icon>
                        Completed
                        <span class="badge" style="background: #517a5b; color: white; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; justify-content: center; align-items: center; margin-left: 5px; font-size: 12px;">{{ $orders->where('status', 'completed')->count() }}</span>
                    </button>
                    <button class="tab-btn" data-tab="cancelled" style="background: #f1f1f1; color: #333; border: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; white-space: nowrap; cursor: pointer;">
                        <ion-icon name="close-circle-outline" style="margin-right: 5px;"></ion-icon>
                        Cancelled
                        <span class="badge" style="background: #517a5b; color: white; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; justify-content: center; align-items: center; margin-left: 5px; font-size: 12px;">{{ $orders->where('status', 'cancelled')->count() }}</span>
                    </button>
                </div>

                <!-- Pending Orders Tab Content -->
                <div class="order-cards" id="pending-orders" style="display: flex; flex-direction: column; gap: 20px;">
                    @if($orders->where('status', 'pending')->count() > 0)
                        @foreach($orders->where('status', 'pending') as $order)
                            <div class="order-card" style="background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
                                <div class="order-header" style="padding: 15px;">
                                    <img src="{{ asset('storage/' . $order->post->image) }}" alt="{{ $order->post->title }}" class="order-img" style="width: 100%; height: 180px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
                                    <div class="order-details">
                                        <h3 style="margin: 0 0 10px 0; font-size: 18px;">{{ $order->post->title }}</h3>
                                        <p style="margin: 5px 0; color: #666;">Seller: {{ $order->seller->username }}</p>
                                        <p style="margin: 5px 0; color: #666;">Order Date: {{ $order->created_at->format('M d, Y') }}</p>
                                        <p style="margin: 5px 0; color: #666;">Quantity: {{ $order->quantity }}kg</p>
                                        <p style="margin: 5px 0; color: #666;">Price: ₱{{ $order->post->price }}.00 per kg</p>
                                        <p style="margin: 5px 0; color: #666;">Delivery Fee: ₱35.00</p>
                                        <p style="margin: 10px 0; font-weight: 600; color: #517a5b;">Total: ₱{{ $order->total_amount }}.00</p>
                                    </div>
                                    <div class="order-status" style="margin-top: 10px;">
                                        <span class="status-badge pending" style="background: #ffc107; color: #212529; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">Pending</span>
                                    </div>
                                </div>
                                <div class="order-footer" style="background: #f8f9fa; padding: 15px; position: relative;">
                                    <button class="btn btn-primary track-location-btn" 
                                            data-location="{{ $order->seller->location ?? 'Zamboanga City' }}" 
                                            style="background: #517a5b; color: white; border: none; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px;">
                                        <ion-icon name="location-outline"></ion-icon> Track Location
                                    </button>
                                    <button class="btn btn-secondary cancel-order-btn" 
                                            data-order-id="{{ $order->id }}" 
                                            style="background: white; border: 1px solid #517a5b; color: #517a5b; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer;">
                                        Cancel Order
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                            <ion-icon name="hourglass-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No pending orders</p>
                            <a href="{{ route('posts') }}" style="background: #517a5b; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; display: inline-block; margin-top: 15px;">Start Shopping</a>
                        </div>
                    @endif
                </div>

                <!-- Processing Orders Tab Content -->
                <div class="order-cards" id="new-orders" style="display: none; flex-direction: column; gap: 20px;">
                    @if($orders->whereIn('status', ['processing', 'approved'])->count() > 0)
                        @foreach($orders->whereIn('status', ['processing', 'approved']) as $order)
                            <div class="order-card" style="background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
                                <div class="order-header" style="padding: 15px;">
                                    <img src="{{ asset('storage/' . $order->post->image) }}" alt="{{ $order->post->title }}" class="order-img" style="width: 100%; height: 180px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
                                    <div class="order-details">
                                        <h3 style="margin: 0 0 10px 0; font-size: 18px;">{{ $order->post->title }}</h3>
                                        <p style="margin: 5px 0; color: #666;">Seller: {{ $order->seller->username }}</p>
                                        <p style="margin: 5px 0; color: #666;">Order Date: {{ $order->created_at->format('M d, Y') }}</p>
                                        <p style="margin: 5px 0; color: #666;">Quantity: {{ $order->quantity }}kg</p>
                                        <p style="margin: 5px 0; color: #666;">Price: ₱{{ $order->post->price }}.00 per kg</p>
                                        <p style="margin: 5px 0; color: #666;">Delivery Fee: ₱35.00</p>
                                        <p style="margin: 10px 0; font-weight: 600; color: #517a5b;">Total: ₱{{ $order->total_amount }}.00</p>
                                    </div>
                                    <div class="order-status" style="margin-top: 10px;">
                                        <span class="status-badge processing" style="background: #28a745; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">Processing</span>
                                    </div>
                                </div>
                                <div class="order-footer" style="background: #f8f9fa; padding: 15px; position: relative;">
                                    <button class="btn btn-secondary cancel-order-btn" 
                                            data-order-id="{{ $order->id }}" 
                                            style="background: white; border: 1px solid #dc3545; color: #dc3545; padding: 6px 12px; border-radius: 5px; font-size: 14px; position: absolute; bottom: 15px; right: 15px; cursor: pointer;">
                                        <i class="bi bi-x-circle" style="margin-right: 4px;"></i>Cancel
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                            <ion-icon name="file-tray-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No processing orders</p>
                            <a href="{{ route('posts') }}" style="background: #517a5b; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; display: inline-block; margin-top: 15px;">Start Shopping</a>
                        </div>
                    @endif
                </div>

                <!-- Delivering Orders Tab Content -->
                <div class="order-cards" id="to-ship-orders" style="display: none; flex-direction: column; gap: 20px;">
                    @if($orders->where('status', 'delivering')->count() > 0)
                        @foreach($orders->where('status', 'delivering') as $order)
                            <div class="order-card" style="background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
                                <div class="order-header" style="padding: 15px;">
                                    <img src="{{ asset('storage/' . $order->post->image) }}" alt="{{ $order->post->title }}" class="order-img" style="width: 100%; height: 180px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
                                    <div class="order-details">
                                        <h3 style="margin: 0 0 10px 0; font-size: 18px;">{{ $order->post->title }}</h3>
                                        <p style="margin: 5px 0; color: #666;">Seller: {{ $order->seller->username }}</p>
                                        <p style="margin: 5px 0; color: #666;">Order Date: {{ $order->created_at->format('M d, Y') }}</p>
                                        <p style="margin: 5px 0; color: #666;">Quantity: {{ $order->quantity }}kg</p>
                                        <p style="margin: 5px 0; color: #666;">Price: ₱{{ $order->post->price }}.00 per kg</p>
                                        <p style="margin: 5px 0; color: #666;">Delivery Fee: ₱35.00</p>
                                        <p style="margin: 10px 0; font-weight: 600; color: #517a5b;">Total: ₱{{ $order->total_amount }}.00</p>
                                    </div>
                                    <div class="order-status" style="margin-top: 10px;">
                                        <span class="status-badge delivering" style="background: #0d6efd; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">Delivering</span>
                                    </div>
                                </div>
                                <div class="order-footer" style="background: #f8f9fa; padding: 15px; display: flex; gap: 10px;">
                                    <button class="btn btn-primary track-location-btn" 
                                            data-location="{{ $order->seller->location ?? 'Zamboanga City' }}" 
                                            style="background: #517a5b; color: white; border: none; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px;">
                                        <ion-icon name="location-outline"></ion-icon> Track Location
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                            <ion-icon name="airplane-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No orders in transit</p>
                            <a href="{{ route('posts') }}" style="background: #517a5b; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; display: inline-block; margin-top: 15px;">Start Shopping</a>
                        </div>
                    @endif
                </div>

                <!-- For Pick Up Orders Tab Content -->
                <div class="order-cards" id="to-receive-orders" style="display: none; flex-direction: column; gap: 20px;">
                    @if($orders->where('status', 'for_pickup')->count() > 0)
                        @foreach($orders->where('status', 'for_pickup') as $order)
                            <div class="order-card" style="background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
                                <div class="order-header" style="padding: 15px;">
                                    <img src="{{ asset('storage/' . $order->post->image) }}" alt="{{ $order->post->title }}" class="order-img" style="width: 100%; height: 180px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
                                    <div class="order-details">
                                        <h3 style="margin: 0 0 10px 0; font-size: 18px;">{{ $order->post->title }}</h3>
                                        <p style="margin: 5px 0; color: #666;">Seller: {{ $order->seller->username }}</p>
                                        <p style="margin: 5px 0; color: #666;">Order Date: {{ $order->created_at->format('M d, Y') }}</p>
                                        <p style="margin: 5px 0; color: #666;">Quantity: {{ $order->quantity }}kg</p>
                                        <p style="margin: 5px 0; color: #666;">Price: ₱{{ $order->post->price }}.00 per kg</p>
                                        <p style="margin: 5px 0; color: #666;">Delivery Fee: ₱35.00</p>
                                        <p style="margin: 10px 0; font-weight: 600; color: #517a5b;">Total: ₱{{ $order->total_amount }}.00</p>
                                    </div>
                                    <div class="order-status" style="margin-top: 10px;">
                                        <span class="status-badge for_pickup" style="background: #6610f2; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">For Pick Up</span>
                                    </div>
                                </div>
                                <div class="order-footer" style="background: #f8f9fa; padding: 15px; display: flex; gap: 10px;">
                                    <button class="btn btn-primary track-location-btn" 
                                            data-location="{{ $order->seller->location ?? 'Zamboanga City' }}" 
                                            style="background: #517a5b; color: white; border: none; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px;">
                                        <ion-icon name="location-outline"></ion-icon> Track Location
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                            <ion-icon name="checkbox-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No orders ready for pick up</p>
                            <a href="{{ route('posts') }}" style="background: #517a5b; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; display: inline-block; margin-top: 15px;">Start Shopping</a>
                        </div>
                    @endif
                </div>

                <!-- Completed Orders Tab Content -->
                <div class="order-cards" id="completed-orders" style="display: none; flex-direction: column; gap: 20px;">
                    @if($orders->where('status', 'completed')->count() > 0)
                        @foreach($orders->where('status', 'completed') as $order)
                            <div class="order-card" style="background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
                                <div class="order-header" style="padding: 15px;">
                                    <img src="{{ asset('storage/' . $order->post->image) }}" alt="{{ $order->post->title }}" class="order-img" style="width: 100%; height: 180px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
                                    <div class="order-details">
                                        <h3 style="margin: 0 0 10px 0; font-size: 18px;">{{ $order->post->title }}</h3>
                                        <p style="margin: 5px 0; color: #666;">Seller: {{ $order->seller->username }}</p>
                                        <p style="margin: 5px 0; color: #666;">Order Date: {{ $order->created_at->format('M d, Y') }}</p>
                                        <p style="margin: 5px 0; color: #666;">Completed Date: {{ $order->updated_at->format('M d, Y') }}</p>
                                        <p style="margin: 5px 0; color: #666;">Quantity: {{ $order->quantity }}kg</p>
                                        <p style="margin: 5px 0; color: #666;">Price: ₱{{ $order->post->price }}.00 per kg</p>
                                        <p style="margin: 5px 0; color: #666;">Delivery Fee: ₱35.00</p>
                                        <p style="margin: 10px 0; font-weight: 600; color: #517a5b;">Total: ₱{{ $order->total_amount }}.00</p>
                                    </div>
                                    <div class="order-status" style="margin-top: 10px;">
                                        <span class="status-badge completed" style="background: #198754; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">Completed</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                            <ion-icon name="checkmark-done-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No completed orders</p>
                            <a href="{{ route('posts') }}" style="background: #517a5b; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; display: inline-block; margin-top: 15px;">Start Shopping</a>
                        </div>
                    @endif
                </div>

                <!-- Cancelled Orders Tab Content -->
                <div class="order-cards" id="cancelled-orders" style="display: none; flex-direction: column; gap: 20px;">
                    @if($orders->where('status', 'cancelled')->count() > 0)
                        @foreach($orders->where('status', 'cancelled') as $order)
                            <div class="order-card" style="background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
                                <div class="order-header" style="padding: 15px;">
                                    <img src="{{ asset('storage/' . $order->post->image) }}" alt="{{ $order->post->title }}" class="order-img" style="width: 100%; height: 180px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
                                    <div class="order-details">
                                        <h3 style="margin: 0 0 10px 0; font-size: 18px;">{{ $order->post->title }}</h3>
                                        <p style="margin: 5px 0; color: #666;">Seller: {{ $order->seller->username }}</p>
                                        <p style="margin: 5px 0; color: #666;">Order Date: {{ $order->created_at->format('M d, Y') }}</p>
                                        <p style="margin: 5px 0; color: #666;">Cancelled Date: {{ $order->updated_at->format('M d, Y') }}</p>
                                        <p style="margin: 5px 0; color: #666;">Quantity: {{ $order->quantity }}kg</p>
                                        <p style="margin: 5px 0; color: #666;">Price: ₱{{ $order->post->price }}.00 per kg</p>
                                        <p style="margin: 5px 0; color: #666;">Delivery Fee: ₱35.00</p>
                                        <p style="margin: 10px 0; font-weight: 600; color: #517a5b;">Total: ₱{{ $order->total_amount }}.00</p>
                                    </div>
                                    <div class="order-status" style="margin-top: 10px;">
                                        <span class="status-badge cancelled" style="background: #dc3545; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">Cancelled</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                            <ion-icon name="close-circle-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No cancelled orders</p>
                            <a href="{{ route('posts') }}" style="background: #517a5b; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; display: inline-block; margin-top: 15px;">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </article>

    <!-- Add Location Map Modal -->
    <div id="locationMapModal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
        <div style="background-color: white; margin: 50px auto; padding: 20px; width: 90%; max-width: 800px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h2 style="color: #517a5b; font-size: 24px; font-weight: 600; margin: 0;">Location Tracker</h2>
                <span id="closeLocationMap" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            </div>
            <div style="margin-bottom: 20px;">
                <p id="locationDetails" style="font-size: 16px; margin-bottom: 15px;">Loading location details...</p>
                <div id="locationMap" style="height: 400px; width: 100%; border-radius: 8px; border: 1px solid #ccc;"></div>
            </div>
        </div>
    </div>

    <!-- Add Cancellation Reason Modal -->
    <div id="cancellationReasonModal" class="modal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 8px; position: relative;">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                <h2 style="margin: 0; color: #333; font-size: 1.5rem;">Cancel Order</h2>
                <span class="close" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <form id="cancellationReasonForm">
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="cancellationReason" style="display: block; margin-bottom: 8px; color: #333;">Please select a reason for cancellation:</label>
                        <select id="cancellationReason" class="form-control" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Select a reason</option>
                            <option value="no_longer_want">I don't want to buy anymore</option>
                            <option value="wrong_order">I made a mistake in ordering</option>
                            <option value="found_better">Found a better deal elsewhere</option>
                            <option value="other">Other reason</option>
                        </select>
                    </div>
                    <div id="otherReasonDiv" class="form-group" style="display: none; margin-bottom: 20px;">
                        <label for="otherReason" style="display: block; margin-bottom: 8px; color: #333;">Please specify your reason:</label>
                        <textarea id="otherReason" class="form-control" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                    </div>
                    <div class="form-group" style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button type="button" class="btn btn-secondary" onclick="closeCancellationModal()" style="padding: 8px 16px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancel</button>
                        <button type="submit" class="btn btn-danger" style="padding: 8px 16px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Confirm Cancellation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

    <!-- Add custom SweetAlert2 styles -->
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .modal-header h2 {
            margin: 0;
            color: #333;
            font-size: 1.5rem;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            document.querySelectorAll('.tab-btn').forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons
                    document.querySelectorAll('.tab-btn').forEach(btn => {
                        btn.classList.remove('active');
                        btn.style.background = '#f1f1f1';
                        btn.style.color = '#333';
                    });
                    
                    // Add active class to clicked button
                    button.classList.add('active');
                    button.style.background = '#517a5b';
                    button.style.color = 'white';
                    
                    // Hide all order cards
                    document.querySelectorAll('.order-cards').forEach(cards => {
                        cards.style.display = 'none';
                    });
                    
                    // Show selected tab's cards
                    let tabId = button.getAttribute('data-tab');
                    const targetElement = document.getElementById(`${tabId}-orders`);
                    if (targetElement) {
                        targetElement.style.display = 'flex';
                    }
                });
            });

            // Initial tab check
            const hash = window.location.hash.substring(1);
            if (hash) {
                const tabBtn = document.querySelector(`.tab-btn[data-tab="${hash}"]`);
                if (tabBtn) tabBtn.click();
            }

            // Cancel Order Functionality - Single event listener for all cancel buttons
            document.querySelectorAll('.cancel-order-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    const orderStatus = this.closest('.order-card').querySelector('.status-badge').textContent.trim().toLowerCase();
                    
                    if (orderStatus === 'processing') {
                        showCancellationModal(orderId);
                    } else {
                        // For non-processing orders, use the existing confirmation
                        Swal.fire({
                            title: 'Cancel Order?',
                            text: "Are you sure you want to cancel this order? This action cannot be undone.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, cancel it!',
                            cancelButtonText: 'No, keep it'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                cancelOrder(orderId);
                            }
                        });
                    }
                });
            });
        });

        // Modal functions
        function showCancellationModal(orderId) {
            const modal = document.getElementById('cancellationReasonModal');
            modal.style.display = 'block';
            modal.setAttribute('data-order-id', orderId);
            
            // Reset form
            document.getElementById('cancellationReasonForm').reset();
            document.getElementById('otherReasonDiv').style.display = 'none';
            
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }

        function closeCancellationModal() {
            const modal = document.getElementById('cancellationReasonModal');
            modal.style.display = 'none';
            document.getElementById('cancellationReasonForm').reset();
            document.getElementById('otherReasonDiv').style.display = 'none';
            
            // Restore body scrolling
            document.body.style.overflow = 'auto';
        }

        // Handle cancellation reason form submission
        document.getElementById('cancellationReasonForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const modal = document.getElementById('cancellationReasonModal');
            const orderId = modal.getAttribute('data-order-id');
            const reason = document.getElementById('cancellationReason').value;
            const otherReason = document.getElementById('otherReason').value;
            
            if (reason === 'other' && !otherReason.trim()) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please specify your reason for cancellation.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
                return;
            }
            
            const cancellationReason = reason === 'other' ? otherReason : reason;
            cancelOrder(orderId, cancellationReason);
            closeCancellationModal();
        });

        // Cancel order function
        function cancelOrder(orderId, reason = null) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            if (reason) {
                formData.append('cancellation_reason', reason);
            }
            
            fetch(`/orders/${orderId}/cancel-user-order`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || response.statusText);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Cancelled!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#517a5b'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Something went wrong while cancelling the order.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        }

        // Handle the "Other" reason selection
        document.getElementById('cancellationReason').addEventListener('change', function() {
            const otherReasonDiv = document.getElementById('otherReasonDiv');
            otherReasonDiv.style.display = this.value === 'other' ? 'block' : 'none';
        });

        // Close modal when clicking the X
        document.querySelector('#cancellationReasonModal .close').addEventListener('click', closeCancellationModal);

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('cancellationReasonModal');
            if (e.target === modal) {
                closeCancellationModal();
            }
        });
    </script>

    <!-- Include Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endsection