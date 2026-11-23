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
        Schema::create('bank_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dw_partner_id')->index();
            $table->string('account_no', 100);
            $table->string('ifsc_code', 30);
            $table->string('bank_name', 150);
            $table->string('branch_name', 150)->nullable();
            $table->string('account_holder_name', 150)->nullable();
            $table->string('upi_id', 100)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->string('status', 30)->default('active'); // active, inactive, pending
            $table->timestamps();

            $table->foreign('dw_partner_id')
                ->references('id')
                ->on('dw_partner_models')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_details');
    }
};
