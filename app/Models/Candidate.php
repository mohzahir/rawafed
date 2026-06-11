<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $guarded = []; // هذه الطريقة الأسهل لتجنب أخطاء Mass Assignment

    protected $casts = [
    'target_countries' => 'array',
    'current_licenses' => 'array',
    'extracted_skills' => 'array', // 👈 تمت الإضافة
    'is_active' => 'boolean',
    'needs_manual_review' => 'boolean',
    ];
}