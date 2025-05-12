<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('privacy_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('public_profile')->default(true);
            $table->boolean('show_email')->default(false);
            $table->boolean('show_location')->default(true);
            $table->boolean('email_notifications')->default(true);
            $table->boolean('order_notifications')->default(true);
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('privacy_settings');
    }
}; 