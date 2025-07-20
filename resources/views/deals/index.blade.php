@extends('components.layout')

@section('content')
<div class="container">
    <!-- Hero Section with Featured Deals -->
    @if($featuredDeals->count() > 0)
    <section style="margin-bottom: 40px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 40px; color: white; text-align: center; margin-bottom: 30px;">
            <h1 style="font-size: 48px; margin-bottom: 10px; font-weight: 700;">🔥 Best Deals</h1>
            <p style="font-size: 20px; margin-bottom: 30px; opacity: 0.9;">Incredible savings on recycled materials and sustainable products</p>
            
            <!-- Deal Statistics -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px; margin-top: 30px;">
                <div style="background: rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; backdrop-filter: blur(10px);">
                    <div style="font-size: 28px; font-weight: 700;">{{ number_format($stats['total_deals']) }}</div>
                    <div style="font-size: 14px; opacity: 0.8;">Active Deals</div>
                </div>
                <div style="background: rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; backdrop-filter: blur(10px);">
                    <div style="font-size: 28px; font-weight: 700;">{{ number_format($stats['avg_discount'] ?? 0, 0) }}%</div>
                    <div style="font-size: 14px; opacity: 0.8;">Avg Discount</div>
                </div>
                <div style="background: rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; backdrop-filter: blur(10px);">
                    <div style="font-size: 28px; font-weight: 700;">{{ number_format($stats['max_discount'] ?? 0, 0) }}%</div>
                    <div style="font-size: 14px; opacity: 0.8;">Max Discount</div>
                </div>
                <div style="background: rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; backdrop-filter: blur(10px);">
                    <div style="font-size: 28px; font-weight: 700;">₱{{ number_format($stats['total_savings'] ?? 0) }}</div>
                    <div style="font-size: 14px; opacity: 0.8;">Total Savings</div>
                </div>
            </div>
        </div>
        
        <!-- Featured Deals Carousel -->
        <div style="margin-bottom: 40px;">
            <h2 style="font-size: 32px; margin-bottom: 20px; text-align: center; color: #333;">⭐ Featured Deals</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px;">
                @foreach($featuredDeals as $deal)
                <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: all 0.3s ease; position: relative; border: 2px solid #ffd700;">
                    <!-- Featured Badge -->
                    <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(45deg, #ffd700, #ffed4e); color: #333; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.2);"
                         title="Featured Deal{{ $deal->orders_count >= 3 ? ' (Auto-promoted for popularity!)' : '' }}">
                        ⭐ FEATURED{{ $deal->orders_count >= 3 ? ' 🔥' : '' }}
                    </div>
                    
                    <!-- Discount Badge -->
                    @if($deal->discount_percentage > 0)
                    <div style="position: absolute; top: 15px; right: 15px; background: linear-gradient(45deg, #ff416c, #ff4b2b); color: white; padding: 8px 12px; border-radius: 20px; font-size: 14px; font-weight: 700; z-index: 10; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                        {{ number_format($deal->discount_percentage, 0) }}% OFF
                    </div>
                    @endif
                    
                    <!-- Product Image -->
                    <div style="position: relative; height: 220px; overflow: hidden;">
                        <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $deal->title }}" 
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                             onmouseover="this.style.transform='scale(1.05)'" 
                             onmouseout="this.style.transform='scale(1)'">
                        
                        <!-- Deal Score -->
                        <div style="position: absolute; bottom: 15px; left: 15px; background: rgba(0,0,0,0.8); color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                            🔥 Deal Score: {{ number_format($deal->deal_score, 1) }}
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div style="padding: 20px;">
                        <h3 style="font-size: 18px; margin-bottom: 8px; color: #333; font-weight: 600; line-height: 1.3;">
                            {{ Str::limit($deal->title, 50) }}
                        </h3>
                        
                        <!-- Seller Info -->
                        <div style="display: flex; align-items: center; margin-bottom: 12px;">
                            <i class="bi bi-shop" style="color: #517a5b; margin-right: 6px;"></i>
                            <span style="color: #666; font-size: 14px;">{{ $deal->user->username ?? 'Unknown' }}</span>
                        </div>
                        
                        <!-- Location -->
                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                            <i class="bi bi-geo-alt" style="color: #666; margin-right: 6px;"></i>
                            <span style="color: #666; font-size: 14px;">{{ $deal->location }}</span>
                        </div>
                        
                        <!-- Pricing -->
                        <div style="margin-bottom: 15px;">
                            @if($deal->original_price && $deal->original_price > $deal->price)
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 24px; font-weight: 700; color: #517a5b;">₱{{ number_format($deal->price, 2) }}</span>
                                <span style="font-size: 16px; color: #999; text-decoration: line-through;">₱{{ number_format($deal->original_price, 2) }}</span>
                            </div>
                            <div style="color: #28a745; font-size: 14px; font-weight: 600; margin-top: 4px;">
                                You save: ₱{{ number_format($deal->savings_amount, 2) }}
                            </div>
                            @else
                            <span style="font-size: 24px; font-weight: 700; color: #517a5b;">₱{{ number_format($deal->price, 2) }}</span>
                            @endif
                            <span style="color: #666; font-size: 14px; margin-left: 8px;">per {{ $deal->unit ?? 'item' }}</span>
                        </div>
                        
                        <!-- Stock Info -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <span style="color: #666; font-size: 14px;">
                                <i class="bi bi-box" style="margin-right: 4px;"></i>
                                {{ $deal->quantity }} available
                            </span>
                            <span style="color: #666; font-size: 14px;">
                                <i class="bi bi-eye" style="margin-right: 4px;"></i>
                                {{ $deal->views_count }} views
                            </span>
                        </div>
                        
                        <!-- Action Button -->
                        <a href="{{ route('posts.show', $deal->id) }}" 
                           style="display: block; text-align: center; background: linear-gradient(45deg, #517a5b, #6ea76f); color: white; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(81, 122, 91, 0.3);"
                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(81, 122, 91, 0.4)'"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(81, 122, 91, 0.3)'">
                            View Deal Details
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- Filters Section -->
    <section style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <form method="GET" action="{{ route('deals.index') }}">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: end; margin-bottom: 20px;">
                <!-- Category Filter -->
                <div style="flex: 1; min-width: 150px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600; font-size: 14px;">Category</label>
                    <select name="category" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Location Filter -->
                <div style="flex: 1; min-width: 150px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600; font-size: 14px;">Location</label>
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Enter location" 
                           style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                </div>
                
                <!-- Minimum Discount Filter -->
                <div style="flex: 0 0 120px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600; font-size: 14px;">Min Discount %</label>
                    <input type="number" name="min_discount" value="{{ request('min_discount') }}" placeholder="e.g. 20" min="0" max="100" 
                           style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                </div>
                
                <!-- Max Price Filter -->
                <div style="flex: 0 0 120px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600; font-size: 14px;">Max Price</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="₱1000" min="0" 
                           style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                </div>
                
                <!-- Action Buttons -->
                <div style="display: flex; gap: 10px; align-items: center;">
                    <button type="submit" style="background: #517a5b; color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.3s ease; white-space: nowrap;">
                        Apply Filters
                    </button>
                    <a href="{{ route('deals.index') }}" style="color: #666; text-decoration: none; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 8px; transition: all 0.3s ease; white-space: nowrap;">
                        Clear All
                    </a>
                </div>
            </div>
        </form>
    </section>
    
    <!-- Sorting and Results Count -->
    <section style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div style="color: #666; font-size: 16px;">
            Showing {{ $deals->firstItem() ?? 0 }} - {{ $deals->lastItem() ?? 0 }} of {{ $deals->total() }} deals
        </div>
        
        <div style="display: flex; gap: 15px; align-items: center;">
            <label style="color: #333; font-weight: 600;">Sort by:</label>
            <form method="GET" style="display: inline;">
                @foreach(request()->except('sort') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                
                <select name="sort" onchange="this.form.submit()" style="padding: 8px 12px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 14px;">
                    <option value="deal_score" {{ request('sort') == 'deal_score' ? 'selected' : '' }}>Best Deal Score</option>
                    <option value="discount" {{ request('sort') == 'discount' ? 'selected' : '' }}>Highest Discount</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>Ending Soon</option>
                </select>
            </form>
        </div>
    </section>
    
    <!-- Deals Grid -->
    <section>
        @if($deals->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; margin-bottom: 40px;">
            @foreach($deals as $deal)
            <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; position: relative; border: 1px solid #f0f0f0;"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.15)'"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.1)'">
                
                <!-- Deal Badges -->
                @if($deal->is_featured_deal)
                <div style="position: absolute; top: 12px; left: 12px; background: linear-gradient(45deg, #ffd700, #ffed4e); color: #333; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 700; z-index: 10;" 
                     title="Featured Deal{{ $deal->orders_count >= 3 ? ' (Auto-promoted for popularity!)' : '' }}">
                    ⭐ FEATURED{{ $deal->orders_count >= 3 ? ' 🔥' : '' }}
                </div>
                @endif
                
                @if($deal->discount_percentage > 0)
                <div style="position: absolute; top: 12px; right: 12px; background: linear-gradient(45deg, #ff416c, #ff4b2b); color: white; padding: 6px 10px; border-radius: 12px; font-size: 12px; font-weight: 700; z-index: 10;">
                    {{ number_format($deal->discount_percentage, 0) }}% OFF
                </div>
                @endif
                
                <!-- Product Image -->
                <div style="position: relative; height: 200px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $deal->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                    
                    <!-- Deal Score Badge -->
                    <div style="position: absolute; bottom: 10px; left: 10px; background: rgba(0,0,0,0.7); color: white; padding: 4px 8px; border-radius: 10px; font-size: 11px; font-weight: 600;">
                        🔥 {{ number_format($deal->deal_score, 1) }}
                    </div>
                </div>
                
                <!-- Content -->
                <div style="padding: 18px;">
                    <h3 style="font-size: 16px; margin-bottom: 8px; color: #333; font-weight: 600; line-height: 1.3;">
                        {{ Str::limit($deal->title, 45) }}
                    </h3>
                    
                    <!-- Seller and Location -->
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <div style="display: flex; align-items: center;">
                            <i class="bi bi-shop" style="color: #517a5b; margin-right: 4px; font-size: 12px;"></i>
                            <span style="color: #666; font-size: 12px;">{{ Str::limit($deal->user->username ?? 'Unknown', 15) }}</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="bi bi-geo-alt" style="color: #666; margin-right: 4px; font-size: 12px;"></i>
                            <span style="color: #666; font-size: 12px;">{{ Str::limit($deal->location, 15) }}</span>
                        </div>
                    </div>
                    
                    <!-- Pricing -->
                    <div style="margin-bottom: 12px;">
                        @if($deal->original_price && $deal->original_price > $deal->price)
                        <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 4px;">
                            <span style="font-size: 20px; font-weight: 700; color: #517a5b;">₱{{ number_format($deal->price, 2) }}</span>
                            <span style="font-size: 14px; color: #999; text-decoration: line-through;">₱{{ number_format($deal->original_price, 2) }}</span>
                        </div>
                        <div style="color: #28a745; font-size: 12px; font-weight: 600;">
                            Save ₱{{ number_format($deal->savings_amount, 2) }}
                        </div>
                        @else
                        <span style="font-size: 20px; font-weight: 700; color: #517a5b;">₱{{ number_format($deal->price, 2) }}</span>
                        @endif
                        <span style="color: #666; font-size: 12px; margin-left: 4px;">per {{ $deal->unit ?? 'item' }}</span>
                    </div>
                    
                    <!-- Stats -->
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; color: #666; font-size: 12px;">
                        <span><i class="bi bi-box" style="margin-right: 3px;"></i>{{ $deal->quantity }} left</span>
                        <span><i class="bi bi-eye" style="margin-right: 3px;"></i>{{ $deal->views_count }}</span>
                        <span><i class="bi bi-cart" style="margin-right: 3px;"></i>{{ $deal->orders_count }}</span>
                    </div>
                    
                    <!-- Action Button -->
                    <a href="{{ route('posts.show', $deal->id) }}" 
                       style="display: block; text-align: center; background: linear-gradient(45deg, #517a5b, #6ea76f); color: white; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s ease;">
                        View Deal
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div style="display: flex; justify-content: center; margin-top: 40px;">
            {{ $deals->links() }}
        </div>
        @else
        <!-- No Deals Found -->
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.3;">🔍</div>
            <h3 style="font-size: 24px; margin-bottom: 10px; color: #333;">No Deals Found</h3>
            <p style="color: #666; margin-bottom: 20px;">Try adjusting your filters or check back later for new deals.</p>
            <a href="{{ route('deals.index') }}" style="display: inline-block; background: #517a5b; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                View All Deals
            </a>
        </div>
        @endif
    </section>
</div>

<style>
    /* Custom pagination styling */
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .pagination li {
        margin: 0 3px;
    }
    
    .pagination a, .pagination span {
        display: block;
        padding: 10px 15px;
        color: #517a5b;
        text-decoration: none;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .pagination a:hover {
        background: #517a5b;
        color: white;
        border-color: #517a5b;
    }
    
    .pagination .active span {
        background: #517a5b;
        color: white;
        border-color: #517a5b;
    }
    
    .pagination .disabled span {
        color: #ccc;
        cursor: not-allowed;
    }
</style>
@endsection
