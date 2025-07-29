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
        // Add default delivery details for existing orders that don't have them
        $ordersWithoutDeliveryDetails = DB::table('orders')
            ->leftJoin('delivery_details', 'orders.id', '=', 'delivery_details.order_id')
            ->whereNull('delivery_details.id')
            ->select('orders.*')
            ->get();

        foreach ($ordersWithoutDeliveryDetails as $order) {
            // Create default delivery detail (assume home delivery)
            DB::table('delivery_details')->insert([
                'order_id' => $order->id,
                'delivery_method_id' => 1, // Home delivery
                'status' => 'pending',
                'delivery_fee' => 35.00,
                'delivery_address' => 'Legacy order - address not specified',
                'estimated_delivery_time' => now()->addDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove delivery details that were added for legacy orders
        DB::table('delivery_details')
            ->where('delivery_address', 'Legacy order - address not specified')
            ->delete();
    }
};
