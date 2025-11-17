<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Provides full CRUD for user tickets plus admin utilities.
 * No business logic changed; only formatting & comments added.
 */
class TicketController extends Controller
{
    /* -------------------- User-facing routes -------------------- */

    /**
     * User dashboard: all tickets + 10 most recent.
     */
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

    /**
     * Paginated list of the authenticated user’s tickets.
     */
    public function index()
    {
        $tickets = auth()->user()
            ->tickets()
            ->latest()
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show ticket creation form.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();

        return view('tickets.create', compact('categories', 'departments'));
    }

    /**
     * Store a new ticket with optional file attachments.
     */
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

    /**
     * Display a single ticket with its replies.
     */
    public function show(Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $ticket->load(['replies' => function ($query) {
            $query->latest()->with('user:id,name,email');
        }]);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show ticket edit form.
     */
    public function edit(Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $categories = Category::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();

        return view('tickets.edit', compact('ticket', 'categories', 'departments'));
    }

    /**
     * Update ticket details and attachments.
     */
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

        // Existing files
        $existingAttachments = $ticket->attachments ?? [];

        // Remove unchecked files
        if ($request->has('remove_attachments')) {
            foreach ($request->remove_attachments as $filename) {
                Storage::disk('public')->delete('tickets/' . $filename);
                $existingAttachments = array_diff($existingAttachments, [$filename]);
            }
        }

        // Merge new uploads
        $newAttachments = $this->handleFileUploads($request);
        $allAttachments = array_merge(array_values($existingAttachments), $newAttachments);

        $ticket->update([
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'priority' => $validated['priority'] ?? 'low',
            'category_id' => $validated['category_id'] ?? null,
            'department_id' => $validated['department_id'] ?? null,
            'attachments' => $allAttachments,
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully!');
    }

    /* -------------------- Admin routes -------------------- */

    /**
     * Admin dashboard with ticket statistics.
     */
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

    /**
     * Quick status change (ajax-friendly).
     */
    public function changeStatus(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,pending,closed',
        ]);

        $ticket->update(['status' => $validated['status']]);

        return back()->with('success', 'Ticket status updated');
    }

    /**
     * Soft-delete ticket and clean up files.
     */
    public function destroy(Ticket $ticket)
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $ticket->user_id !== $user->id) {
            abort(403);
        }

        if ($ticket->attachments) {
            foreach ($ticket->attachments as $filename) {
                Storage::disk('public')->delete('tickets/' . $filename);
            }
        }

        $ticket->delete();

        return back()->with('success', 'Ticket deleted');
    }

    /* -------------------- Helper methods -------------------- */

    /**
     * Ensure only owners or admins access a ticket.
     */
    private function authorizeTicketAccess(Ticket $ticket): void
    {
        $user = auth()->user();

        if ($ticket->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Unauthorized access to ticket');
        }
    }

    /**
     * Handle multiple file uploads; returns array of stored filenames.
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

    /* -------------------- AI suggestion endpoints -------------------- */

    /**
     * Legacy endpoint: suggest questions by category id.
     */
    public function suggestQuestions(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        $category = Category::find($request->category_id);

        return $this->fetchAiSuggestions($category);
    }

    /**
     * Unified endpoint: suggest questions by id or name.
     */
    public function getAISuggestions(Request $request)
    {
        $categoryId = $request->input('category_id');
        $categoryName = $request->input('category');

        $category = null;
        if ($categoryId) {
            $category = Category::find($categoryId);
        } elseif ($categoryName) {
            $category = Category::where('name', $categoryName)->first();
        }

        return $this->fetchAiSuggestions($category);
    }

    /**
     * Centralized AI suggestion logic.
     */
    private function fetchAiSuggestions($category)
    {
        $fallback = [
            'Please describe the issue in detail.',
            'What steps have you already tried?',
            'Share any error messages or screenshots.',
            'What is the expected behavior vs actual?',
            'When did the issue start occurring?',
        ];

        if (!$category) {
            return response()->json(['suggestions' => $fallback]);
        }

        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            return response()->json(['suggestions' => $fallback]);
        }

        try {
            $client = \OpenAI::client($apiKey);

            $prompt = 'Suggest 5 concise support ticket question prompts for the category "' . $category->name . '". Return ONLY a JSON array of strings.';
            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'You generate helpful, short ticket prompts. Return strictly a JSON array of strings.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $content = $response->choices[0]->message->content ?? '';
            $parsed = json_decode($content, true);

            if (is_array($parsed) && !empty($parsed)) {
                return response()->json(['suggestions' => array_values($parsed)]);
            }
        } catch (\Throwable $e) {
            // Silently fall back
        }

        return response()->json(['suggestions' => $fallback]);
    }

    public function generateTicketContent(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:prompt,refine',
            'text' => 'required|string',
        ]);

        $apiKey = env('OPENAI_API_KEY');
        $fallback = [
            'title' => 'Support Request',
            'description' => trim($request->text),
        ];

        if (!$apiKey) {
            return response()->json($fallback);
        }

        try {
            $client = \OpenAI::client($apiKey);
            $sys = 'You are a ticket composer. Output a JSON object with keys "title" and "description" only. Title must be concise and professional. Description must be a refined, complete explanation. Do not echo the original text verbatim.';
            $user = $request->mode === 'prompt'
                ? ('Create a ticket title and description from this short prompt: ' . $request->text)
                : ('Refine this user-written ticket into a professional title and description: ' . $request->text);
            $res = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    ['role' => 'system', 'content' => $sys],
                    // Few-shot example to steer outputs
                    ['role' => 'user', 'content' => 'Compose from prompt: Internet not working properly'],
                    ['role' => 'assistant', 'content' => json_encode([
                        'title' => 'Internet Connection Issue',
                        'description' => 'The user is reporting problems with their internet service, including slow speeds and frequent connection drops.'
                    ])],
                    ['role' => 'user', 'content' => $user],
                ],
            ]);
            $content = $res->choices[0]->message->content ?? '';
            $parsed = json_decode($content, true);
            if (!is_array($parsed) || !isset($parsed['title']) || !isset($parsed['description'])) {
                if (preg_match('/\{[\s\S]*\}/', $content, $m)) {
                    $parsed = json_decode($m[0], true) ?: [];
                }
            }
            if (is_array($parsed) && isset($parsed['title']) && isset($parsed['description'])) {
                return response()->json([
                    'title' => strip_tags($parsed['title']),
                    'description' => strip_tags($parsed['description']),
                ]);
            }
        } catch (\Throwable $e) {
        }

        return response()->json($fallback);
    }
}