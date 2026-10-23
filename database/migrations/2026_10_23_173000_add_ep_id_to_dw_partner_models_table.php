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
            if (!Schema::hasColumn('dw_partner_models', 'ep_id')) {
                $table->unsignedBigInteger('ep_id')->nullable()->after('id');
            }
        });

        // Safely add foreign key constraint if eps table exists
        if (Schema::hasTable('eps')) {
            try {
                Schema::table('dw_partner_models', function (Blueprint $table) {
                    $table->foreign('ep_id')->references('id')->on('eps')->nullOnDelete();
                });
            } catch (\Throwable $e) {
                // Constraint might already exist
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dw_partner_models', function (Blueprint $table) {
            if (Schema::hasColumn('dw_partner_models', 'ep_id')) {
                try {
                    $table->dropForeign(['ep_id']);
                } catch (\Throwable $e) {}
                $table->dropColumn('ep_id');
            }
        });
    }
};
