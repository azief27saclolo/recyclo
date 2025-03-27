<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if profile_picture exists before trying to add status after it
            if (Schema::hasColumn('users', 'profile_picture')) {
                if (!Schema::hasColumn('users', 'status')) {
                    $table->string('status')->default('active')->after('profile_picture');
                }
            } else {
                // If profile_picture doesn't exist, add status after email
                if (!Schema::hasColumn('users', 'status')) {
                    $table->string('status')->default('active')->after('email');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
