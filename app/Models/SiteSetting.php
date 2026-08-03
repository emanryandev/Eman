<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'core_skills' => 'array',
        'hobbies' => 'array',
        'radar_skills' => 'array',
        'testimonials' => 'array',
        'experience_journey' => 'array',
        'certifications' => 'array',
        'tech_categories' => 'array',
        'services' => 'array',
    ];
}
