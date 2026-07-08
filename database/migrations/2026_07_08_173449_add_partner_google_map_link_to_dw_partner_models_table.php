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
            $table->text('clinic_google_map_link')->nullable()->after('partner_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dw_partner_models', function (Blueprint $table) {
            $table->dropColumn('clinic_google_map_link');
        });
    }
};
