<?php

namespace App\Http\Controllers;

use App\Models\conversation;
use App\Models\Message;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $conversations = Conversation::with(['userOne', 'userTwo', 'messages.sender'])
            ->where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->get();

        $users = User::where('id', '!=', $userId)
            ->orderBy('role')
            ->orderBy('name')
            ->get()
            ->groupBy('role');

        return view('chat', compact('conversations', 'users'));
    }

    public function show($conversationId)
    {
        $userId = Auth::id();
        $conversation = Conversation::with(['userOne', 'userTwo', 'messages.sender'])
            ->where('id', $conversationId)
            ->where(function($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->orWhere('user_two_id', $userId);
            })
            ->firstOrFail();

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $conversations = Conversation::with(['userOne', 'userTwo', 'messages.sender'])
            ->where(function($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->orWhere('user_two_id', $userId);
            })
            ->get();

        $users = User::where('id', '!=', $userId)
            ->orderBy('role')
            ->orderBy('name')
            ->get()
            ->groupBy('role');

        return view('chat', compact('conversations', 'conversation', 'users'));
    }

    public function store(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userId = Auth::id();

        $conversation = Conversation::where('id', $conversationId)
            ->where(function($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->orWhere('user_two_id', $userId);
            })
            ->firstOrFail();

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'message' => $request->message
        ]);

        // Broadcast the message event
        broadcast(new \App\Events\MessageSent($message))->toOthers();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $message->message,
                'message_id' => $message->id,
                'created_at' => $message->created_at->format('H:i'),
                'sender_id' => $userId
            ]);
        }

        return redirect()->back();
    }

    public function getMessages($conversationId)
    {
        $userId = Auth::id();
        $conversation = Conversation::with(['messages.sender'])
            ->where('id', $conversationId)
            ->where(function($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->orWhere('user_two_id', $userId);
            })
            ->firstOrFail();

        return response()->json([
            'messages' => $conversation->messages->map(function($message) use ($userId) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender->name,
                    'sender_avatar' => $message->sender->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($message->sender->name) . '&background=007bff&color=fff',
                    'created_at' => $message->created_at->format('H:i'),
                    'read_at' => $message->read_at,
                    'is_own' => $message->sender_id == $userId
                ];
            })
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|exists:users,id',
        ]);

        $userId = Auth::id();
        $participantId = $request->participant_id;

        // Check if conversation already exists (regardless of order)
        $existing = Conversation::where(function($q) use ($userId, $participantId) {
            $q->where('user_one_id', $userId)
              ->where('user_two_id', $participantId);
        })->orWhere(function($q) use ($userId, $participantId) {
            $q->where('user_one_id', $participantId)
              ->where('user_two_id', $userId);
        })->first();

        if ($existing) {
            return redirect()->route('chat.show', $existing->id);
        }

        $conversation = Conversation::create([
            'user_one_id' => $userId,
            'user_two_id' => $participantId,
        ]);

        // Optionally, send a welcome message
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'message' => 'Welcome to GlobalBean Connect. How may I help you today?'
        ]);

        session()->flash('chat_created', 'Conversation started!');

        ActivityLogger::log(
            title: 'Message sent',
            type:'new-message '
        );
        
        return redirect()->route('chat.show', $conversation->id);
    }

    public function start($participantId)
    {
        $userId = Auth::id();

        // Check if conversation already exists (regardless of order)
        $existing = Conversation::where(function($q) use ($userId, $participantId) {
            $q->where('user_one_id', $userId)
              ->where('user_two_id', $participantId);
        })->orWhere(function($q) use ($userId, $participantId) {
            $q->where('user_one_id', $participantId)
              ->where('user_two_id', $userId);
        })->first();

        if ($existing) {
            return redirect()->route('chat.show', $existing->id);
        }

        $conversation = Conversation::create([
            'user_one_id' => $userId,
            'user_two_id' => $participantId,
        ]);

        // Optionally, send a welcome message
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'message' => 'Welcome to GlobalBean Connect. How may I help you today?'
        ]);

        return redirect()->route('chat.show', $conversation->id);
    }

    public function markAsRead(Request $request, $conversationId)
    {
        $userId = Auth::id();
        $conversation = Conversation::findOrFail($conversationId);
        
        // Only mark messages as read if user is part of the conversation
        if ($conversation->user_one_id == $userId || $conversation->user_two_id == $userId) {
            $updated = Message::where('conversation_id', $conversationId)
                ->where('sender_id', '!=', $userId)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
            
            if ($updated > 0) {
                broadcast(new \App\Events\MessageRead($conversationId, $userId))->toOthers();
            }
            
            return response()->json(['success' => true, 'updated' => $updated]);
        }
        
        return response()->json(['success' => false], 403);
    }
}
