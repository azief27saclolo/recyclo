<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CreateBuyResponsesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:buy-responses-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the buy_responses table if it does not exist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!Schema::hasTable('buy_responses')) {
            $this->info('Creating buy_responses table...');
            
            Schema::create('buy_responses', function ($table) {
                $table->id();
                $table->unsignedBigInteger('buy_id');
                $table->unsignedBigInteger('user_id');
                $table->text('message');
                $table->string('contact_info')->nullable();
                $table->boolean('read')->default(false);
                $table->timestamps();
                
                $table->foreign('buy_id')->references('id')->on('buys')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
            
            $this->info('Table buy_responses created successfully!');
        } else {
            $this->info('Table buy_responses already exists.');
        }
    }
}
