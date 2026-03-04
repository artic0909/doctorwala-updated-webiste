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
        Schema::create('access_requests', function (Blueprint $table) {
            $table->id();

            // ── Patient (DW User) ─────────────────────────────
            $table->unsignedBigInteger('dw_user_id')->nullable();
            $table->foreign('dw_user_id')
                ->references('id')
                ->on('dw_user_models')
                ->cascadeOnDelete();

            // ── Doctor ────────────────────────────────────────
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')
                ->references('id')
                ->on('partner_all_o_p_d_doctor_models')
                ->cascadeOnDelete();

            // ── Partner / Clinic info (snapshot at request time) ──
            $table->string('currently_loggedin_partner_id')->nullable();
            $table->string('partner_clinic_name')->nullable();
            $table->string('partner_contact_person_name')->nullable();
            $table->string('partner_mobile_number')->nullable();
            $table->string('partner_email')->nullable();
            $table->string('partner_state')->nullable();
            $table->string('partner_city')->nullable();
            $table->string('partner_landmark')->nullable();
            $table->string('partner_pincode')->nullable();

            // ── Patient lookup fields ─────────────────────────
            $table->string('dw_medical_id')->nullable();
            $table->string('dw_member_id')->nullable(); 

            // ── Status fields ─────────────────────────────────
            $table->enum('read_status', ['unread', 'read'])
                ->default('unread');

            $table->enum('req_status', ['pending', 'accepted', 'rejected'])
                ->default('pending');

            $table->enum('access_status', ['on', 'off'])
                ->default('off');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_requests');
    }
};
