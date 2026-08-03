<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostEstimator extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'unit', 'min_value', 'max_value', 'step_value', 'price_per_unit', 'order'
    ];
}
