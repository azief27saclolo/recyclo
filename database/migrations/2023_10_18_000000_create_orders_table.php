<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Skip if orders table already exists
        if (Schema::hasTable('orders')) {
            return;
        }
        
        // Create orders table only if posts table exists
        if (Schema::hasTable('posts')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('seller_id')->constrained('users');
                $table->foreignId('buyer_id')->constrained('users');
                $table->unsignedBigInteger('post_id');
                $table->string('quantity')->nullable();
                $table->string('status')->default('pending');
                $table->decimal('total_amount', 10, 2)->nullable();
                $table->string('receipt_image')->nullable();
                $table->timestamps();
                
                // Add foreign key
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
