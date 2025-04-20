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
        // Create buy_responses table without foreign key constraints initially
        Schema::create('buy_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buy_id');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->text('message');
            $table->string('contact_method'); // email, phone
            $table->string('status')->default('pending'); // pending, read, replied
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_responses');
    }
};
