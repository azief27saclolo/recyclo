<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the table already exists
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->string('status')->default('pending');
                $table->unsignedBigInteger('seller_id')->nullable();
                $table->unsignedBigInteger('buyer_id')->nullable();
                $table->unsignedBigInteger('post_id')->nullable();
                $table->integer('quantity')->default(1);
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('seller_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('buyer_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('set null');
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
        Schema::dropIfExists('orders');
    }
}
