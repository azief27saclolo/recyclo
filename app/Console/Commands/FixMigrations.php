<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixMigrations extends Command
{
    protected $signature = 'migrate:fix';
    protected $description = 'Fix migration issues by manually inserting migration records';

    public function handle()
    {
        // Add cart_items migration to the migrations table if not already present
        if (!DB::table('migrations')->where('migration', '2023_05_25_000001_create_cart_items_table')->exists()) {
            DB::table('migrations')->insert([
                'migration' => '2023_05_25_000001_create_cart_items_table',
                'batch' => DB::table('migrations')->max('batch') ?: 1
            ]);
            
            $this->info('Migration 2023_05_25_000001_create_cart_items_table added to migrations table.');
        } else {
            $this->info('Migration 2023_05_25_000001_create_cart_items_table already exists in migrations table.');
        }
        
        // Add the carts migration if needed
        if (!DB::table('migrations')->where('migration', '2023_05_25_000000_create_carts_table')->exists()) {
            DB::table('migrations')->insert([
                'migration' => '2023_05_25_000000_create_carts_table',
                'batch' => DB::table('migrations')->max('batch') ?: 1
            ]);
            
            $this->info('Migration 2023_05_25_000000_create_carts_table added to migrations table.');
        } else {
            $this->info('Migration 2023_05_25_000000_create_carts_table already exists in migrations table.');
        }
        
        // Add the products migration if needed
        if (!DB::table('migrations')->where('migration', '2023_05_24_000000_create_products_table')->exists()) {
            DB::table('migrations')->insert([
                'migration' => '2023_05_24_000000_create_products_table',
                'batch' => DB::table('migrations')->max('batch') ?: 1
            ]);
            
            $this->info('Migration 2023_05_24_000000_create_products_table added to migrations table.');
        } else {
            $this->info('Migration 2023_05_24_000000_create_products_table already exists in migrations table.');
        }

        $this->info('Migration table updated successfully! The system now recognizes your tables.');
    }
}
