<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'seller_id', 'admin_id', 'order_amount', 
        'platform_fee', 'seller_amount', 'amount_paid',
        'payment_method', 'reference_number', 'recipient_contact',
        'status', 'notes', 'payment_proof', 'paid_at', 'scheduled_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'order_amount' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'seller_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Helper methods
    public function markAsPaid($adminId, $referenceNumber = null, $proofImage = null, $notes = null)
    {
        $this->update([
            'status' => 'completed',
            'admin_id' => $adminId,
            'reference_number' => $referenceNumber,
            'payment_proof' => $proofImage,
            'notes' => $notes,
            'paid_at' => now(),
            'amount_paid' => $this->seller_amount
        ]);
    }

    public function calculatePlatformFee($percentage = 5)
    {
        $fee = ($this->order_amount * $percentage) / 100;
        $this->platform_fee = $fee;
        $this->seller_amount = $this->order_amount - $fee;
        $this->save();
        return $this;
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'processing' => 'bg-info',
            'completed' => 'bg-success',
            'failed' => 'bg-danger',
            'cancelled' => 'bg-secondary',
            default => 'bg-secondary'
        };
    }
}
