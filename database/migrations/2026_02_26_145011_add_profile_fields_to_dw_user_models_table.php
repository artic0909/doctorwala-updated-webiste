<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('dw_user_models', function (Blueprint $table) {

            $table->string('image')->nullable()->after('user_email');
            $table->date('dob')->nullable();
            $table->text('memberid')->unique()->nullable();
            $table->text('medical_card_no')->unique()->nullable();
            $table->string('blood_group')->nullable();
            $table->text('address')->nullable();
            $table->string('gender')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('allergies')->nullable();
            $table->text('chronic_conditions')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('dw_user_models', function (Blueprint $table) {
            $table->dropColumn([
                'image',
                'dob',
                'memberid',
                'medical_card_no',
                'blood_group',
                'address',
                'gender',
                'height',
                'weight',
                'emergency_contact',
                'allergies',
                'chronic_conditions'
            ]);
        });
    }
};
