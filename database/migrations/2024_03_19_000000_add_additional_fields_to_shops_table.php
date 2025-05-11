<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->text('shop_description')->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('business_hours', 100)->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
        });
    }

    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'shop_description',
                'contact_number',
                'business_hours',
                'latitude',
                'longitude'
            ]);
        });
    }
}; 