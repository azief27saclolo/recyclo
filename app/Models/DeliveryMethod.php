<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'base_fee',
        'is_active',
    ];

    protected $casts = [
        'base_fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get all delivery details using this method
     */
    public function deliveryDetails()
    {
        return $this->hasMany(DeliveryDetail::class);
    }

    /**
     * Scope to get only active delivery methods
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if this is a pickup method
     */
    public function isPickup()
    {
        return $this->name === 'pickup';
    }

    /**
     * Check if this is a delivery method
     */
    public function isDelivery()
    {
        return $this->name === 'delivery';
    }
}
