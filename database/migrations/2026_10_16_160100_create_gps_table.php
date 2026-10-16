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
        Schema::create('gps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ep_id')->constrained('eps')->onDelete('cascade');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('mobile')->unique();
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        // Safely migrate existing GP records from ep_gps if present
        if (Schema::hasTable('ep_gps')) {
            $firstEp = DB::table('eps')->first();
            if ($firstEp) {
                $existing = DB::table('ep_gps')->where('role', 'GP')->get();
                foreach ($existing as $row) {
                    DB::table('gps')->insertOrIgnore([
                        'id' => $row->id,
                        'ep_id' => $firstEp->id,
                        'name' => $row->name,
                        'code' => $row->code,
                        'mobile' => $row->mobile,
                        'status' => $row->status ?? 'Active',
                        'created_at' => $row->created_at ?? now(),
                        'updated_at' => $row->updated_at ?? now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gps');
    }
};
