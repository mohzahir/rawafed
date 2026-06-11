<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            // إضافة الحقل كقيمة منطقية (افتراضياً يكون false أي لا يحتاج مراجعة)
            $table->boolean('needs_manual_review')->default(false)->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            // لحذف الحقل في حال التراجع عن التحديث
            $table->dropColumn('needs_manual_review');
        });
    }
};