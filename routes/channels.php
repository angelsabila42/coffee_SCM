<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $conversation = \App\Models\Conversation::find($conversationId);
    if (!$conversation) return false;
    
    // Only allow users who are part of the conversation
    return $conversation->user_one_id === $user->id || $conversation->user_two_id === $user->id;
});
