<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTicketController extends Controller
{
    // Uncomment this if you have admin middleware
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'is_admin']);
    // }

    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'category', 'department', 'assignedTo'])->latest();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search by ID, subject, or message
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('subject', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%')
                  ->orWhere('id', $request->search);
            });
        }

        $tickets = $query->paginate(15);

        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        $departments = Department::all();

        return view('admin.tickets.create', compact('users', 'categories', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:open,in_progress,resolved,pending,closed',
            'assigned_to' => 'nullable|exists:users,id',
            'attachments.*' => 'nullable|file|max:5120', // 5MB per file
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/tickets', $filename);
                $attachments[] = $filename;
            }
        }

        Ticket::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
            'attachments' => $attachments ? json_encode($attachments) : null,
        ]);

        session()->flash('success', 'Ticket created successfully');
        return redirect()->route('admin.tickets.index');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'category', 'department', 'assignedTo', 'replies.user']);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $users = User::all();
        $categories = Category::all();
        $departments = Department::all();

        return view('admin.tickets.edit', compact('ticket', 'users', 'categories', 'departments'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:open,in_progress,resolved,pending,closed',
            'assigned_to' => 'nullable|exists:users,id',
            'attachments.*' => 'nullable|file|max:5120', // 5MB per file
        ]);

        $attachments = $ticket->attachments ? json_decode($ticket->attachments, true) : [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/tickets', $filename);
                $attachments[] = $filename;
            }
        }

        $ticket->update([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
            'attachments' => $attachments ? json_encode($attachments) : null,
        ]);

        session()->flash('success', 'Ticket updated successfully');
        return redirect()->route('admin.tickets.index');
    }

    public function destroy(Ticket $ticket)
    {
        // Delete attachments from storage
        if ($ticket->attachments) {
            foreach (json_decode($ticket->attachments) as $file) {
                Storage::delete('public/tickets/' . $file);
            }
        }

        $ticket->delete();
        session()->flash('success', 'Ticket deleted successfully');
        return redirect()->route('admin.tickets.index');
    }
}
