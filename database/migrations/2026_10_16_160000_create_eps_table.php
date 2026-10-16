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
        Schema::create('eps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('mobile')->unique();
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        // Safely migrate existing EP records from ep_gps if present
        if (Schema::hasTable('ep_gps')) {
            $existing = DB::table('ep_gps')->where('role', 'EP')->get();
            foreach ($existing as $row) {
                DB::table('eps')->insertOrIgnore([
                    'id' => $row->id,
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eps');
    }
};
