<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
        'user_id',
        'is_active',
        'post_id'
    ];

    // Cast stock to integer
    protected $casts = [
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post associated with the product.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Update the stock and sync with post quantity
     */
    public function updateStock($stock)
    {
        $this->stock = $stock;
        $this->save();

        // Sync with post if exists
        if ($this->post) {
            $this->post->update(['quantity' => $stock]);
        }

        return $this;
    }

    /**
     * Decrease stock and sync with post quantity
     */
    public function decreaseStock($amount = 1)
    {
        if ($this->stock >= $amount) {
            $this->stock -= $amount;
            $this->save();

            // Sync with post if exists
            if ($this->post) {
                $this->post->update(['quantity' => $this->stock]);
            }

            return true;
        }

        return false;
    }

    /**
     * Increase stock and sync with post quantity
     */
    public function increaseStock($amount = 1)
    {
        $this->stock += $amount;
        $this->save();

        // Sync with post if exists
        if ($this->post) {
            $this->post->update(['quantity' => $this->stock]);
        }

        return $this;
    }
}
