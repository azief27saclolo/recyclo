<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Skip if orders table doesn't exist
        if (!Schema::hasTable('orders')) {
            return;
        }
        
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'receipt_image')) {
                // Add receipt_image column for storing payment receipts
                $table->string('receipt_image')->nullable()->after('total_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('orders')) {
            return;
        }
        
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'receipt_image')) {
                $table->dropColumn('receipt_image');
            }
        });
    }
};
