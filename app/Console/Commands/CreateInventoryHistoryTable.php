<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInventoryHistoryTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:inventory-history-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the inventory history table if it does not exist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!Schema::hasTable('inventory_histories')) {
            $this->info('Creating inventory_histories table...');
            
            Schema::create('inventory_histories', function ($table) {
                $table->id();
                $table->unsignedBigInteger('post_id');
                $table->unsignedBigInteger('user_id');
                $table->string('action');
                $table->string('field_name');
                $table->string('old_value')->nullable();
                $table->string('new_value');
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
            
            $this->info('Table inventory_histories created successfully!');
        } else {
            $this->info('Table inventory_histories already exists.');
        }
    }
}
