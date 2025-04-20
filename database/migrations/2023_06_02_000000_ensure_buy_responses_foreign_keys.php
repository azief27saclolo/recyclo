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
        if (!Schema::hasTable('buys') || !Schema::hasTable('buy_responses')) {
            return;
        }
        
        // Drop existing constraint if it exists to avoid errors
        $this->dropForeignKeyIfExists('buy_responses', 'buy_responses_buy_id_foreign');
        
        // Add the foreign key constraint
        Schema::table('buy_responses', function (Blueprint $table) {
            // Then add the foreign key
            $table->foreign('buy_id')->references('id')->on('buys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropForeignKeyIfExists('buy_responses', 'buy_responses_buy_id_foreign');
    }
    
    /**
     * Drop foreign key if exists
     */
    private function dropForeignKeyIfExists($table, $constraint)
    {
        if (!Schema::hasTable($table)) {
            return;
        }
        
        $foreignKeys = $this->getForeignKeys($table);
        if (in_array($constraint, $foreignKeys)) {
            DB::statement("ALTER TABLE {$table} DROP FOREIGN KEY {$constraint}");
        }
    }
    
    /**
     * Get the foreign keys for a table
     */
    private function getForeignKeys($table)
    {
        $conn = Schema::getConnection();
        $foreignKeys = [];
        
        try {
            $database = config('database.connections.mysql.database');
            $tables = $conn->select("SELECT TABLE_NAME, CONSTRAINT_NAME
                FROM information_schema.TABLE_CONSTRAINTS 
                WHERE CONSTRAINT_TYPE = 'FOREIGN KEY' 
                AND TABLE_SCHEMA = '$database' 
                AND TABLE_NAME = '$table'");
                
            foreach ($tables as $table) {
                $foreignKeys[] = $table->CONSTRAINT_NAME;
            }
        } catch (\Exception $e) {
            // Ignore errors
        }
        
        return $foreignKeys;
    }
};
