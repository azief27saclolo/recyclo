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
        // Check if buy_responses table exists
        if (Schema::hasTable('buy_responses')) {
            // Check if buy_id column doesn't exist before adding it
            if (!Schema::hasColumn('buy_responses', 'buy_id')) {
                Schema::table('buy_responses', function (Blueprint $table) {
                    $table->foreignId('buy_id')->after('id')->constrained('buys')->onDelete('cascade');
                });
            }
            
            // Check if other required columns exist
            if (!Schema::hasColumn('buy_responses', 'seller_id')) {
                Schema::table('buy_responses', function (Blueprint $table) {
                    $table->foreignId('seller_id')->after('buy_id')->constrained('users')->onDelete('cascade');
                });
            }
            
            if (!Schema::hasColumn('buy_responses', 'message')) {
                Schema::table('buy_responses', function (Blueprint $table) {
                    $table->text('message')->after('seller_id');
                });
            }
            
            if (!Schema::hasColumn('buy_responses', 'contact_method')) {
                Schema::table('buy_responses', function (Blueprint $table) {
                    $table->string('contact_method')->after('message');
                });
            }
            
            if (!Schema::hasColumn('buy_responses', 'status')) {
                Schema::table('buy_responses', function (Blueprint $table) {
                    $table->string('status')->default('pending')->after('contact_method');
                });
            }
        } else {
            // Create the table if it doesn't exist
            Schema::create('buy_responses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('buy_id')->constrained('buys')->onDelete('cascade');
                $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
                $table->text('message');
                $table->string('contact_method'); // email, phone
                $table->string('status')->default('pending'); // pending, read, replied, etc.
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table or column in down migration to preserve data
    }
};
