<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitToBuysTable extends Migration
{
    public function up()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->string('unit', 10)->after('quantity');
        });
    }

    public function down()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
    }
}
