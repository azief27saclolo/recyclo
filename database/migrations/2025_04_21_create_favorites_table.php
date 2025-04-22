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
        // Skip if favorites table already exists or posts table doesn't exist
        if (Schema::hasTable('favorites') || !Schema::hasTable('posts')) {
            return;
        }
        
        // Only create if not created by previous migration
        if (!Schema::hasTable('favorites')) {
            Schema::create('favorites', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('post_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                
                // Ensure a user can favorite a post only once
                $table->unique(['user_id', 'post_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only drop if not handled by the other migration
        if (Schema::hasTable('favorites')) {
            Schema::dropIfExists('favorites');
        }
    }
};
