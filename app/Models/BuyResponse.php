<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'buy_id',
        'seller_id',
        'message',
        'contact_method',
        'contact_email',
        'contact_phone',
        'status' // pending, read, replied, etc.
    ];

    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
