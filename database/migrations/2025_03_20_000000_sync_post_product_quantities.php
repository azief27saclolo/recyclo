<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, modify the posts table to use integer for quantity
        Schema::table('posts', function (Blueprint $table) {
            // Convert quantity to integer
            DB::statement('ALTER TABLE posts MODIFY quantity INTEGER NOT NULL DEFAULT 1');
        });

        // Then, ensure products table has the correct stock values
        DB::statement('
            UPDATE products p
            JOIN posts po ON p.post_id = po.id
            SET p.stock = po.quantity
            WHERE p.post_id IS NOT NULL
        ');

        // Add a trigger to keep quantities in sync
        DB::unprepared('
            CREATE TRIGGER sync_post_product_quantities
            AFTER UPDATE ON posts
            FOR EACH ROW
            BEGIN
                IF NEW.quantity != OLD.quantity THEN
                    UPDATE products 
                    SET stock = NEW.quantity 
                    WHERE post_id = NEW.id;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the trigger
        DB::unprepared('DROP TRIGGER IF EXISTS sync_post_product_quantities');

        // Convert quantity back to string in posts table
        Schema::table('posts', function (Blueprint $table) {
            DB::statement('ALTER TABLE posts MODIFY quantity VARCHAR(255) NOT NULL');
        });
    }
}; 