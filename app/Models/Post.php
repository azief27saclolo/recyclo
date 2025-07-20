<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'category_id',
        'location',
        'address', 
        'unit',
        'price',
        'original_price',
        'discount_percentage',
        'is_deal',
        'is_featured_deal',
        'deal_expires_at',
        'views_count',
        'orders_count',
        'deal_score',
        'description',
        'image',
        'quantity',
        'status', // Add status field
        'admin_remarks', // Add field for admin feedback
    ];

    // Add status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Default attribute values
    protected $attributes = [
        'status' => self::STATUS_PENDING, // Default status is pending
        'quantity' => 1,
    ];

    // Cast quantity to integer
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'deal_score' => 'decimal:2',
        'is_deal' => 'boolean',
        'is_featured_deal' => 'boolean',
        'deal_expires_at' => 'datetime',
        'views_count' => 'integer',
        'orders_count' => 'integer',
    ];

    public function user() : BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'post_id');
    }

    // Add relationships for favorites
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'post_id', 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'post_id');
    }
    
    // Helper method to get the seller name
    public function getSellerNameAttribute()
    {
        return $this->user ? $this->user->name : 'Unknown Seller';
    }

    /**
     * Get the category that owns the post.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the category name attribute.
     * 
     * This maintains backwards compatibility with code that uses $post->category
     * and ensures we always return a category name if one exists.
     */
    public function getCategoryNameAttribute()
    {
        // If we have a category relationship loaded, use that
        if ($this->relationLoaded('category') && $this->category) {
            return $this->category->name;
        }
        
        // If we have a category_id but no loaded relationship, try to get the name
        if ($this->category_id) {
            try {
                return Category::find($this->category_id)?->name;
            } catch (\Exception $e) {
                \Log::error('Error fetching category name', [
                    'post_id' => $this->id,
                    'category_id' => $this->category_id,
                    'error' => $e->getMessage()
                ]);
        }
        }
        
        // Fall back to the legacy category field
        return $this->attributes['category'] ?? null;
    }

    /**
     * Get the category attribute.
     * 
     * This ensures that $post->category always returns the category name,
     * whether it comes from the relationship or the legacy field.
     */
    public function getCategoryAttribute($value)
    {
        // If we're accessing the raw attribute, return it
        if (isset($this->attributes['category'])) {
            return $this->attributes['category'];
        }

        // If we have a category relationship loaded, use that
        if ($this->relationLoaded('category') && $this->category) {
            return $this->category->name;
        }
        
        // If we have a category_id but no loaded relationship, try to get the name
        if ($this->category_id) {
            try {
                return Category::find($this->category_id)?->name;
            } catch (\Exception $e) {
                \Log::error('Error fetching category name', [
                    'post_id' => $this->id,
                    'category_id' => $this->category_id,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return null;
    }

    /**
     * Check if post is approved
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if post is pending approval
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if post is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Update the quantity and sync with product stock
     */
    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->save();

        // Sync with product if exists
        if ($this->product) {
            $this->product->update(['stock' => $quantity]);
        }

        return $this;
    }

    /**
     * Decrease quantity and sync with product stock
     */
    public function decreaseQuantity($amount = 1)
    {
        if ($this->quantity >= $amount) {
            $this->quantity -= $amount;
            $this->save();

            // Sync with product if exists
            if ($this->product) {
                $this->product->update(['stock' => $this->quantity]);
            }

            return true;
        }

        return false;
    }

    /**
     * Increase quantity and sync with product stock
     */
    public function increaseQuantity($amount = 1)
    {
        $this->quantity += $amount;
        $this->save();

        // Sync with product if exists
        if ($this->product) {
            $this->product->update(['stock' => $this->quantity]);
        }

        return $this;
    }

    /**
     * Calculate and update deal score based on various factors
     */
    public function calculateDealScore()
    {
        $score = 0;
        
        // Discount percentage weight (40%)
        $score += $this->discount_percentage * 0.4;
        
        // Views count weight (20%) - normalize by dividing by 100
        $score += ($this->views_count / 100) * 0.2;
        
        // Orders count weight (30%) - normalize by multiplying by 10
        $score += $this->orders_count * 10 * 0.3;
        
        // Recency bonus (10%) - newer posts get higher score
        $daysOld = $this->created_at->diffInDays(now());
        $recencyScore = max(0, 30 - $daysOld) / 30 * 10; // Max 10 points for posts less than 30 days old
        $score += $recencyScore * 0.1;
        
        $this->update(['deal_score' => round($score, 2)]);
        
        return $score;
    }

    /**
     * Auto-detect if this post qualifies as a deal
     */
    public function autoDetectDeal()
    {
        if (!$this->original_price || $this->original_price <= 0) {
            return false;
        }

        $discountPercentage = (($this->original_price - $this->price) / $this->original_price) * 100;
        
        if ($discountPercentage >= 15) { // 15% or more discount qualifies as a deal
            $this->update([
                'discount_percentage' => round($discountPercentage, 2),
                'is_deal' => true
            ]);
            
            $this->calculateDealScore();
            return true;
        }

        return false;
    }

    /**
     * Check if deal is expired
     */
    public function isDealExpired()
    {
        return $this->deal_expires_at && $this->deal_expires_at->isPast();
    }

    /**
     * Get formatted discount percentage
     */
    public function getFormattedDiscountAttribute()
    {
        return $this->discount_percentage > 0 ? number_format($this->discount_percentage, 0) . '% OFF' : '';
    }

    /**
     * Get savings amount
     */
    public function getSavingsAmountAttribute()
    {
        if (!$this->original_price || $this->original_price <= 0) {
            return 0;
        }
        
        return $this->original_price - $this->price;
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
        
        // Recalculate deal score after view increment
        if ($this->is_deal) {
            $this->calculateDealScore();
        }
    }

    /**
     * Increment orders count
     */
    public function incrementOrders()
    {
        $this->increment('orders_count');
        
        // Auto-promote to deal and featured deal when reaching 3 orders
        if ($this->orders_count >= 3) {
            $updates = [];
            
            // Set as deal if not already
            if (!$this->is_deal) {
                $updates['is_deal'] = true;
            }
            
            // Set as featured deal if not already
            if (!$this->is_featured_deal) {
                $updates['is_featured_deal'] = true;
            }
            
            // Apply updates if any
            if (!empty($updates)) {
                $this->update($updates);
                
                // Log the auto-promotion for tracking
                \Log::info('Auto-promoted post', [
                    'post_id' => $this->id,
                    'title' => $this->title,
                    'orders_count' => $this->orders_count,
                    'updates' => $updates,
                    'deal_score' => $this->deal_score
                ]);
            }
        }
        
        // Recalculate deal score after order increment
        if ($this->is_deal) {
            $this->calculateDealScore();
        }
    }

    /**
     * Scope for getting deals
     */
    public function scopeDeals($query)
    {
        return $query->where('is_deal', true)
                    ->where(function($q) {
                        $q->whereNull('deal_expires_at')
                          ->orWhere('deal_expires_at', '>', now());
                    });
    }

    /**
     * Scope for getting featured deals
     */
    public function scopeFeaturedDeals($query)
    {
        return $query->deals()->where('is_featured_deal', true);
    }

    /**
     * Scope for getting best deals (ordered by deal score)
     */
    public function scopeBestDeals($query)
    {
        return $query->deals()
                    ->where('status', 'approved')
                    ->where('quantity', '>', 0)
                    ->orderBy('deal_score', 'desc')
                    ->orderBy('discount_percentage', 'desc');
    }
}
