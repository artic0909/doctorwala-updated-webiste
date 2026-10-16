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
            $table->foreignId('ep_id')->nullable()->after('chronic_conditions')->constrained('eps')->nullOnDelete();
            $table->foreignId('gp_id')->nullable()->after('ep_id')->constrained('gps')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dw_user_models', function (Blueprint $table) {
            $table->dropForeign(['ep_id']);
            $table->dropForeign(['gp_id']);
            $table->dropColumn(['ep_id', 'gp_id']);
        });
    }
};
