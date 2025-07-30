<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Since status is a string column, we don't need to alter the column structure
        // The 'paid' status can be used directly as a string value
        // This migration serves as documentation that 'paid' is now a valid status
        
        // Update any existing orders with completed payment distributions to 'paid' status
        DB::statement("
            UPDATE orders 
            SET status = 'paid' 
            WHERE id IN (
                SELECT order_id 
                FROM payment_distributions 
                WHERE status = 'completed'
            )
            AND status = 'delivered'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert any 'paid' status orders back to 'delivered'
        DB::statement("UPDATE orders SET status = 'delivered' WHERE status = 'paid'");
    }
};
