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
        Schema::table('wallets', function (Blueprint $table) {
            if (Schema::hasColumn('wallets', 'dw_user_id')) {
                // Drop foreign key first if it exists
                $table->dropForeign(['dw_user_id']);
                $table->dropColumn('dw_user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->unsignedBigInteger('dw_user_id')->nullable()->after('dw_partner_id')->index();
            $table->foreign('dw_user_id')
                ->references('id')
                ->on('dw_user_models')
                ->onDelete('set null');
        });
    }
};
