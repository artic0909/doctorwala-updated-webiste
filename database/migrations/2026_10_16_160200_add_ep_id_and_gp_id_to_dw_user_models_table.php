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
        Schema::table('dw_user_models', function (Blueprint $table) {
            if (!Schema::hasColumn('dw_user_models', 'ep_id')) {
                $table->unsignedBigInteger('ep_id')->nullable()->after('chronic_conditions');
            }
            if (!Schema::hasColumn('dw_user_models', 'gp_id')) {
                $table->unsignedBigInteger('gp_id')->nullable()->after('ep_id');
            }
        });

        // Add foreign key for ep_id safely
        if (Schema::hasTable('eps')) {
            try {
                Schema::table('dw_user_models', function (Blueprint $table) {
                    $table->foreign('ep_id')->references('id')->on('eps')->nullOnDelete();
                });
            } catch (\Throwable $e) {
                // Constraint might already exist
            }
        }

        // Add foreign key for gp_id safely
        if (Schema::hasTable('gps')) {
            try {
                Schema::table('dw_user_models', function (Blueprint $table) {
                    $table->foreign('gp_id')->references('id')->on('gps')->nullOnDelete();
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
        Schema::table('dw_user_models', function (Blueprint $table) {
            if (Schema::hasColumn('dw_user_models', 'ep_id')) {
                try {
                    $table->dropForeign(['ep_id']);
                } catch (\Throwable $e) {}
                $table->dropColumn('ep_id');
            }
            if (Schema::hasColumn('dw_user_models', 'gp_id')) {
                try {
                    $table->dropForeign(['gp_id']);
                } catch (\Throwable $e) {}
                $table->dropColumn('gp_id');
            }
        });
    }
};
