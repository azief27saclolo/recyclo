<div class="seller-profile" style="display: flex; gap: 20px; margin-bottom: 30px;">
    <div style="flex: 1;">
        <h3 style="color: #517A5B; margin-top: 0;">{{ $seller->shop ? $seller->shop->shop_name : 'No Shop Name' }}</h3>
        <div class="info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div class="info-item" style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <div class="info-label" style="color: #666; font-size: 14px;">Seller ID</div>
                <div class="info-value" style="font-weight: 500;">#{{ $seller->id }}</div>
            </div>
            <div class="info-item" style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <div class="info-label" style="color: #666; font-size: 14px;">Owner Name</div>
                <div class="info-value" style="font-weight: 500;">{{ $seller->firstname }} {{ $seller->lastname }}</div>
            </div>
            <div class="info-item" style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <div class="info-label" style="color: #666; font-size: 14px;">Email</div>
                <div class="info-value">
                    <i class="bi bi-envelope" style="color: #517A5B;"></i>
                    <span>{{ $seller->email }}</span>
                </div>
            </div>
            <div class="info-item" style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <div class="info-label" style="color: #666; font-size: 14px;">Contact Number</div>
                <div class="info-value">
                    <i class="bi bi-telephone" style="color: #517A5B;"></i>
                    <span>{{ $seller->number ?? 'Not provided' }}</span>
                </div>
            </div>
            <div class="info-item" style="background: #f8f9fa; padding: 15px; border-radius: 8px; grid-column: 1 / -1;">
                <div class="info-label" style="color: #666; font-size: 14px;">Location</div>
                <div class="info-value">
                    <i class="bi bi-geo-alt" style="color: #517A5B;"></i>
                    <span>{{ $seller->location ?? ($seller->shop ? $seller->shop->shop_address : 'Not provided') }}</span>
                </div>
            </div>
            <div class="info-item" style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <div class="info-label" style="color: #666; font-size: 14px;">Total Sales</div>
                <div class="info-value" style="color: #517A5B; font-weight: 600;">₱{{ number_format($seller->total_sales, 2) }}</div>
            </div>
            <div class="info-item" style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <div class="info-label" style="color: #666; font-size: 14px;">Total Products</div>
                <div class="info-value">{{ $seller->posts_count }}</div>
            </div>
            <div class="info-item" style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <div class="info-label" style="color: #666; font-size: 14px;">Shop Status</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $seller->shop ? $seller->shop->status : 'pending' }}" style="padding: 4px 10px; border-radius: 20px; font-size: 0.85rem;">
                        {{ ucfirst($seller->shop ? $seller->shop->status : 'pending') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products Section -->
<h3 style="color: #517A5B; margin: 20px 0;">Products ({{ count($products) }})</h3>
<div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
    @forelse($products as $product)
        <div class="product-card" style="background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
            @else
                <div style="width: 100%; height: 150px; background-color: #eee; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                    <i class="bi bi-image" style="font-size: 2rem; color: #aaa;"></i>
                </div>
            @endif
            <h4 style="margin: 10px 0;">{{ $product->title }}</h4>
            <p style="color: #517A5B; margin: 5px 0;">₱{{ number_format($product->price, 2) }} / {{ $product->unit }}</p>
            <p style="font-size: 0.9rem; color: #666; margin: 5px 0;">Orders: {{ $product->orders_count }}</p>
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
            No products found for this seller.
        </div>
    @endforelse
</div>

<!-- Transactions Section -->
<h3 style="color: #517A5B; margin: 20px 0;">Transaction History ({{ count($transactions) }})</h3>
<div class="table-responsive">
    <table class="table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="background: #f8f9fa; padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; font-weight: 600;">Transaction ID</th>
                <th style="background: #f8f9fa; padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; font-weight: 600;">Date</th>
                <th style="background: #f8f9fa; padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; font-weight: 600;">Buyer</th>
                <th style="background: #f8f9fa; padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; font-weight: 600;">Product</th>
                <th style="background: #f8f9fa; padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; font-weight: 600;">Quantity</th>
                <th style="background: #f8f9fa; padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; font-weight: 600;">Amount</th>
                <th style="background: #f8f9fa; padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; font-weight: 600;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $tx)
                <tr>
                    <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">#{{ $tx->id }}</td>
                    <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">{{ $tx->created_at->format('M d, Y') }}</td>
                    <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">
                        @if($tx->buyer)
                            {{ $tx->buyer->firstname }} {{ $tx->buyer->lastname }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">
                        @if($tx->post)
                            {{ $tx->post->title }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">{{ $tx->quantity }} {{ $tx->post->unit ?? '' }}</td>
                    <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">₱{{ number_format($tx->total_amount, 2) }}</td>
                    <td style="padding: 12px 15px; border-bottom: 1px solid #eee;">
                        <span class="status-badge status-{{ $tx->status }}" style="padding: 4px 10px; border-radius: 20px; font-size: 0.85rem;">
                            {{ ucfirst($tx->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 20px; text-align: center;">No transactions found for this seller.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
