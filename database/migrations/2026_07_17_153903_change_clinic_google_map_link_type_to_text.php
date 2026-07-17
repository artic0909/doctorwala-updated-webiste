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
        Schema::table('dw_partner_models', function (Blueprint $table) {
            $table->text('clinic_google_map_link')->nullable()->change();
        });
        Schema::table('partner_o_p_d_contact_models', function (Blueprint $table) {
            $table->text('clinic_google_map_link')->nullable()->change();
        });
        Schema::table('partner_pathology_contact_models', function (Blueprint $table) {
            $table->text('clinic_google_map_link')->nullable()->change();
        });
        Schema::table('partner_doctor_contact_models', function (Blueprint $table) {
            $table->text('partner_doctor_google_map_link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dw_partner_models', function (Blueprint $table) {
            $table->string('clinic_google_map_link', 255)->nullable()->change();
        });
        Schema::table('partner_o_p_d_contact_models', function (Blueprint $table) {
            $table->string('clinic_google_map_link', 255)->nullable()->change();
        });
        Schema::table('partner_pathology_contact_models', function (Blueprint $table) {
            $table->string('clinic_google_map_link', 255)->nullable()->change();
        });
        Schema::table('partner_doctor_contact_models', function (Blueprint $table) {
            $table->string('partner_doctor_google_map_link', 255)->nullable()->change();
        });
    }
};
