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
        Schema::table('partner_patient_inquiries', function (Blueprint $table) {
            $table->boolean('is_video')->default(false)->after('visit_mode')->index();
            $table->string('video_channel', 100)->nullable()->unique()->after('is_video');
            $table->string('video_status', 30)->nullable()->default('scheduled')->after('video_channel')->index();
        });

        // Set is_video for existing online/video bookings
        \Illuminate\Support\Facades\DB::table('partner_patient_inquiries')
            ->whereIn('visit_mode', ['online', 'video'])
            ->update(['is_video' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partner_patient_inquiries', function (Blueprint $table) {
            $table->dropColumn(['is_video', 'video_channel', 'video_status']);
        });
    }
};
