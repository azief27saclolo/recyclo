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
                            <h3 style="font-size: 24px; margin: 0;">{{ $orders->where('status', 'processing')->count() }}</h3>
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
                        <span class="badge" style="background: #517a5b; color: white; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; justify-content: center; align-items: center; margin-left: 5px; font-size: 12px;">{{ $orders->where('status', 'processing')->count() }}</span>
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
                                <div class="order-footer" style="background: #f8f9fa; padding: 15px; display: flex; gap: 10px;">
                                    <button class="btn btn-primary track-location-btn" 
                                            data-location="{{ $order->seller->location ?? 'Zamboanga City' }}" 
                                            style="background: #517a5b; color: white; border: none; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px;">
                                        <ion-icon name="location-outline"></ion-icon> Track Location
                                    </button>
                                    <button class="btn btn-secondary" style="background: white; border: 1px solid #517a5b; color: #517a5b; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer;">Cancel Order</button>
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

                <!-- Processing Orders Tab Content (previously "New Orders") -->
                <div class="order-cards" id="new-orders" style="display: none; flex-direction: column; gap: 20px;">
                    @if($orders->where('status', 'processing')->count() > 0)
                        @foreach($orders->where('status', 'processing') as $order)
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
                                        <span class="status-badge processing" style="background: #17a2b8; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">Processing</span>
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
                                        <p style="margin: 10px 0; font-weight: 600; color: #517a5b;">Total: ₱{{ $order->total_amount }}.00</p>
                                    </div>
                                    <div class="order-status" style="margin-top: 10px;">
                                        <span class="status-badge in-transit" style="background: #17a2b8; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">Delivering</span>
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
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No orders being delivered</p>
                        </div>
                    @endif
                </div>

                <!-- For Pick Up Orders Tab Content (previously Delivered) -->
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
                                        <p style="margin: 10px 0; font-weight: 600; color: #517a5b;">Total: ₱{{ $order->total_amount }}.00</p>
                                    </div>
                                    <div class="order-status" style="margin-top: 10px;">
                                        <span class="status-badge to-deliver" style="background: #28a745; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">For Pick Up</span>
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
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No delivered orders</p>
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
                                        <p style="margin: 5px 0; color: #666;">Delivery Date: {{ $order->updated_at->format('M d, Y') }}</p>
                                        <p style="margin: 5px 0; color: #666;">Quantity: {{ $order->quantity }}kg</p>
                                        <p style="margin: 5px 0; color: #666;">Price: ₱{{ $order->post->price }}.00 per kg</p>
                                        <p style="margin: 5px 0; color: #666;">Delivery Fee: ₱35.00</p>
                                        <p style="margin: 10px 0; font-weight: 600; color: #517a5b;">Total: ₱{{ $order->total_amount }}.00</p>
                                    </div>
                                    <div class="order-status" style="margin-top: 10px;">
                                        <span class="status-badge completed" style="background: #28a745; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">Completed</span>
                                    </div>
                                </div>
                                <div class="order-footer" style="background: #f8f9fa; padding: 15px; display: flex; gap: 10px;">
                                    <button class="btn btn-primary" style="background: #517a5b; color: white; border: none; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer;" onclick="location.href='{{ route('posts') }}'">Buy Again</button>
                                    <button class="btn btn-secondary" style="background: white; border: 1px solid #517a5b; color: #517a5b; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer;">Review</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                            <ion-icon name="checkmark-done-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No completed orders</p>
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
                                <div class="order-footer" style="background: #f8f9fa; padding: 15px; display: flex; gap: 10px;">
                                    <button class="btn btn-primary" style="background: #517a5b; color: white; border: none; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer;" onclick="location.href='{{ route('posts') }}'">Buy Again</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                            <ion-icon name="close-circle-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No cancelled orders</p>
                        </div>
                    @endif
                </div>

                <!-- ...other tab contents... -->
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

    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
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
                    
                    // Show selected tab's cards - using flex instead of grid
                    let tabId = button.getAttribute('data-tab');
                    document.getElementById(`${tabId}-orders`).style.display = 'flex';
                });
            });

            // Track Location button click handlers
            const locationMapModal = document.getElementById('locationMapModal');
            const closeLocationMap = document.getElementById('closeLocationMap');
            const locationDetails = document.getElementById('locationDetails');
            let map = null; 
            
            // Close modal when X is clicked
            closeLocationMap.addEventListener('click', function() {
                locationMapModal.style.display = 'none';
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === locationMapModal) {
                    locationMapModal.style.display = 'none';
                }
            });
            
            // Track location button click handler
            document.querySelectorAll('.track-location-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const locationAddress = this.getAttribute('data-location');
                    locationDetails.textContent = `Location: ${locationAddress}`;
                    locationMapModal.style.display = 'block';
                    
                    // Initialize map after modal is displayed
                    setTimeout(function() {
                        initializeMap(locationAddress);
                    }, 100);
                });
            });
            
            // Initialize map with the given address
            function initializeMap(address) {
                // If map already exists, destroy it
                if (map) {
                    map.remove();
                }
                
                // Create a new map
                map = L.map('locationMap').setView([6.9214, 122.0790], 13); // Default to Zamboanga City
                
                // Add OpenStreetMap tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                
                // Geocode the address to get coordinates
                geocodeAddress(address, map);
            }
            
            // Geocode address to coordinates
            function geocodeAddress(address, map) {
                fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address)}&format=json&limit=1`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            const result = data[0];
                            const lat = parseFloat(result.lat);
                            const lon = parseFloat(result.lon);
                            
                            // Update map view
                            map.setView([lat, lon], 16);
                            
                            // Add marker for the location
                            const marker = L.marker([lat, lon]).addTo(map);
                            marker.bindPopup(`<b>Location:</b><br>${address}`).openPopup();
                            
                            // Add a circle to represent approximate area
                            L.circle([lat, lon], {
                                color: '#517a5b',
                                fillColor: '#517a5b',
                                fillOpacity: 0.2,
                                radius: 500 // 500 meters
                            }).addTo(map);
                            
                            // Update location details
                            locationDetails.innerHTML = `<strong>Location:</strong> ${address}<br>
                                                       <strong>Coordinates:</strong> ${lat.toFixed(6)}, ${lon.toFixed(6)}`;
                        } else {
                            locationDetails.textContent = `Could not find coordinates for: ${address}`;
                        }
                    })
                    .catch(error => {
                        console.error('Error geocoding address:', error);
                        locationDetails.textContent = `Error finding location: ${error.message}`;
                    });
            }
        });
    </script>

    <!-- Include Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endsection