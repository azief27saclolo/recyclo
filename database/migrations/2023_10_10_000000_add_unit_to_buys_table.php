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
        // Only add unit column if it doesn't exist
        if (!Schema::hasColumn('buys', 'unit')) {
            Schema::table('buys', function (Blueprint $table) {
                $table->string('unit', 10)->after('quantity');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
    }
};
