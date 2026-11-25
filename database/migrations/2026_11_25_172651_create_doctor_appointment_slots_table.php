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
        Schema::create('doctor_appointment_slots', function (Blueprint $table) {
            $table->id();
            $table->string('currently_loggedin_partner_id')->index();
            $table->unsignedBigInteger('doctor_id')->default(0)->index();
            $table->string('clinic_type')->default('Doctor');
            $table->date('slot_date')->index();
            $table->string('shift')->default('morning'); // morning, afternoon, evening, regular
            $table->string('shift_name')->nullable();    // Morning, Afternoon, Evening
            $table->unsignedInteger('slot_number');      // 1, 2, 3...
            $table->string('slot_name');                // Slot 1, Slot 2...
            $table->string('start_time', 10);           // 10:00
            $table->string('end_time', 10);             // 10:10
            $table->string('status')->default('available')->index(); // available, booked, blocked
            $table->unsignedBigInteger('dw_user_id')->nullable()->index();
            $table->string('patient_name')->nullable();
            $table->string('patient_mobile')->nullable();
            $table->string('patient_email')->nullable();
            $table->unsignedBigInteger('inquiry_id')->nullable()->index();
            $table->string('payment_id')->nullable();
            $table->timestamps();

            $table->unique(
                ['currently_loggedin_partner_id', 'doctor_id', 'slot_date', 'shift', 'slot_number'],
                'doc_slot_unique_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_appointment_slots');
    }
};
