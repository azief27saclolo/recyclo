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
                            <h3 style="font-size: 24px; margin: 0;">{{ $orders->where('status', 'pending')->count() }}</h3>
                            <p style="margin: 0; color: #666;">Active Orders</p>
                        </div>
                    </div>
                    <div class="stat-card" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; align-items: center;">
                        <ion-icon name="time-outline" style="font-size: 40px; color: #517a5b; margin-right: 15px;"></ion-icon>
                        <div class="stat-info">
                            <h3 style="font-size: 24px; margin: 0;">{{ $orders->where('status', 'processing')->count() }}</h3>
                            <p style="margin: 0; color: #666;">In Transit</p>
                        </div>
                    </div>
                    <div class="stat-card" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; align-items: center;">
                        <ion-icon name="checkmark-circle-outline" style="font-size: 40px; color: #517a5b; margin-right: 15px;"></ion-icon>
                        <div class="stat-info">
                            <h3 style="font-size: 24px; margin: 0;">{{ $orders->where('status', 'completed')->count() }}</h3>
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
                        <span class="badge" style="background: #517a5b; color: white; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; justify-content: center; align-items: center; margin-left: 5px; font-size: 12px;">{{ $orders->where('status', 'processing')->count() }}</span>
                    </button>
                    <button class="tab-btn" data-tab="to-receive" style="background: #f1f1f1; color: #333; border: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; white-space: nowrap; cursor: pointer;">
                        <ion-icon name="cube-outline" style="margin-right: 5px;"></ion-icon>
                        To Receive
                        <span class="badge" style="background: #517a5b; color: white; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; justify-content: center; align-items: center; margin-left: 5px; font-size: 12px;">{{ $orders->where('status', 'to_receive')->count() }}</span>
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
                                    <button class="btn btn-primary" style="background: #517a5b; color: white; border: none; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer;">Track Order</button>
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

                <!-- New Orders Tab Content (renamed to Processing in title only) -->
                <div class="order-cards" id="new-orders" style="display: none; flex-direction: column; gap: 20px;">
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
                                    <button class="btn btn-primary" style="background: #517a5b; color: white; border: none; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer;">Track Order</button>
                                    <button class="btn btn-secondary" style="background: white; border: 1px solid #517a5b; color: #517a5b; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer;">Cancel Order</button>
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

                <!-- To Ship Orders Tab Content (renamed to Delivering) -->
                <div class="order-cards" id="to-ship-orders" style="display: none; flex-direction: column; gap: 20px;">
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
                                        <p style="margin: 10px 0; font-weight: 600; color: #517a5b;">Total: ₱{{ $order->total_amount }}.00</p>
                                    </div>
                                    <div class="order-status" style="margin-top: 10px;">
                                        <span class="status-badge in-transit" style="background: #17a2b8; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">To Ship</span>
                                    </div>
                                </div>
                                <div class="order-footer" style="background: #f8f9fa; padding: 15px; display: flex; gap: 10px;">
                                    <button class="btn btn-primary" style="background: #517a5b; color: white; border: none; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer;">Track Order</button>
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

                <!-- To Receive Orders Tab Content -->
                <div class="order-cards" id="to-receive-orders" style="display: none; flex-direction: column; gap: 20px;">
                    @if($orders->where('status', 'to_receive')->count() > 0)
                        @foreach($orders->where('status', 'to_receive') as $order)
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
                                        <span class="status-badge to-deliver" style="background: #fd7e14; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; display: inline-block;">To Receive</span>
                                    </div>
                                </div>
                                <div class="order-footer" style="background: #f8f9fa; padding: 15px; display: flex; gap: 10px;">
                                    <button class="btn btn-primary" style="background: #517a5b; color: white; border: none; padding: 8px 15px; border-radius: 10px; flex: 1; cursor: pointer;">Track Order</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                            <ion-icon name="cube-outline" style="font-size: 60px; color: #ccc;"></ion-icon>
                            <p style="font-size: 18px; color: #666; margin-top: 10px;">No orders to receive</p>
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
        });
    </script>
@endsection