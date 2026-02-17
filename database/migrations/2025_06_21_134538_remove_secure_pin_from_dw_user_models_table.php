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
            Schema::table('dw_user_models', function (Blueprint $table) {
                $table->dropColumn('secure_pin');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dw_user_models', function (Blueprint $table) {
            Schema::table('dw_user_models', function (Blueprint $table) {
                $table->string('secure_pin')->nullable(); // or original type
            });
        });
    }
};
