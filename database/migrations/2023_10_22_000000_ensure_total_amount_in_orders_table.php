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
        // Skip entirely as total_amount is already added in the table creation
        return;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Skip entirely
        return;
    }
};
