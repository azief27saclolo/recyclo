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
        Schema::create('delivery_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 'delivery', 'pickup'
            $table->string('display_name'); // 'Home Delivery', 'Store Pickup'
            $table->text('description')->nullable();
            $table->decimal('base_fee', 8, 2)->default(0); // Base fee for this delivery method
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Insert default delivery methods
        DB::table('delivery_methods')->insert([
            [
                'name' => 'delivery',
                'display_name' => 'Home Delivery',
                'description' => 'Items will be delivered to your specified address',
                'base_fee' => 35.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pickup',
                'display_name' => 'Store Pickup',
                'description' => 'Pick up items directly from the seller location',
                'base_fee' => 0.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_methods');
    }
};
