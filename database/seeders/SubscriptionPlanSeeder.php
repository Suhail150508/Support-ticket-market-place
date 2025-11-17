<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Basic features for individuals getting started',
                'price' => 0.00,
                'currency' => 'USD',
                'duration_days' => 365,
                'billing_cycle' => 'yearly',
                'features' => json_encode([
                    'Up to 5 tickets per month',
                    'Email support',
                    'Basic ticket tracking',
                    'Community access',
                    '24-hour response time'
                ]),
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Standard',
                'slug' => 'standard',
                'description' => 'Perfect for small teams and growing businesses',
                'price' => 29.99,
                'currency' => 'USD',
                'duration_days' => 30,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Up to 50 tickets per month',
                    'Priority email support',
                    'Advanced ticket tracking',
                    'Analytics dashboard',
                    'Custom categories',
                    '12-hour response time',
                    'File attachments up to 10MB'
                ]),
                'is_active' => true,
                'is_popular' => true,
                'sort_order' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gold',
                'slug' => 'gold',
                'description' => 'Enterprise solution with unlimited access and premium support',
                'price' => 99.99,
                'currency' => 'USD',
                'duration_days' => 30,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Unlimited tickets',
                    '24/7 premium support',
                    'Dedicated account manager',
                    'Advanced analytics & reporting',
                    'Custom integrations',
                    'API access',
                    'Priority ticket routing',
                    '1-hour response time',
                    'File attachments up to 50MB',
                    'Custom branding',
                    'Training & onboarding'
                ]),
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('subscription_plans')->insert($plans);
    }
}