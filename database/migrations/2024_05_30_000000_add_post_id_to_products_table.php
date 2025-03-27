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
        // Skip if posts table doesn't exist
        if (!Schema::hasTable('posts')) {
            return;
        }
        
        // Skip if products table doesn't exist
        if (!Schema::hasTable('products')) {
            return;
        }
        
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'post_id')) {
                // First add the column without constraints
                $table->unsignedBigInteger('post_id')->nullable()->after('user_id');
            }
        });
        
        // Then add the foreign key constraint in a separate step
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'post_id')) {
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            }
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
                // Drop foreign key first
                $table->dropForeign(['post_id']);
                $table->dropColumn('post_id');
            }
        });
    }
};
