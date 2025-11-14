<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // For users - show their chat with admin
        if (auth()->user()->isUser()) {
            $messages = ChatMessage::where('user_id', auth()->id())
                ->orderBy('created_at', 'asc')
                ->get();
            
            // Mark messages as read
            ChatMessage::where('user_id', auth()->id())
                ->where('sender_type', 'admin')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
            
            return view('chat.index', compact('messages'));
        }

        // For admins - show list of users with active chats
        $users = User::where('role', 'user')
            ->whereHas('chatMessages')
            ->withCount(['chatMessages as unread_count' => function($query) {
                $query->where('is_read', false)->where('sender_type', 'user');
            }])
            ->get();
        
        return view('admin.chat.index', compact('users'));
    }

    public function show($userId)
    {
        // Only admins can view specific user chats
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $user = User::findOrFail($userId);
        $messages = ChatMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark user messages as read
        ChatMessage::where('user_id', $userId)
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('admin.chat.show', compact('user', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:5000',
            'user_id' => 'nullable|exists:users,id',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120' // 5MB per image
        ]);

        $senderType = auth()->user()->isAdmin() ? 'admin' : 'user';
        $userId = $request->user_id ?? auth()->id();

        $attachments = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('public/chat', $filename);
                    
                    // Verify file was stored
                    if ($path && file_exists(storage_path('app/' . $path))) {
                        $attachments[] = $filename;
                    }
                }
            }
        }

        $chatMessage = ChatMessage::create([
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

    public function getMessages(Request $request)
    {
        $userId = $request->get('user_id') ?? auth()->id();
        $lastId = $request->get('last_id', 0);
        
        // Check if user can access (admin or own messages)
        if (!auth()->user()->isAdmin() && $userId != auth()->id()) {
            abort(403);
        }

        $query = ChatMessage::where('user_id', $userId);
        
        if ($lastId > 0) {
            $query->where('id', '>', $lastId);
        }
        
        $messages = $query->orderBy('created_at', 'asc')->get();

        // Ensure attachments are properly formatted
        $messages->transform(function ($message) {
            if ($message->attachments) {
                if (is_string($message->attachments)) {
                    $decoded = json_decode($message->attachments, true);
                    $message->attachments = is_array($decoded) ? $decoded : [];
                } elseif (!is_array($message->attachments)) {
                    $message->attachments = [];
                }
                // Filter out null/empty values and re-index
                $message->attachments = array_values(array_filter($message->attachments, function($att) {
                    return !empty($att) && is_string($att);
                }));
            } else {
                $message->attachments = [];
            }
            return $message;
        });

        return response()->json($messages);
    }
}
