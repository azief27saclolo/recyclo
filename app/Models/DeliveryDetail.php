<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'delivery_method_id',
        'status',
        'delivery_fee',
        'delivery_notes',
        
        // Delivery-specific fields
        'delivery_address',
        'estimated_delivery_time',
        
        // Pickup-specific fields
        'pickup_date',
        'pickup_time_slot',
        'pickup_notes',
    ];

    protected $casts = [
        'delivery_fee' => 'decimal:2',
        'estimated_delivery_time' => 'datetime',
        'pickup_date' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function deliveryMethod()
    {
        return $this->belongsTo(DeliveryMethod::class);
    }

    public function isPickup()
    {
        return $this->deliveryMethod->isPickup();
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePickup($query)
    {
        return $query->whereHas('deliveryMethod', function($q) {
            $q->where('name', 'pickup');
        });
    }
}
