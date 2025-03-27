<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'quantity',
        'unit',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
