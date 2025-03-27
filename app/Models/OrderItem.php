<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'post_id',
        'quantity',
        'price',
        // Add any other fields your order_items table has
    ];

    /**
     * Get the order that owns the item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the post for this order item.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
