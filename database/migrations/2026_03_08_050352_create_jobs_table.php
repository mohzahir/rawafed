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
        // 🌟 هذا السطر سيمسح الجدول القديم المعلق إذا كان موجوداً لتفادي الخطأ
        Schema::dropIfExists('jobs');
        
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // مثال: مطلوب استشاري تخدير
            $table->string('slug')->unique(); // الرابط المخصص: consultant-anesthesia
            $table->string('specialty'); // التخصص
            $table->string('country'); // الدولة
            $table->string('salary_range')->nullable(); // الراتب
            $table->text('description'); // التفاصيل والمميزات
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
