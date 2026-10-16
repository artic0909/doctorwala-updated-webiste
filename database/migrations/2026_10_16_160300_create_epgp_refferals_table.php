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
        if (!Schema::hasTable('gp_refferals')) {
            Schema::create('gp_refferals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('dw_user_id')->constrained('dw_user_models')->onDelete('cascade');
                $table->foreignId('gp_id')->constrained('gps')->onDelete('cascade');
                $table->foreignId('ep_id')->nullable()->constrained('eps')->nullOnDelete();
                $table->string('gp_code')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gp_refferals');
    }
};
