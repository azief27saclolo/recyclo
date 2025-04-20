<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Skip if either posts table or products table doesn't exist
        if (!Schema::hasTable('posts') || !Schema::hasTable('products')) {
            return;
        }
        
        // Check if column already exists
        if (Schema::hasColumn('products', 'post_id')) {
            return;
        }
        
        // Add post_id column
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->nullable()->after('user_id');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Skip if products table doesn't exist
        if (!Schema::hasTable('products')) {
            return;
        }
        
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'post_id')) {
                // Drop foreign key first - use the standard naming convention
                $table->dropForeign(['post_id']);
                $table->dropColumn('post_id');
            }
        });
    }
};
