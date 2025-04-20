<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Skip if posts table doesn't exist
        if (!Schema::hasTable('posts')) {
            return;
        }
        
        // Skip if orders table already exists
        if (Schema::hasTable('orders')) {
            return;
        }
        
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users');
            $table->foreignId('buyer_id')->constrained('users');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();
            
            // Add foreign key
            $table->foreign('post_id')->references('id')->on('posts');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};