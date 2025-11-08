<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'user@example.com')->first();
        if (! $user) return;

        Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Demo: Cannot login to account',
            'message' => 'I tried to login but it says invalid credentials. Please help.',
            'status' => 'open',
        ]);

        Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Demo: Payment not received',
            'message' => 'I made a payment but it is not reflected in my account.',
            'status' => 'pending',
        ]);
    }
}
