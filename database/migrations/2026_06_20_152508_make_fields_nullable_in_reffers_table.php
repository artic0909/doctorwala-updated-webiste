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
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'mysql') {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE reffers MODIFY COLUMN name VARCHAR(255) NULL');
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE reffers MODIFY COLUMN phone VARCHAR(255) NULL');
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE reffers MODIFY COLUMN upi VARCHAR(255) NULL');
        } else {
            Schema::table('reffers', function (Blueprint $table) {
                $table->string('name')->nullable()->change();
                $table->string('phone')->nullable()->change();
                $table->string('upi')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'mysql') {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE reffers MODIFY COLUMN name VARCHAR(255) NOT NULL');
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE reffers MODIFY COLUMN phone VARCHAR(255) NOT NULL');
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE reffers MODIFY COLUMN upi VARCHAR(255) NOT NULL');
        }
    }
};
