<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'buy_id',
        'user_id',
        'message',
        'contact_info',
        'read'
    ];

    /**
     * Get the buy request that this response belongs to
     */
    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }

    /**
     * Get the user who sent this response
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
