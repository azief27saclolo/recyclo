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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('unit')->after('price')->nullable();
            
            // Also check if quantity column exists, if not add it too
            if (!Schema::hasColumn('posts', 'quantity')) {
                $table->integer('quantity')->after('unit')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('unit');
            
            if (Schema::hasColumn('posts', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });
    }
};
