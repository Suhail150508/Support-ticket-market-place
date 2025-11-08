<?php

namespace App\Http\Controllers;


use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;


class TicketReplyController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


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

        session()->flash('success', 'Reply added');
        return back();
    }
    
}
