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
        Schema::table('posts', function (Blueprint $table) {
            $table->decimal('original_price', 10, 2)->nullable()->after('price');
            $table->decimal('discount_percentage', 5, 2)->default(0)->after('original_price');
            $table->boolean('is_deal')->default(false)->after('discount_percentage');
            $table->boolean('is_featured_deal')->default(false)->after('is_deal');
            $table->timestamp('deal_expires_at')->nullable()->after('is_featured_deal');
            $table->integer('views_count')->default(0)->after('deal_expires_at');
            $table->integer('orders_count')->default(0)->after('views_count');
            $table->decimal('deal_score', 8, 2)->default(0)->after('orders_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'original_price',
                'discount_percentage',
                'is_deal',
                'is_featured_deal',
                'deal_expires_at',
                'views_count',
                'orders_count',
                'deal_score'
            ]);
        });
    }
};
