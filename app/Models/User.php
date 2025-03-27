<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Post;
use App\Models\Order;

class User extends Authenticatable 
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'birthday',
        'password',
        'profile_picture',
        'bio',
        'phone_number',
        'address',
        'status',
        'location',
        'number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get orders where user is the seller
     */
    public function soldOrders()
    {
        return $this->hasManyThrough(
            Order::class,
            Post::class,
            'user_id', // Foreign key on posts table...
            'post_id', // Foreign key on orders table...
            'id', // Local key on users table...
            'id' // Local key on posts table...
        );
    }

    /**
     * Get orders where user is the buyer
     * Updated to work with the actual database structure
     */
    public function boughtOrders()
    {
        // If orders table doesn't have user_id, we need to use a different column
        // Assuming orders might have buyer_id instead
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites');
    }

    /**
     * Get the shop associated with the user.
     */
    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    /**
     * Get all orders for the user (both buying and selling)
     * Fixed to not use non-existent column
     */
    public function orders()
    {
        // Use only soldOrders since there's no direct user_id in orders table
        return $this->soldOrders();
    }
}
