<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin Ticket Controller
 * Handles all admin-side ticket operations.
 */
class AdminTicketController extends Controller
{
    /**
     * List tickets with filter & search.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'category', 'department', 'assignedTo'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }

        $tickets = $query->paginate(15);

        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $users       = User::all();
        $categories  = Category::all();
        $departments = Department::all();

        return view('admin.tickets.create', compact('users', 'categories', 'departments'));
    }

    /**
     * Store new ticket.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'category_id'   => 'nullable|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'subject'       => 'required|string|max:255',
            'message'       => 'required|string',
            'priority'      => 'required|in:low,medium,high,urgent',
            'status'        => 'required|in:open,in_progress,resolved,pending,closed',
            'assigned_to'   => 'nullable|exists:users,id',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        $attachments = $this->handleFileUploads($request);

        Ticket::create(array_merge($validated, [
            'attachments' => $attachments,
            'created_by' => 'admin',
        ]));

        session()->flash('success', 'Ticket created successfully');
        return redirect()->route('admin.tickets.index');
    }

    /**
     * Show single ticket.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'category', 'department', 'assignedTo', 'replies.user']);

        if ($ticket->is_notified === 0) {
            $ticket->is_notified = true;
            $ticket->save();
        }

        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Show edit form.
     */
    public function edit(Ticket $ticket)
    {
        $users       = User::all();
        $categories  = Category::all();
        $departments = Department::all();

        return view('admin.tickets.edit', compact('ticket', 'users', 'categories', 'departments'));
    }

    /**
     * Update ticket.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'category_id'   => 'nullable|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'subject'       => 'required|string|max:255',
            'message'       => 'required|string',
            'priority'      => 'required|in:low,medium,high,urgent',
            'status'        => 'required|in:open,in_progress,resolved,pending,closed',
            'assigned_to'   => 'nullable|exists:users,id',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        $attachments = $ticket->attachments ?? [];

        if ($request->has('remove_attachments')) {
            foreach ($request->remove_attachments as $filename) {
                Storage::disk('public')->delete('tickets/' . $filename);
                $attachments = array_diff($attachments, [$filename]);
            }
            $attachments = array_values($attachments);
        }

        $newAttachments           = $this->handleFileUploads($request);
        $validated['attachments'] = array_merge($attachments, $newAttachments);

        $ticket->update($validated);

        session()->flash('success', 'Ticket updated successfully');
        return redirect()->route('admin.tickets.index');
    }

    /**
     * Delete ticket.
     */
    public function destroy(Ticket $ticket)
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($ticket->attachments) {
            foreach ($ticket->attachments as $filename) {
                Storage::disk('public')->delete('tickets/' . $filename);
            }
        }

        $ticket->delete();

        session()->flash('success', 'Ticket deleted successfully');
        return redirect()->route('admin.tickets.index');
    }

    /**
     * Upload attachments.
     */
    private function handleFileUploads(Request $request): array
    {
        $attachments = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('tickets', $filename, 'public');
                $attachments[] = $filename;
            }
        }

        return $attachments;
    }

    public function adminNotifications(Request $request) 
    {
        $since = $request->query('since');

        $ticketsQ = Ticket::with('user:id,name')
            ->where('is_notified', 0)
            ->where('created_by', 'user')
            ->when($since, fn($q) => $q->where('updated_at', '>', $since))
            ->latest('updated_at')->limit(20)->get()->map(function ($t) {
            return [
                'type' => 'ticket',
                'ticket_id' => $t->id,
                'subject' => $t->subject,
                'user' => $t->user?->name,
                'created_at' => $t->updated_at->toIso8601String(),
            ];
        });

        return response()->json([
            'events' => $ticketsQ,
            'now' => now()->toIso8601String(),
        ]);
    }
}
