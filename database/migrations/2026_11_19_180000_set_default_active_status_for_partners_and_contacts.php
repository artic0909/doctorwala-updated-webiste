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
        if (Schema::hasTable('dw_partner_models') && Schema::hasColumn('dw_partner_models', 'status')) {
            Schema::table('dw_partner_models', function (Blueprint $table) {
                $table->string('status')->default('Active')->change();
            });
            DB::table('dw_partner_models')->whereNull('status')->orWhere('status', '')->orWhere('status', 'Inactive')->orWhere('status', 'Pending')->update(['status' => 'Active']);
        }

        if (Schema::hasTable('partner_o_p_d_contact_models') && Schema::hasColumn('partner_o_p_d_contact_models', 'status')) {
            Schema::table('partner_o_p_d_contact_models', function (Blueprint $table) {
                $table->string('status')->default('Active')->change();
            });
            DB::table('partner_o_p_d_contact_models')->whereNull('status')->orWhere('status', '')->orWhere('status', 'Inactive')->orWhere('status', 'Pending')->update(['status' => 'Active']);
        }

        if (Schema::hasTable('partner_pathology_contact_models') && Schema::hasColumn('partner_pathology_contact_models', 'status')) {
            Schema::table('partner_pathology_contact_models', function (Blueprint $table) {
                $table->string('status')->default('Active')->change();
            });
            DB::table('partner_pathology_contact_models')->whereNull('status')->orWhere('status', '')->orWhere('status', 'Inactive')->orWhere('status', 'Pending')->update(['status' => 'Active']);
        }

        if (Schema::hasTable('partner_doctor_contact_models') && Schema::hasColumn('partner_doctor_contact_models', 'status')) {
            Schema::table('partner_doctor_contact_models', function (Blueprint $table) {
                $table->string('status')->default('Active')->change();
            });
            DB::table('partner_doctor_contact_models')->whereNull('status')->orWhere('status', '')->orWhere('status', 'Inactive')->orWhere('status', 'Pending')->orWhere('status', 'Not Available')->update(['status' => 'Active']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse needed
    }
};
