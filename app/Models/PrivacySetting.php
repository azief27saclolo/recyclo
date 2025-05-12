<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'public_profile',
        'show_email',
        'show_location',
        'email_notifications',
        'order_notifications',
    ];

    protected $casts = [
        'public_profile' => 'boolean',
        'show_email' => 'boolean',
        'show_location' => 'boolean',
        'email_notifications' => 'boolean',
        'order_notifications' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 