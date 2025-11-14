<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller 
{

    public function dashboard()
    {
        $user = auth()->user();
        $allTickets = $user->tickets;
        $recentTickets = $user->tickets()
            ->latest()
            ->limit(10)
            ->get();
            
        return view('user.dashboard', compact('allTickets', 'recentTickets'));
    }

    public function index()
    {
        $tickets = auth()->user()
            ->tickets()
            ->latest()
            ->paginate(10);
            
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();

        return view('tickets.create', compact('categories', 'departments'));
    }

 public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'category_id' => 'nullable|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);
        
        $attachments = $this->handleFileUploads($request);
        
        Ticket::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'] ?? null,
            'department_id' => $validated['department_id'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'priority' => $validated['priority'] ?? 'low',
            'status' => 'open',
            'attachments' => $attachments,
        ]);
        
        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket created successfully!');
    }
    public function show(Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $ticket->load(['replies' => function ($query) {
            $query->latest()->with('user:id,name,email');
        }]);
        
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $categories = Category::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();

        return view('tickets.edit', compact('ticket', 'categories', 'departments'));
    }

  public function update(Request $request, Ticket $ticket)
{
    $this->authorizeTicketAccess($ticket);

    $validated = $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'priority' => 'nullable|in:low,medium,high,urgent',
        'category_id' => 'nullable|exists:categories,id',
        'department_id' => 'nullable|exists:departments,id',
        'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        'remove_attachments' => 'nullable|array',
        'remove_attachments.*' => 'string',
    ]);

    // Get existing attachments (the cast handles JSON decoding automatically)
    $existingAttachments = $ticket->attachments ?? [];
    
    // Remove selected attachments
    if ($request->has('remove_attachments')) {
        foreach ($request->remove_attachments as $filename) {
            Storage::disk('public')->delete('tickets/' . $filename);
            $existingAttachments = array_diff($existingAttachments, [$filename]);
        }
    }

    // Add new attachments
    $newAttachments = $this->handleFileUploads($request);
    $allAttachments = array_merge(array_values($existingAttachments), $newAttachments);

    $ticket->update([
        'subject' => $validated['subject'],
        'message' => $validated['message'],
        'priority' => $validated['priority'] ?? 'low',
        'category_id' => $validated['category_id'] ?? null,
        'department_id' => $validated['department_id'] ?? null,
        'attachments' => $allAttachments, // The cast handles JSON encoding automatically
    ]);

    return redirect()
        ->route('tickets.show', $ticket)
        ->with('success', ' Ticket updated successfully!');
}

    public function adminIndex()
    {
        $tickets = Ticket::with(['user:id,name,email', 'category:id,name', 'department:id,name'])
            ->latest()
            ->paginate(15);
            
        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'pending' => Ticket::where('status', 'pending')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
        ];
        
        return view('admin.dashboard', compact('tickets', 'stats'));
    }

    public function changeStatus(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,pending,closed'
        ]);
        
        $ticket->update(['status' => $validated['status']]);

        return back()->with('success', 'Ticket status updated');
    }

    public function destroy(Ticket $ticket)
    {
        $user = auth()->user();
        
        if ($user->role !== 'admin' && $ticket->user_id !== $user->id) {
            abort(403);
        }

        // Delete associated files
        if ($ticket->attachments) {
            foreach ($ticket->attachments as $filename) {
                Storage::disk('public')->delete('tickets/' . $filename);
            }
        }

        $ticket->delete();
        
        return back()->with('success', 'Ticket deleted');
    }

    // Helper Methods
    private function authorizeTicketAccess(Ticket $ticket): void
    {
        $user = auth()->user();
        
        if ($ticket->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Unauthorized access to ticket');
        }
    }

   
    private function handleFileUploads(Request $request)
    {
        $attachments = [];
        
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Store in storage/app/public/tickets/
                $file->storeAs('tickets', $filename, 'public');
                
                // Add filename to array
                $attachments[] = $filename;
            }
        }
        
        return $attachments;
    }
}