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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id')->index();
            $table->unsignedBigInteger('dw_partner_id')->nullable()->index();
            $table->unsignedBigInteger('dw_user_id')->nullable()->index();
            $table->string('transaction_type', 20); // credit, debit
            $table->string('source', 50)->default('consultation'); // consultation, appointment, video_call, withdrawal, payout, refund, bonus, manual
            $table->decimal('amount', 12, 2);
            $table->decimal('opening_balance', 12, 2)->default(0.00);
            $table->decimal('closing_balance', 12, 2)->default(0.00);
            $table->string('reference_id', 100)->nullable()->index();
            $table->text('description')->nullable();
            $table->string('status', 30)->default('completed'); // completed, pending, failed, cancelled
            $table->timestamps();

            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onDelete('cascade');

            $table->foreign('dw_partner_id')
                ->references('id')
                ->on('dw_partner_models')
                ->onDelete('cascade');

            $table->foreign('dw_user_id')
                ->references('id')
                ->on('dw_user_models')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
