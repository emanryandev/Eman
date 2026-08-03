<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPackage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'price', 'features', 'is_featured', 'order'
    ];
    
    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean'
    ];
}
