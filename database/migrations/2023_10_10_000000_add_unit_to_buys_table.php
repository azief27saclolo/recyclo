<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Skip this migration entirely as unit is already included in create_buys_table
        // Do not attempt to modify the buys table at all
    }

    public function down()
    {
        // No action needed
    }
};
