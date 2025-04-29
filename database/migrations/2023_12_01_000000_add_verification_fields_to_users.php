<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerificationFieldsToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if columns don't already exist before adding them
            if (!Schema::hasColumn('users', 'email_verified')) {
                $table->boolean('email_verified')->default(false);
            }
            
            if (!Schema::hasColumn('users', 'verification_token')) {
                $table->string('verification_token')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'verification_sent_at')) {
                $table->timestamp('verification_sent_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('users', 'email_verified')) {
                $table->dropColumn('email_verified');
            }
            
            if (Schema::hasColumn('users', 'verification_token')) {
                $table->dropColumn('verification_token');
            }
            
            if (Schema::hasColumn('users', 'verification_sent_at')) {
                $table->dropColumn('verification_sent_at');
            }
        });
    }
}
