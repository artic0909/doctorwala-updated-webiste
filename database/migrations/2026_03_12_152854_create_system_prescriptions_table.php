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
        Schema::create('system_prescriptions', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->unsignedBigInteger('dw_user_id');
            $blueprint->unsignedBigInteger('partner_id');
            $blueprint->unsignedBigInteger('opd_doctor_id')->nullable();
            $blueprint->string('doctor_name')->nullable();
            $blueprint->date('prescription_date')->nullable();
            
            // Health Parameters
            $blueprint->string('bp')->nullable();
            $blueprint->string('pulse')->nullable();
            $blueprint->string('spo2')->nullable();
            $blueprint->string('temperature')->nullable();
            $blueprint->string('weight')->nullable();
            
            // Symptoms & Tests
            $blueprint->text('symptoms')->nullable();
            $blueprint->json('recommended_tests')->nullable();
            
            // Medicines
            $blueprint->json('medicines')->nullable();
            
            // Instructions
            $blueprint->text('medical_instructions')->nullable();
            $blueprint->text('diet_instructions')->nullable();
            
            // Follow up
            $blueprint->date('next_visit_date')->nullable();
            $blueprint->boolean('repeat_tests_required')->default(false);
            $blueprint->text('emergency_note')->nullable();
            
            $blueprint->timestamps();
            
            // Foreign keys
            $blueprint->foreign('dw_user_id')->references('id')->on('dw_user_models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_prescriptions');
    }
};
