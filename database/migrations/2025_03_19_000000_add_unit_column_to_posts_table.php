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
            if (!Schema::hasColumn('posts', 'unit')) {
                $table->string('unit')->nullable()->after('price');
            }
            
            // Also check if quantity column exists, if not add it too
            if (!Schema::hasColumn('posts', 'quantity')) {
                $table->integer('quantity')->default(1)->after('unit');
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
            if (Schema::hasColumn('posts', 'unit')) {
                $table->dropColumn('unit');
            }
            
            if (Schema::hasColumn('posts', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });
    }
};
