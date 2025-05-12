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
        Schema::table('users', function (Blueprint $table) {
            // Drop the old timestamp column
            $table->dropColumn('email_verified_at');
            
            // Add the new boolean column
            $table->boolean('is_email_verified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the boolean column
            $table->dropColumn('is_email_verified');
            
            // Add back the timestamp column
            $table->timestamp('email_verified_at')->nullable();
        });
    }
}; 