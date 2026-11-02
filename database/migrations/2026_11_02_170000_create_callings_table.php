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
        Schema::create('callings', function (Blueprint $table) {
            $table->id();
            $table->string('vapi_call_id')->nullable()->index();
            $table->string('phone_number')->nullable()->index();
            $table->string('provider_name')->nullable();
            $table->string('provider_type')->nullable(); // OPD, Pathology, Both, Doctor, Hospital, Medical Shop, etc.
            $table->string('location')->nullable();
            $table->text('doctors_and_timings')->nullable();
            $table->string('consultation_modes')->nullable(); // offline, video, both
            $table->string('doctor_fee_known')->nullable(); // yes, no, or amount
            $table->text('tests_offered')->nullable();
            $table->string('rates_list_exists')->nullable(); // yes, no, partial
            $table->string('home_sample_collection')->nullable();
            $table->string('language')->nullable(); // Hindi, Bengali, English
            $table->string('call_status')->default('completed'); // completed, busy, no-answer, failed, in-progress
            $table->string('ended_reason')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->boolean('callback_scheduled')->default(false);
            $table->string('callback_time')->nullable();
            $table->text('callback_notes')->nullable();
            $table->boolean('is_dnd')->default(false);
            $table->boolean('app_link_sent')->default(false);
            $table->text('summary')->nullable();
            $table->longText('transcript')->nullable();
            $table->text('recording_url')->nullable();
            $table->string('cost')->nullable();
            $table->longText('raw_payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callings');
    }
};

