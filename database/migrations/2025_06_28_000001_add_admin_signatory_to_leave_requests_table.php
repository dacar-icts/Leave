<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('leave_requests', 'admin_signatory')) {
            Schema::table('leave_requests', function (Blueprint $table) {
                $table->string('admin_signatory')->nullable()->after('commutation');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropColumn('admin_signatory');
        });
    }
}; 