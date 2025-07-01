<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with(['participant', 'messages.sender'])
            ->where('admin_id', Auth::id())
            ->orWhere(function($query) {
                $query->where('participant_id', Auth::id())
                      ->where('participant_type', User::class);
            })
            ->get();
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat', compact('conversations', 'users'));
    }

    public function show($conversationId)
    {
        $conversation = Conversation::with(['participant', 'messages.sender'])
            ->where('id', $conversationId)
            ->where(function($query) {
                $query->where('admin_id', Auth::id())
                      ->orWhere(function($q) {
                          $q->where('participant_id', Auth::id())
                            ->where('participant_type', User::class);
                      });
            })
            ->firstOrFail();

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $conversations = Conversation::with(['participant', 'messages.sender'])
            ->where('admin_id', Auth::id())
            ->orWhere(function($query) {
                $query->where('participant_id', Auth::id())
                      ->where('participant_type', User::class);
            })
            ->get();
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat', compact('conversations', 'conversation', 'users'));
    }

    public function store(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $conversation = Conversation::where('id', $conversationId)
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('admin_id', Auth::id());
                })->orWhere(function($q) {
                    $q->where('participant_id', Auth::id())
                      ->where('participant_type', User::class);
                });
            })
            ->first();

        if (!$conversation) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Conversation not found or you do not have access.'], 404);
            }
            return abort(404, 'Conversation not found or you do not have access.');
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'sender_type' => User::class,
            'message' => $request->message
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message_html' => view('partials.message', ['message' => $message])->render(),
                'message_id' => $message->id
            ]);
        }

        return redirect()->route('chat.show', $conversationId);
    }

    public function getMessages($conversationId)
    {
        $conversation = Conversation::with(['messages.sender'])
            ->where('id', $conversationId)
            ->where(function($query) {
                $query->where('admin_id', Auth::id())
                      ->orWhere(function($q) {
                          $q->where('participant_id', Auth::id())
                            ->where('participant_type', User::class);
                      });
            })
            ->firstOrFail();

        return response()->json([
            'messages' => $conversation->messages->map(function($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender->name,
                    'sender_avatar' => $message->sender->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($message->sender->name) . '&background=8B4513&color=fff',
                    'created_at' => $message->created_at->format('H:i'),
                    'read_at' => $message->read_at,
                    'is_own' => $message->sender_id == Auth::id()
                ];
            })
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|exists:users,id',
        ]);

        // Check if conversation already exists
        $existing = Conversation::where(function($q) use ($request) {
            $q->where('admin_id', Auth::id())
              ->where('participant_id', $request->participant_id)
              ->where('participant_type', User::class);
        })->orWhere(function($q) use ($request) {
            $q->where('admin_id', $request->participant_id)
              ->where('participant_id', Auth::id())
              ->where('participant_type', User::class);
        })->first();

        if ($existing) {
            return redirect()->route('chat.show', $existing->id);
        }

        $conversation = Conversation::create([
            'admin_id' => Auth::id(),
            'participant_id' => $request->participant_id,
            'participant_type' => User::class,
        ]);

        // Send a welcome message to avoid empty chat errors
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'sender_type' => User::class,
            'message' => 'Welcome to GlobalBean Connect. How may I help you today?'
        ]);

        session()->flash('chat_created', 'Conversation started!');
        return redirect()->route('chat.show', $conversation->id);
    }
}
