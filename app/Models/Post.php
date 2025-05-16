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
}
