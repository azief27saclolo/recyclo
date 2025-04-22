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
        // Skip if table already exists or buys table doesn't exist
        if (Schema::hasTable('buy_responses') || !Schema::hasTable('buys')) {
            return;
        }
        
        // Create buy_responses table with foreign key constraint
        Schema::create('buy_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buy_id');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->text('message');
            $table->string('contact_method'); // email, phone
            $table->string('status')->default('pending'); // pending, read, replied
            $table->timestamps();
            
            // Add foreign key directly in the table creation
            $table->foreign('buy_id')->references('id')->on('buys')->onDelete('cascade');
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
