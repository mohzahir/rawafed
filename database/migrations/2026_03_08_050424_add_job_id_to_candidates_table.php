<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            // إضافة الحقل لربط الطبيب بالوظيفة (nullable لأنه قد يسجل بدون وظيفة محددة)
            $table->foreignId('job_id')->nullable()->constrained('jobs')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            //
        });
    }
};
