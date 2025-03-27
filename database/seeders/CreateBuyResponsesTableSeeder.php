<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBuyResponsesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Schema::hasTable('buy_responses')) {
            DB::statement('
                CREATE TABLE buy_responses (
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    buy_id BIGINT UNSIGNED NOT NULL,
                    user_id BIGINT UNSIGNED NOT NULL,
                    message TEXT NOT NULL,
                    contact_info VARCHAR(255) NULL,
                    `read` BOOLEAN DEFAULT FALSE,
                    created_at TIMESTAMP NULL,
                    updated_at TIMESTAMP NULL,
                    FOREIGN KEY (buy_id) REFERENCES buys(id) ON DELETE CASCADE,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                )
            ');
        }
    }
}
