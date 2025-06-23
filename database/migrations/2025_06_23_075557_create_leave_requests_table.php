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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('leave_type');
            $table->string('leave_type_other')->nullable();
            $table->string('within_ph')->nullable();
            $table->string('abroad')->nullable();
            $table->string('in_hospital')->nullable();
            $table->string('out_patient')->nullable();
            $table->string('special_leave')->nullable();
            $table->string('study_leave')->nullable();
            $table->string('other_purpose')->nullable();
            $table->integer('num_days')->nullable();
            $table->string('inclusive_dates')->nullable();
            $table->string('commutation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
