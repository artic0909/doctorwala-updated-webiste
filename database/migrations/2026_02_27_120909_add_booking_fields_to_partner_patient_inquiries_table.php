<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partner_patient_inquiries', function (Blueprint $table) {

            $table->unsignedBigInteger('dw_user_id')->nullable()->after('clinic_name');
            $table->unsignedBigInteger('doctor_id')->nullable()->after('dw_user_id');
            $table->unsignedBigInteger('test_id')->nullable()->after('doctor_id');

            $table->date('booking_date')->nullable()->after('dw_user_id');

            $table->time('booking_time')->nullable()->after('booking_date');

            $table->string('visit_mode')->nullable()->after('booking_time');

            $table->string('status')->default('Upcoming')->nullable()->after('booking_time');

        });
    }

    public function down(): void
    {
        Schema::table('partner_patient_inquiries', function (Blueprint $table) {

            $table->dropColumn([
                'dw_user_id',
                'doctor_id',
                'test_id',
                'booking_date',
                'booking_time',
                'visit_mode',
                'status',
            ]);
        });
    }
};
