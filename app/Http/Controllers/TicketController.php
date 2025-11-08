<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller 
{
    public function index()
    {
        $tickets = auth()->user()->tickets()->latest()->paginate(10);
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = Category::all();
        $departments = Department::all();

        return view('tickets.create', compact('categories', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'category_id' => 'nullable|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->storeAs('tickets', $filename, 'public');
                $attachments[] = $filename;
            }
        }

        Ticket::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority ?? 'low',
            'status' => 'open',
            'attachments' => json_encode($attachments),
        ]);

        session()->flash('success', '🎫 Ticket created successfully!');
        return redirect()->route('tickets.index');
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $ticket->load('replies.user');
        return view('tickets.show', compact('ticket'));
    }

    // ✅ Edit ticket
    public function edit(Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $categories = Category::all();
        $departments = Department::all();

        // Decode attachments for display
        $ticket->attachments = json_decode($ticket->attachments, true);

        return view('tickets.edit', compact('ticket', 'categories', 'departments'));
    }

    // ✅ Update ticket
    public function update(Request $request, Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'category_id' => 'nullable|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $existingAttachments = json_decode($ticket->attachments, true) ?? [];
        $newAttachments = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->storeAs('tickets', $filename, 'public');
                $newAttachments[] = $filename;
            }
        }

        // Merge old and new attachments
        $allAttachments = array_merge($existingAttachments, $newAttachments);

        $ticket->update([
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority ?? 'low',
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'attachments' => json_encode($allAttachments),
        ]);

        session()->flash('success', '🎫 Ticket updated successfully!');
        return redirect()->route('tickets.show', $ticket->id);
    }

    public function adminIndex()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $tickets = Ticket::latest()->paginate(15);
        $allTickets = Ticket::all();
        return view('admin.dashboard', compact('tickets', 'allTickets'));
    }

    public function changeStatus(Request $request, Ticket $ticket)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate(['status' => 'required|in:open,pending,closed']);
        $ticket->update(['status' => $request->status]);

        session()->flash('success', 'Ticket status updated');
        return back();
    }

    public function destroy(Ticket $ticket)
    {
        if (auth()->user()->role !== 'admin' && $ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $ticket->delete();
        session()->flash('success', 'Ticket deleted');
        return back();
    }
}
