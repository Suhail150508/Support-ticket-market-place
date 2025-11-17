<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = [
            [
                'user_id' => 1,
                'category_id' => 1,
                'department_id' => 1,
                'subject' => 'Application crashes on login',
                'message' => 'The application crashes immediately after I enter my credentials. I have tried restarting my computer but the issue persists.',
                'priority' => 'high',
                'status' => 'in_progress',
                'attachments' => json_encode(['screenshot_error.png']),
                'assigned_to' => 2,
                'is_notified' => true,
                'resolved_at' => null,
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'department_id' => 2,
                'subject' => 'Payment declined but amount debited',
                'message' => 'My payment was declined during checkout, but the amount has been debited from my account. Please help me resolve this issue.',
                'priority' => 'urgent',
                'status' => 'open',
                'attachments' => json_encode(['bank_statement.pdf', 'transaction_id.png']),
                'assigned_to' => 1,
                'is_notified' => false,
                'resolved_at' => null,
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'department_id' => 2,
                'subject' => 'How to reset my password?',
                'message' => 'I forgot my password and the reset email is not arriving in my inbox. Can you help?',
                'priority' => 'medium',
                'status' => 'resolved',
                'attachments' => null,
                'assigned_to' => 1,
                'is_notified' => true,
                'resolved_at' => Carbon::now()->subDays(1),
            ],
            
        ];

        foreach ($tickets as $ticket) {
            DB::table('tickets')->insert([
                'user_id' => $ticket['user_id'],
                'category_id' => $ticket['category_id'],
                'department_id' => $ticket['department_id'],
                'subject' => $ticket['subject'],
                'message' => $ticket['message'],
                'priority' => $ticket['priority'],
                'status' => $ticket['status'],
                'attachments' => $ticket['attachments'],
                'assigned_to' => $ticket['assigned_to'],
                'is_notified' => $ticket['is_notified'],
                'resolved_at' => $ticket['resolved_at'],
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now()->subDays(rand(0, 5)),
            ]);
        }
    }
}