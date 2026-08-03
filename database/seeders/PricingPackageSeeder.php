<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PricingPackage;

class PricingPackageSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data before seeding to prevent duplicates
        PricingPackage::truncate();

        PricingPackage::create([
            'name' => 'Basic',
            'price' => '$500',
            'features' => ['Architecture Review', 'Basic CI/CD'],
            'is_featured' => false,
            'order' => 1
        ]);

        PricingPackage::create([
            'name' => 'Pro',
            'price' => '$1500',
            'features' => ['Full Migration', 'Advanced Security', '24/7 Support'],
            'is_featured' => true,
            'order' => 2
        ]);

        PricingPackage::create([
            'name' => 'Enterprise',
            'price' => 'Custom',
            'features' => ['Multi-Cloud', 'K8s Cluster'],
            'is_featured' => false,
            'order' => 3
        ]);
    }
}
