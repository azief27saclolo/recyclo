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
        Schema::table('orders', function (Blueprint $table) {
            // Add pickup-related fields
            $table->date('pickup_date')->nullable()->after('receipt_image');
            $table->string('pickup_time')->nullable()->after('pickup_date');
            $table->text('pickup_notes')->nullable()->after('pickup_time');
            $table->timestamp('pickup_completed_at')->nullable()->after('pickup_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'pickup_date',
                'pickup_time', 
                'pickup_notes',
                'pickup_completed_at'
            ]);
        });
    }
};
