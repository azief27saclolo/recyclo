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
        Schema::create('price_guides', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // plastic, paper, metal, batteries, glass, ewaste
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('price'); // String to allow for price ranges like "10.00-15.00"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_guides');
    }
};
