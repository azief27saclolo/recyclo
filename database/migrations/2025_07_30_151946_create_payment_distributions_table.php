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
        Schema::create('payment_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Payment amounts
            $table->decimal('order_amount', 10, 2); // Original order amount
            $table->decimal('platform_fee', 10, 2)->default(0); // Commission taken
            $table->decimal('seller_amount', 10, 2); // Amount to be paid to seller
            $table->decimal('amount_paid', 10, 2)->default(0); // Actually paid amount
            
            // Payment details
            $table->enum('payment_method', ['gcash', 'bank_transfer', 'cash', 'check'])->default('gcash');
            $table->string('reference_number')->nullable(); // GCash reference or bank ref
            $table->string('recipient_contact')->nullable(); // Seller's GCash/bank details
            
            // Status tracking
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            
            // Proof documentation
            $table->string('payment_proof')->nullable(); // Screenshot of payment sent
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('scheduled_at')->nullable(); // For batch payments
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['seller_id', 'status']);
            $table->index(['admin_id', 'paid_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_distributions');
    }
};
