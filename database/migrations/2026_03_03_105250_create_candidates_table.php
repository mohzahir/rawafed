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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_code')->unique();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('nationality');
            $table->string('current_location');
            $table->string('professional_title');
            $table->string('general_specialty');
            $table->string('sub_specialty')->nullable();
            $table->integer('years_of_experience');
            $table->string('dataflow_status');
            $table->string('prometric_status');
            $table->string('scfhs_status');
            $table->string('notice_period');
            $table->string('original_cv_path');
            $table->string('blind_cv_path')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
