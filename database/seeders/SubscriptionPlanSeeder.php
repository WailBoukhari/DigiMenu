<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'Basic',
            'description' => 'Basic subscription plan',
            'price' => 9.99,
            'create_limit' => 10,
            'scan_limit' => 100,
        ]);

        SubscriptionPlan::create([
            'name' => 'Standard',
            'description' => 'Standard subscription plan',
            'price' => 19.99,
            'create_limit' => 20,
            'scan_limit' => 200,
        ]);

        SubscriptionPlan::create([
            'name' => 'Premium',
            'description' => 'Premium subscription plan',
            'price' => 29.99,
            'create_limit' => 30,
            'scan_limit' => 300,
        ]);
    }
}
