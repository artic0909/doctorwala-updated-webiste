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
        Schema::table('medical_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_id')->nullable()->after('dw_user_id');
            $table->string('clinic_name')->nullable()->after('partner_id');
            $table->unsignedBigInteger('opd_doctor_id')->nullable()->after('clinic_name');
            $table->string('doctor_name')->nullable()->after('opd_doctor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_histories', function (Blueprint $table) {
            $table->dropColumn(['partner_id', 'clinic_name', 'opd_doctor_id', 'doctor_name']);
        });
    }
};
