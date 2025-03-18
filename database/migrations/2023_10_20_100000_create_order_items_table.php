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
        // Check if required tables exist
        if (!Schema::hasTable('orders') || !Schema::hasTable('posts')) {
            return;
        }
        
        // Check if the table already exists before attempting to create it
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('post_id');
                $table->integer('quantity')->default(1);
                $table->decimal('price', 10, 2);
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
