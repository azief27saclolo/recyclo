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
        // Skip if orders table doesn't exist
        if (!Schema::hasTable('orders')) {
            return;
        }
        
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'quantity')) {
                $table->string('quantity')->after('post_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Skip if orders table doesn't exist
        if (!Schema::hasTable('orders')) {
            return;
        }
        
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });
    }
};