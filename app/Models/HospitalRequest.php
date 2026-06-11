<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    // 🌟 هذه العلاقة مهمة جداً لجلب بيانات السيرة الذاتية الأصلية
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}