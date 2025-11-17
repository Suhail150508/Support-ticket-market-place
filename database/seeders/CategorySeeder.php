<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Technical Support Categories
            ['name' => 'Software Bug', 'description' => 'Report software bugs and glitches', 'department_id' => 1],
            ['name' => 'Login Issues', 'description' => 'Problems with account access and authentication', 'department_id' => 1],
            ['name' => 'Performance Issues', 'description' => 'Slow performance or system lag', 'department_id' => 1],
            ['name' => 'Feature Request', 'description' => 'Request for new features or enhancements', 'department_id' => 1],
            
            // Customer Service Categories
            ['name' => 'General Inquiry', 'description' => 'General questions and information requests', 'department_id' => 2],
            ['name' => 'Complaint', 'description' => 'Customer complaints and feedback', 'department_id' => 2],
            ['name' => 'Product Information', 'description' => 'Questions about products and services', 'department_id' => 2],
            ['name' => 'Account Support', 'description' => 'Account-related support and assistance', 'department_id' => 2],
            
            // Billing & Accounts Categories
            ['name' => 'Payment Issue', 'description' => 'Problems with payments and transactions', 'department_id' => 3],
            ['name' => 'Invoice Request', 'description' => 'Request for invoices and receipts', 'department_id' => 3],
            ['name' => 'Refund Request', 'description' => 'Request for refunds and cancellations', 'department_id' => 3],
            ['name' => 'Subscription', 'description' => 'Subscription management and changes', 'department_id' => 3],
            
            // Sales Categories
            ['name' => 'Product Demo', 'description' => 'Request for product demonstration', 'department_id' => 4],
            ['name' => 'Pricing Inquiry', 'description' => 'Questions about pricing and plans', 'department_id' => 4],
            ['name' => 'Partnership', 'description' => 'Partnership and collaboration opportunities', 'department_id' => 4],
            
            // Human Resources Categories
            ['name' => 'Leave Request', 'description' => 'Employee leave and time-off requests', 'department_id' => 5],
            ['name' => 'Policy Question', 'description' => 'Questions about company policies', 'department_id' => 5],
            ['name' => 'Payroll', 'description' => 'Payroll and compensation issues', 'department_id' => 5],
            
            // IT Infrastructure Categories
            ['name' => 'Network Issue', 'description' => 'Network connectivity and access problems', 'department_id' => 6],
            ['name' => 'Hardware Problem', 'description' => 'Hardware malfunctions and replacements', 'department_id' => 6],
            ['name' => 'Access Request', 'description' => 'Request for system or resource access', 'department_id' => 6],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'department_id' => $category['department_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}