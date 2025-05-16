<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Skip if buys table already exists
        if (Schema::hasTable('buys')) {
            return;
        }
        
        Schema::create('buys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category');
            $table->integer('quantity');
            $table->string('unit', 10);
            $table->text('description');
            $table->string('location')->nullable();
            $table->string('number')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buys');
    }
};
