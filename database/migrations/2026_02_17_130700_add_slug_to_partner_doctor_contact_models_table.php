<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\PartnerDoctorContactModel;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add nullable first (existing rows have no slug yet)
        Schema::table('partner_doctor_contact_models', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('status');
        });

        // Step 2: Generate slugs for all existing records ✅
        $existingSlugs = [];

        PartnerDoctorContactModel::whereNull('slug')->each(function ($record) use (&$existingSlugs) {
            $base = Str::slug($record->partner_doctor_name);  // 👈 from doctor name
            $slug = $base;
            $count = 1;

            while (in_array($slug, $existingSlugs)) {
                $slug = $base . '-' . $count++;
            }

            $existingSlugs[] = $slug;
            $record->slug = $slug;
            $record->saveQuietly();
        });

        // Step 3: Make it unique & non-nullable
        Schema::table('partner_doctor_contact_models', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('partner_doctor_contact_models', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};