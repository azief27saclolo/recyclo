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
        // Skip this migration if the orders table doesn't exist yet
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'status')) {
                if (Schema::hasColumn('orders', 'quantity')) {
                    $table->string('status')->default('pending')->after('quantity');
                } else {
                    $table->string('status')->default('pending');
                }
            }
            
            if (!Schema::hasColumn('orders', 'total_amount')) {
                if (Schema::hasColumn('orders', 'status')) {
                    $table->decimal('total_amount', 10, 2)->nullable()->after('status');
                } else {
                    $table->decimal('total_amount', 10, 2)->nullable();
                }
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
        // Only run if the table exists
        if (!Schema::hasTable('orders')) {
            return;
        }
        
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'status')) {
                $table->dropColumn('status');
            }
            
            if (Schema::hasColumn('orders', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
        });
    }
};
