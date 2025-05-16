<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'quantity',
        'total_amount',
        'status',
        'cancellation_reason',
        'receipt_image',
        'buyer_id',
        'seller_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the standardized status value.
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        // Return the actual status without modifying it
        // This allows the admin to set any valid status including 'pending', 'approved', etc.
        return $value;
    }

    // Relationship with the buyer (User who placed the order)
    public function user()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    
    // Add explicit buyer relationship
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // Relationship with the seller (User who owns the post)
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Relationship with the post being ordered
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the order items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}