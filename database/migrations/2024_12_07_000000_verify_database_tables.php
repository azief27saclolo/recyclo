<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Check if all expected tables exist in the database
     */
    public function up(): void
    {
        $expectedTables = [
            'users', 'password_reset_tokens', 'sessions', 'jobs', 'job_batches', 
            'failed_jobs', 'cache', 'cache_locks', 'posts', 'orders', 'products', 
            'shops', 'admins', 'favorites', 'reviews', 'buys', 'carts', 'cart_items',
            'order_items'
        ];
        
        $missingTables = [];
        foreach ($expectedTables as $table) {
            if (!Schema::hasTable($table)) {
                $missingTables[] = $table;
            }
        }
        
        if (!empty($missingTables)) {
            Log::warning('Missing database tables: ' . implode(', ', $missingTables));
            echo 'Warning: Missing database tables: ' . implode(', ', $missingTables) . PHP_EOL;
        } else {
            echo 'All expected database tables exist.' . PHP_EOL;
        }
        
        // Check for duplicate primary keys in users table
        try {
            $users = DB::table('users')->get();
            $userIds = [];
            $duplicateIds = [];
            
            foreach ($users as $user) {
                if (in_array($user->id, $userIds)) {
                    $duplicateIds[] = $user->id;
                }
                $userIds[] = $user->id;
            }
            
            if (!empty($duplicateIds)) {
                Log::warning('Duplicate user IDs found: ' . implode(', ', array_unique($duplicateIds)));
                echo 'Warning: Duplicate user IDs found: ' . implode(', ', array_unique($duplicateIds)) . PHP_EOL;
            }
        } catch (\Exception $e) {
            Log::error('Error checking for duplicate user IDs: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed for down migration
    }
};
