<!-- Transaction Info Section -->
<div class="details-section">
    <h3 class="section-title">
        <i class="bi bi-info-circle"></i> Transaction Information
    </h3>
    <div class="details-grid">
        <div class="detail-item">
            <div class="detail-label">Transaction ID</div>
            <div class="detail-value">
                <i class="bi bi-upc"></i>
                <span>#{{ $transaction->id }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Date</div>
            <div class="detail-value">
                <i class="bi bi-calendar"></i>
                <span>{{ $transaction->created_at->format('M d, Y H:i:s') }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Status</div>
            <div class="detail-value">
                <span class="transaction-status status-badge status-{{ $transaction->status }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Payment Method</div>
            <div class="detail-value">
                <i class="bi bi-credit-card"></i>
                <span>{{ $transaction->payment_method ?? 'Not specified' }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Seller Info Section -->
<div class="details-section">
    <h3 class="section-title">
        <i class="bi bi-shop"></i> Seller Information
    </h3>
    <div class="details-grid">
        <div class="detail-item">
            <div class="detail-label">Shop Name</div>
            <div class="detail-value">
                <i class="bi bi-shop"></i>
                <span>{{ $transaction->seller->shop->shop_name ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Seller ID</div>
            <div class="detail-value">
                <i class="bi bi-person-badge"></i>
                <span>#{{ $transaction->seller->id ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Email</div>
            <div class="detail-value">
                <i class="bi bi-envelope"></i>
                <span>{{ $transaction->seller->email ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Contact</div>
            <div class="detail-value">
                <i class="bi bi-telephone"></i>
                <span>{{ $transaction->seller->number ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="detail-item" style="grid-column: 1 / -1;">
            <div class="detail-label">Location</div>
            <div class="detail-value">
                <i class="bi bi-geo-alt"></i>
                <span>{{ $transaction->seller->location ?? ($transaction->seller->shop->shop_address ?? 'N/A') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Buyer Info Section -->
<div class="details-section">
    <h3 class="section-title">
        <i class="bi bi-person"></i> Buyer Information
    </h3>
    <div class="details-grid">
        <div class="detail-item">
            <div class="detail-label">Name</div>
            <div class="detail-value">
                <i class="bi bi-person"></i>
                <span>
                    @if($transaction->buyer)
                        {{ $transaction->buyer->firstname }} {{ $transaction->buyer->lastname }}
                    @else
                        N/A
                    @endif
                </span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Buyer ID</div>
            <div class="detail-value">
                <i class="bi bi-person-badge"></i>
                <span>#{{ $transaction->buyer->id ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Email</div>
            <div class="detail-value">
                <i class="bi bi-envelope"></i>
                <span>{{ $transaction->buyer->email ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Contact</div>
            <div class="detail-value">
                <i class="bi bi-telephone"></i>
                <span>{{ $transaction->buyer->number ?? 'N/A' }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Product Info Section -->
<div class="details-section">
    <h3 class="section-title">
        <i class="bi bi-box"></i> Product Details
    </h3>
    <div class="details-grid">
        <div class="detail-item">
            <div class="detail-label">Product Name</div>
            <div class="detail-value">
                <i class="bi bi-box"></i>
                <span>{{ $transaction->post->title ?? 'N/A' }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Quantity</div>
            <div class="detail-value">
                <i class="bi bi-plus-slash-minus"></i>
                <span>{{ $transaction->quantity }} {{ $transaction->post->unit ?? '' }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Price per Unit</div>
            <div class="detail-value price-value">
                <i class="bi bi-tag"></i>
                <span>₱{{ $transaction->post ? number_format($transaction->post->price, 2) : 'N/A' }}</span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Total Amount</div>
            <div class="detail-value price-value">
                <i class="bi bi-cash"></i>
                <span>₱{{ number_format($transaction->total_amount, 2) }}</span>
            </div>
        </div>
    </div>
</div>

@if($transaction->receipt_image)
<div class="details-section">
    <h3 class="section-title">
        <i class="bi bi-receipt"></i> Payment Receipt
    </h3>
    <div style="text-align: center;">
        <img src="{{ asset('storage/' . $transaction->receipt_image) }}" alt="Payment Receipt" style="max-width: 100%; max-height: 400px; border: 1px solid #ddd; border-radius: 8px;">
    </div>
</div>
@endif
