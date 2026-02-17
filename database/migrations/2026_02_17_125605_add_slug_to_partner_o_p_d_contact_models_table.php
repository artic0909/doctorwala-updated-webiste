<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\PartnerOPDContactModel;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add slug column as nullable first (because existing rows have no slug yet)
        Schema::table('partner_o_p_d_contact_models', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('status');
        });

        // Step 2: Generate slugs for all existing records (so your old data is safe ✅)
        $existingSlugs = [];

        PartnerOPDContactModel::whereNull('slug')->each(function ($record) use (&$existingSlugs) {
            $base = Str::slug($record->clinic_name);
            $slug = $base;
            $count = 1;

            while (in_array($slug, $existingSlugs)) {
                $slug = $base . '-' . $count++;
            }

            $existingSlugs[] = $slug;
            $record->slug = $slug;
            $record->saveQuietly(); // saveQuietly = skips model events, safe for migration
        });

        // Step 3: Now make it unique & non-nullable
        Schema::table('partner_o_p_d_contact_models', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('partner_o_p_d_contact_models', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};