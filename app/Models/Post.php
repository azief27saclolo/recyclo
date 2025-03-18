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
        'location',
        'unit',
        'price',
        'description',
        'image',
        'quantity',
    ];

    public function user() : BelongsTo 
    {
        return $this->belongsTo(User::class);
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
}
