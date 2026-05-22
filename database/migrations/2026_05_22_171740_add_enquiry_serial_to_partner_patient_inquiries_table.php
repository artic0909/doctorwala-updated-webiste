<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('partner_patient_inquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('enquiry_serial')->nullable()->after('currently_loggedin_partner_id');
        });

        // Backfill existing records grouped by partner id
        $inquiries = DB::table('partner_patient_inquiries')
            ->orderBy('id', 'asc')
            ->get();

        $serials = [];
        foreach ($inquiries as $inquiry) {
            $partnerId = $inquiry->currently_loggedin_partner_id ?? 0;
            if (!isset($serials[$partnerId])) {
                $serials[$partnerId] = 1;
            } else {
                $serials[$partnerId]++;
            }

            DB::table('partner_patient_inquiries')
                ->where('id', $inquiry->id)
                ->update(['enquiry_serial' => $serials[$partnerId]]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partner_patient_inquiries', function (Blueprint $table) {
            $table->dropColumn('enquiry_serial');
        });
    }
};
