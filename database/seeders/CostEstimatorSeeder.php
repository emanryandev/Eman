<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\CostEstimator;

class CostEstimatorSeeder extends Seeder
{
    public function run(): void
    {
        CostEstimator::truncate();

        CostEstimator::create([
            'name' => 'Compute (EC2 Instances)',
            'unit' => 'Instances',
            'min_value' => 1,
            'max_value' => 50,
            'step_value' => 1,
            'price_per_unit' => 25.00,
            'order' => 1
        ]);

        CostEstimator::create([
            'name' => 'Database Storage',
            'unit' => 'GB',
            'min_value' => 10,
            'max_value' => 2000,
            'step_value' => 10,
            'price_per_unit' => 0.115,
            'order' => 2
        ]);

        CostEstimator::create([
            'name' => 'Object Storage (S3)',
            'unit' => 'GB',
            'min_value' => 50,
            'max_value' => 10000,
            'step_value' => 50,
            'price_per_unit' => 0.023,
            'order' => 3
        ]);
    }
}
