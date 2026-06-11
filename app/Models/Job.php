<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title', 'slug', 'specialty', 'country', 'salary_range', 'description', 'is_active'];
}
