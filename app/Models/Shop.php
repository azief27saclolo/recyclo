<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_name', 
        'shop_address',
        'valid_id_path',
        'status', // pending, approved, rejected
        'remarks'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
