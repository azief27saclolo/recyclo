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
        // Skip if posts table doesn't exist
        if (!Schema::hasTable('posts')) {
            return;
        }
        
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'address')) {
                $table->text('address')->nullable()->after('location');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('posts')) {
            return;
        }
        
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
};
