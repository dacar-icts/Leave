<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all existing users with default position
        DB::statement("UPDATE users SET position = 'Employee' WHERE position IS NULL");
        
        // Update the first user to be a Department Head
        DB::statement("UPDATE users SET position = 'Department Head' LIMIT 1");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed to revert
    }
};
