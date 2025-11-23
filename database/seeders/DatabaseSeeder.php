<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            DepartmentSeeder::class,
            CategorySeeder::class,
            TicketSeeder::class,
            SubscriptionPlanSeeder::class,
            HomePageContentSeeder::class,
        ]);
    }
}

