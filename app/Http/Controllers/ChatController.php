<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // List chats
    public function index()
    {
        $user = auth()->user();

        // Regular user
        if ($user->isUser()) {
            $subscription = $user->userSubscriptions()
                ->with('subscriptionPlan')
                ->where('status', 'active')
                ->where('ends_at', '>', now())
                ->first();

            if (!$subscription) {
                return redirect()->route('subscriptions.index')
                    ->with('error', 'Please subscribe to a plan to access live chat support.');
            }

            $plan = $subscription->subscriptionPlan;

            if (!$plan) {
                return redirect()->route('subscriptions.index')
                    ->with('error', 'Your subscription plan is invalid. Please contact support.');
            }

            // Free plan has no chat
            if ($plan->slug === 'free') {
                return redirect()->route('subscriptions.index')
                    ->with('error', 'Your current plan does not include live chat access. Please upgrade to Standard or Gold plan.');
            }

            $messages = ChatMessage::where('user_id', auth()->id())
                ->orderBy('created_at', 'asc')
                ->get();

            $this->migrateMessageAttachmentsToPublic($messages);

            // Mark admin messages as read
            ChatMessage::where('user_id', auth()->id())
                ->where('sender_type', 'admin')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return view('chat.index', compact('messages', 'subscription', 'plan'));
        }

        // Admin user list
        $users = User::where('role', 'user')
            ->whereHas('chatMessages')
            ->withCount(['chatMessages as unread_count' => function ($query) {
                $query->where('is_read', false)->where('sender_type', 'user');
            }])
            ->get();

        return view('admin.chat.index', compact('users'));
    }

    // Admin view single chat
    public function show($userId)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $user = User::findOrFail($userId);
        $messages = ChatMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        $this->migrateMessageAttachmentsToPublic($messages);

        // Mark user messages as read
        ChatMessage::where('user_id', $userId)
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('admin.chat.show', compact('user', 'messages'));
    }

    // Send message
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:5000',
            'user_id' => 'nullable|exists:users,id',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120'
        ]);

        $senderType = auth()->user()->isAdmin() ? 'admin' : 'user';
        $userId = $request->user_id ?? auth()->id();

        $attachments = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('chat', $filename, 'public');
                    $attachments[] = $filename;
                }
            }
        }

        ChatMessage::create([
            'user_id' => $userId,
            'admin_id' => auth()->user()->isAdmin() ? auth()->id() : null,
            'message' => $request->message ?? '',
            'sender_type' => $senderType,
            'is_read' => false,
            'attachments' => !empty($attachments) ? $attachments : null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'attachments' => $attachments
        ]);
    }

    // Poll new messages
    public function getMessages(Request $request)
    {
        $userId = $request->get('user_id') ?? auth()->id();
        $lastId = $request->get('last_id', 0);

        if (!auth()->user()->isAdmin() && $userId != auth()->id()) {
            abort(403);
        }

        $query = ChatMessage::where('user_id', $userId);

        if ($lastId > 0) {
            $query->where('id', '>', $lastId);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        // Normalize attachments
        $messages->transform(function ($message) {
            if ($message->attachments) {
                if (is_string($message->attachments)) {
                    $decoded = json_decode($message->attachments, true);
                    $message->attachments = is_array($decoded) ? $decoded : [];
                } elseif (!is_array($message->attachments)) {
                    $message->attachments = [];
                }
                $message->attachments = array_values(array_filter($message->attachments, function ($att) {
                    return !empty($att) && is_string($att);
                }));

                // Ensure attachments exist on public disk (migrate old path if needed)
                foreach ($message->attachments as $att) {
                    $this->ensurePublicAttachment($att);
                }
            } else {
                $message->attachments = [];
            }
            return $message;
        });

        return response()->json($messages);
    }

    private function ensurePublicAttachment(string $filename): void
    {
        try {
            $publicPath = 'chat/' . $filename;
            if (!\Storage::disk('public')->exists($publicPath)) {
                $legacyFull = storage_path('app/private/public/chat/' . $filename);
                if (file_exists($legacyFull)) {
                    $contents = file_get_contents($legacyFull);
                    \Storage::disk('public')->put($publicPath, $contents);
                }
            }
        } catch (\Throwable $e) {
        }
    }

    private function migrateMessageAttachmentsToPublic($messages): void
    {
        foreach ($messages as $message) {
            $atts = $message->attachments;
            if (is_string($atts)) {
                $atts = json_decode($atts, true) ?: [];
            }
            if (is_array($atts)) {
                foreach ($atts as $att) {
                    if ($att) {
                        $this->ensurePublicAttachment($att);
                    }
                }
            }
        }
    }
}
