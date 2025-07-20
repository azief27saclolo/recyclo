<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('delivery_method_id')->constrained('delivery_methods');
            
            // Common fields
            $table->string('status')->default('pending'); // pending, confirmed, in_transit, delivered, completed
            $table->decimal('delivery_fee', 8, 2)->default(0);
            $table->text('delivery_notes')->nullable();
            
            // Delivery-specific fields
            $table->text('delivery_address')->nullable();
            $table->datetime('estimated_delivery_time')->nullable();
            
            // Pickup-specific fields
            $table->date('pickup_date')->nullable();
            $table->string('pickup_time_slot')->nullable(); // e.g., "09:00-12:00", "14:00-17:00"
            $table->text('pickup_notes')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['order_id', 'delivery_method_id']);
            $table->index('status');
            $table->index('pickup_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_details');
    }
};
