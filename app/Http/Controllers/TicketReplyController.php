<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TicketReplyController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        // ensure user can reply: owner or admin
        if ($ticket->user_id !== auth()->id() && auth()->user()->role !== 'admin') abort(403);


        $request->validate(['message' => 'required|string']);


        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);


        // update status
        if (auth()->user()->role === 'admin') {
            $ticket->update(['status' => 'pending']);
        } else {
            $ticket->update(['status' => 'open']);
        }

        if ($ticket->user_id !== auth()->id()) {
            $ticket->is_notified = false;
            $ticket->save();
        }

        session()->flash('success', 'Reply added');
        return back();
    }
    
    public function getAIReplySuggestions(Request $request)
    {
        $request->validate([
            'ticket_id' => ['required','integer','exists:tickets,id'],
        ]);

        $ticket = Ticket::with(['category:id,name','department:id,name','replies' => function($q){ $q->latest()->limit(5); }])->find($request->ticket_id);

        $fallback = [
            'Thank you for the details. Could you share any recent changes before the issue started?',
            'Please provide steps to reproduce the issue so we can investigate.',
            'Can you attach a screenshot or the exact error message you see?',
            'Have you tried clearing cache or restarting the application/device?',
            'What is the expected behavior and what are you observing instead?',
        ];

        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            return response()->json(['suggestions' => $fallback]);
        }

        try {
            $category = $ticket->category?->name ?? 'General';
            $dept = $ticket->department?->name ?? 'N/A';
            $recentReplies = $ticket->replies->pluck('message')->map(fn($m) => Str::limit($m, 200))->implode("\n- ");
            $context = "Subject: {$ticket->subject}\nCategory: {$category}\nDepartment: {$dept}\nMessage: " . Str::limit($ticket->message, 500);
            if ($recentReplies) {
                $context .= "\nRecent Replies:\n- {$recentReplies}";
            }

            $client = \OpenAI::client($apiKey);
            $prompt = 'Based on the ticket context below, suggest 5 short, helpful reply prompts/questions the support agent or user could send next. Return ONLY a JSON array of strings.\n\n' . $context;
            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'Generate helpful, concise reply prompts. Return strictly a JSON array of strings.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);
            $content = $response->choices[0]->message->content ?? '';
            $parsed = json_decode($content, true);
            if (is_array($parsed) && !empty($parsed)) {
                return response()->json(['suggestions' => array_values($parsed)]);
            }
        } catch (\Throwable $e) {
        }

        return response()->json(['suggestions' => $fallback]);
    }
    
}
