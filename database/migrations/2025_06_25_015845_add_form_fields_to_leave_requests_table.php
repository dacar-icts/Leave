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
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->string('within_ph_details')->nullable();
            $table->string('abroad_details')->nullable();
            $table->string('in_hospital_details')->nullable();
            $table->string('out_patient_details')->nullable();
            $table->string('special_leave_details')->nullable();
            $table->string('completion_masters')->nullable();
            $table->string('bar_exam')->nullable();
            $table->string('monetization')->nullable();
            $table->string('terminal_leave')->nullable();
            $table->string('office')->nullable();
            $table->string('position')->nullable();
            $table->string('salary')->nullable();
            $table->string('filing_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropColumn([
                'within_ph_details',
                'abroad_details',
                'in_hospital_details',
                'out_patient_details',
                'special_leave_details',
                'completion_masters',
                'bar_exam',
                'monetization',
                'terminal_leave',
                'office',
                'position',
                'salary',
                'filing_date',
            ]);
        });
    }
};
