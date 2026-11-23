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
        // Add payment fields to partner_patient_inquiries
        Schema::table('partner_patient_inquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('partner_patient_inquiries', 'payment_status')) {
                $table->string('payment_status', 30)->default('unpaid')->after('status')->index();
            }
            if (!Schema::hasColumn('partner_patient_inquiries', 'payment_amount')) {
                $table->decimal('payment_amount', 12, 2)->default(0.00)->after('payment_status');
            }
            if (!Schema::hasColumn('partner_patient_inquiries', 'razorpay_order_id')) {
                $table->string('razorpay_order_id', 100)->nullable()->after('payment_amount')->index();
            }
            if (!Schema::hasColumn('partner_patient_inquiries', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id', 100)->nullable()->after('razorpay_order_id')->index();
            }
            if (!Schema::hasColumn('partner_patient_inquiries', 'razorpay_signature')) {
                $table->text('razorpay_signature')->nullable()->after('razorpay_payment_id');
            }
        });

        // Add settlement & payment tracking fields to wallet_transactions
        Schema::table('wallet_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('wallet_transactions', 'settlement_status')) {
                $table->string('settlement_status', 30)->default('pending')->after('status')->index(); // pending, settled, rejected
            }
            if (!Schema::hasColumn('wallet_transactions', 'settled_at')) {
                $table->timestamp('settled_at')->nullable()->after('settlement_status');
            }
            if (!Schema::hasColumn('wallet_transactions', 'settled_by')) {
                $table->unsignedBigInteger('settled_by')->nullable()->after('settled_at');
            }
            if (!Schema::hasColumn('wallet_transactions', 'settlement_notes')) {
                $table->text('settlement_notes')->nullable()->after('settled_by');
            }
            if (!Schema::hasColumn('wallet_transactions', 'inquiry_id')) {
                $table->unsignedBigInteger('inquiry_id')->nullable()->after('settlement_notes')->index();
                $table->foreign('inquiry_id')
                    ->references('id')
                    ->on('partner_patient_inquiries')
                    ->onDelete('set null');
            }
            if (!Schema::hasColumn('wallet_transactions', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id', 100)->nullable()->after('inquiry_id')->index();
            }
            if (!Schema::hasColumn('wallet_transactions', 'razorpay_order_id')) {
                $table->string('razorpay_order_id', 100)->nullable()->after('razorpay_payment_id')->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partner_patient_inquiries', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'payment_amount',
                'razorpay_order_id',
                'razorpay_payment_id',
                'razorpay_signature',
            ]);
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropForeign(['inquiry_id']);
            $table->dropColumn([
                'settlement_status',
                'settled_at',
                'settled_by',
                'settlement_notes',
                'inquiry_id',
                'razorpay_payment_id',
                'razorpay_order_id',
            ]);
        });
    }
};
