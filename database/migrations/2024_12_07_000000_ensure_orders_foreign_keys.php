<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Skip if either table doesn't exist
        if (!Schema::hasTable('posts') || !Schema::hasTable('orders')) {
            return;
        }
        
        // Check if the foreign key exists using raw SQL
        $constraint = $this->getConstraint('orders', 'orders_post_id_foreign');
        if ($constraint) {
            // Foreign key already exists
            return;
        }
        
        // Create the foreign key constraint if column exists but constraint doesn't
        if (Schema::hasColumn('orders', 'post_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $constraint = $this->getConstraint('orders', 'orders_post_id_foreign');
                if ($constraint) {
                    $table->dropForeign(['post_id']);
                }
            });
        }
    }
    
    /**
     * Check if foreign key constraint exists
     */
    private function getConstraint($table, $constraintName)
    {
        try {
            $database = config('database.connections.mysql.database');
            $constraints = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
                WHERE TABLE_SCHEMA = '$database' 
                AND TABLE_NAME = '$table' 
                AND CONSTRAINT_NAME = '$constraintName'
            ");
            
            return count($constraints) > 0 ? $constraints[0]->CONSTRAINT_NAME : null;
        } catch (\Exception $e) {
            return null;
        }
    }
};
