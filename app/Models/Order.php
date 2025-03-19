<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'buyer_id',  // This should be a foreign key to users.id
        'seller_id', // This should be a foreign key to users.id
        'quantity',
        'total_amount',
        'status',
    ];

    // Relationship with the buyer (User who placed the order)
    public function user()
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