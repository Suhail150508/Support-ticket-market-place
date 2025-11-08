<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketReply;
use App\Models\Ticket;
use App\Models\User;

class TicketReplySeeder extends Seeder
{
    public function run()
    {
        $ticket = Ticket::first();
        $admin  = User::where('role', 'admin')->first();
        $user   = User::where('role', 'user')->first();

        if ($ticket && $admin) {
            TicketReply::create([
                'ticket_id' => $ticket->id,
                'user_id' => $admin->id,
                'message' => 'Hello, we are looking into your issue. Please provide any screenshots if available.',
            ]);
        }

        if ($ticket && $user) {
            TicketReply::create([
                'ticket_id' => $ticket->id,
                'user_id' => $user->id,
                'message' => 'Thanks, I have attached a screenshot. Please check.',
            ]);
        }
    }
}
