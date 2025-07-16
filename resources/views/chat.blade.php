@extends('layouts.app')
@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Collection;
@endphp

@section('sidebar-items')
    @includeIf('layouts.sidebar-items.' . auth()->user()->role)
@endsection

@section('content')
<style>
:root {
    --coffee-brown: #8B5E3C;
    --sidebar-bg: #f4f3f1;
    --sidebar-active: #e9e5e1;
    --chat-bg: #fff;
    --bubble-in: #f4f3f1;
    --bubble-out: #e9e5e1;
}
/* Base layout styles */
body, html {
    height: 100%;
    margin: 0;
    padding: 0;
}

.main-chat-wrapper {
    height: calc(100vh - 65px);
    display: flex;
    background: var(--sidebar-bg);
}

.chat-sidebar {
    background: var(--sidebar-bg);
    border-right: 1px solid #e0e0e0;
    display: flex;
    flex-direction: column;
    width: 300px;
    min-width: 300px;
}

.contact-list {
    flex: 1 1 auto;
    overflow-y: auto;
    padding: 0 0.5rem 1rem 0.5rem;
}

.chat-main {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    background: #fff;
}

.chat-body {
    flex: 1 1 auto;
    overflow-y: auto;
    padding: 2rem 2rem 1rem 2rem;
    background: #f7f6f4;
}

.chat-footer {
    padding: 0.5rem 1rem;
    border-top: 1px solid #eee;
    background: #fff;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Sidebar styles */
.sidebar-header {
    padding: 2rem 1rem 1rem 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    background: var(--sidebar-bg);
}
.sidebar-header .avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    margin-bottom: 1rem;
    border: 2px solid var(--coffee-brown);
}
.sidebar-nav {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
}
.sidebar-nav .icon-btn {
    background: none;
    border: none;
    color: var(--coffee-brown);
    font-size: 1.5rem;
    transition: color 0.2s;
}
.sidebar-nav .icon-btn.active, .sidebar-nav .icon-btn:hover {
    color: #fff;
    background: var(--coffee-brown);
    border-radius: 50%;
    padding: 0.5rem;
}
.sidebar-search {
    padding: 0 1rem 1rem 1rem;
}
.sidebar-search input {
    border-radius: 2rem;
    border: 1px solid #ddd;
    padding-left: 2.5rem;
}
.sidebar-search .fa-search {
    position: absolute;
    left: 2rem;
    top: 1.2rem;
    color: #bbb;
}
.contact-list {
    flex: 1 1 auto;
    overflow-y: auto;
    padding: 0 0.5rem 1rem 0.5rem;
    min-height: 0; /* Allow shrinking */
    margin-bottom: 1rem;
}
.contact-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1rem;
    border-radius: 1rem;
    margin-bottom: 0.5rem;
    background: #fff;
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s;
    border: 2px solid transparent;
}
.contact-item.active, .contact-item:hover {
    background: var(--sidebar-active);
    border-color: var(--coffee-brown);
    box-shadow: 0 2px 8px rgba(139,94,60,0.08);
}
.contact-item .avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 1.5px solid #e0e0e0;
}
.contact-item .contact-info {
    flex: 1 1 auto;
    min-width: 0;
}
.contact-item .contact-info .name {
    font-weight: 600;
    color: #222;
    font-size: 1rem;
    margin-bottom: 0.1rem;
}
.contact-item .contact-info .last-message {
    color: #888;
    font-size: 0.95rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.contact-item .badge {
    background: var(--coffee-brown);
    color: #fff;
    font-size: 0.8rem;
    border-radius: 0.5rem;
    padding: 0.2rem 0.6rem;
}

/* Chat area */
.chat-main {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    height: 100%;
    background: #fff;
    position: relative;
}
.chat-header {
    flex-shrink: 0;
    padding: 1rem;
    border-bottom: 1px solid #eee;
    background: #fff;
    z-index: 10;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.chat-header .avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: 2px solid var(--coffee-brown);
    flex-shrink: 0;
}
.chat-header .name {
    font-weight: 700;
    font-size: 1.15rem;
    color: #222;
    margin: 0;
}
.chat-header .status {
    font-size: 0.95rem;
    color: #4caf50;
    margin-left: 0.5rem;
}
.chat-header .role-badge {
    background: var(--coffee-brown);
    color: #fff;
    font-size: 0.85rem;
    border-radius: 0.5rem;
    padding: 0.2rem 0.7rem;
    margin-left: 0.7rem;
}
.chat-header .header-actions {
    margin-left: auto;
    display: flex;
    gap: 1rem;
}
.chat-header .header-actions .icon-btn {
    background: none;
    border: none;
    color: #bbb;
    font-size: 1.3rem;
    transition: color 0.2s;
}
.chat-header .header-actions .icon-btn:hover {
    color: var(--coffee-brown);
}

.chat-body {
    flex: 1 1 auto;
    overflow-y: auto;
    padding: 2rem 2rem 1rem 2rem;
    background: #f7f6f4;
}

.message-row {
    display: flex;
    margin-bottom: 1.2rem;
    opacity: 1 !important;
    transition: opacity 0.2s ease-in;
    will-change: opacity;
}
.message-row.own {
    justify-content: flex-end;
}
.message-bubble {
    max-width: 60%;
    padding: 0.9rem 1.2rem;
    border-radius: 1.2rem;
    font-size: 1rem;
    background: var(--bubble-in);
    color: #222;
    box-shadow: 0 1px 4px rgba(139,94,60,0.04);
    position: relative;
}
.message-row.own .message-bubble {
    background: var(--coffee-brown);
    color: #fff;
    border-bottom-right-radius: 0.3rem;
}
.message-row:not(.own) .message-bubble {
    background: #fff;
    color: #222;
    border-bottom-left-radius: 0.3rem;
}
.message-meta {
    font-size: 0.85rem;
    color: #aaa;
    margin-top: 0.3rem;
    text-align: right;
}

.chat-footer {
    flex-shrink: 0;
    padding: 0.5rem 1rem;
    border-top: 1px solid #eee;
    background: #fff;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Style adjustments for the message input area */
.message-input-wrapper {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.message-input {
    flex: 1;
    min-height: 45px;
    max-height: 120px;
    padding: 0.75rem;
    border: 1px solid #e0e0e0;
    border-radius: 0.5rem;
    resize: none;
    overflow-y: auto;
}

.send-button {
    flex-shrink: 0;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: var(--coffee-brown) !important;
    color: white !important;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s;
}

.send-button:hover {
    background-color: #6d4327;
}

/* Add styles for the sidebar footer */
.sidebar-footer {
    flex-shrink: 0;
    padding: 1rem;
    background: var(--sidebar-bg);
    border-top: 1px solid #eee;
    position: sticky;
    bottom: 0;
    width: 100%;
    z-index: 10;
}

@media (max-width: 900px) {
    .chat-header, .chat-footer, .chat-body {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
<div class="main-chat-wrapper d-flex">
    <!-- Sidebar -->
    <div class="chat-sidebar col-12 col-md-4 col-lg-3 p-0">
        <div class="d-flex align-items-center justify-content-between px-3 py-3" style="background: var(--sidebar-bg);">
            <span class="fw-bold" style="font-size: 2rem; color: #222;">Chats</span>
            
        </div>
       
         <div class="sidebar-search position-relative">
            
            <input type="text" class="form-control" placeholder="Search..." id="searchInput">
        </div>
       
        <div class="contact-list flex-grow-1">
            @foreach($users as $role => $roleUsers)
                <div class="role-group mb-3">
                    <div class="role-header px-3 py-2 text-uppercase" style="font-size: 0.8rem; font-weight: 600; color: #666;">
                        {{ $role == 'supplier' ? 'Importers' : str_replace('_', ' ', $role) . 's' }}
                    </div>
                    @foreach($roleUsers as $user)
                        @php
                            $conv = collect($conversations)->first(function($c) use ($user) {
                                return $c->user_one_id == $user->id || $c->user_two_id == $user->id;
                            });
                            $isActive = isset($conversation) && $conv && $conversation->id === $conv->id;
                        @endphp
                        <a href="{{ $conv ? route('chat.show', $conv->id) : route('chat.start', $user->id) }}"
                           class="contact-item {{ $isActive ? 'active' : '' }} conversation-item"
                           data-conversation-name="{{ $user->name }}">
                    <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=8B5E3C&color=fff' }}" class="avatar" alt="{{ $user->name }}">
                    <div class="contact-info">
                        <div class="name">{{ $user->name }}</div>
                        <div class="last-message">
                            @if($conv && $conv->messages->last())
                                {{ $conv->messages->last()->sender_id == auth()->id() ? 'You: ' : '' }}
                                  {{ Str::limit($conv->messages->last()->message, 30) }}
                            @else
                                <em>No conversation yet</em>
                            @endif
                        </div>
                    </div>
                    @if(isset($user->role))
                        <span class="badge">{{ $user->role }}</span>
                    @endif
                </a>
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="p-3">
            <button class="btn w-100" style="background: var(--coffee-brown); color: #fff; border-radius: 2rem;" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                <i class="fas fa-plus me-2"></i>Start New Conversation
            </button>
        </div>
    </div>
    <!-- Chat Area -->
    <div class="chat-main col-12 col-md-8 col-lg-9 p-0 d-flex flex-column">
        @if(isset($conversation))
            @php
                $otherUser = $conversation->user_one_id == auth()->id() ? $conversation->userTwo : $conversation->userOne;
            @endphp
            <div class="chat-header">
                <img src="{{ $otherUser->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($otherUser->name) . '&background=8B5E3C&color=fff' }}" class="avatar" alt="User">
                <span class="name">{{ $otherUser->name }}</span>
                <span class="role-badge text-capitalize">{{ $otherUser->role == 'supplier' ? 'Importer' : $otherUser->role ?? 'Partner' }}</span>
                <span class="status"><i class="fas fa-circle"></i> Online</span>
               
            </div>
            <div class="chat-body flex-grow-1" id="messagesContainer">
                @forelse($conversation->messages as $message)
                    <div class="message-row {{ $message->sender_id == auth()->id() ? 'own' : '' }}">
                        <div class="message-bubble">
                            {{ $message->message }}
                            <div class="message-meta">
                                {{ $message->created_at->setTimezone('Africa/Nairobi')->format('H:i') }}
                                @if($message->sender_id == auth()->id())
                                    {!! $message->read_at ? '<i class="fas fa-check-double text-success"></i>' : '<i class="fas fa-check text-secondary"></i>' !!}
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-comments fa-3x mb-3"></i>
                        <h5>No messages yet</h5>
                        <p>Start the conversation by sending a message below</p>
                    </div>
                @endforelse
            </div>
            <div class="chat-footer">
                <form action="{{ route('chat.store', $conversation->id) }}" method="POST" id="messageForm" class="d-flex w-100 align-items-center gap-2">
                    @csrf
                    <textarea name="message" class="form-control" placeholder="Type your message here" rows="1" id="messageInput" required></textarea>
                    <button type="submit" class="send-button"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        @else
            <div class="welcome-container" style="background: #f7f6f4; height: 100%; display: flex; align-items: center; justify-content: center; padding: 2rem;">
                <div class="text-center">
                    <i class="fas fa-comments fa-5x" style="color: var(--coffee-brown); display: block; margin-bottom: 2rem;"></i>
                    <h1 style="color: #222; font-size: 2.5rem; margin-bottom: 1.5rem;">Welcome to GlobalBean Connect Chat</h1>
                    <p style="font-size: 1.2rem; color: #666; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">Select a conversation from the sidebar to start chatting with your supply chain partners.</p>
                    <button class="btn btn-lg" style="background: var(--coffee-brown); color: #fff; border-radius: 2rem; padding: 1rem 2rem; font-size: 1.1rem;" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                        <i class="fas fa-plus me-2"></i>Start New Conversation
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal for New Conversation -->
<div class="modal fade" id="newConversationModal" tabindex="-1" aria-labelledby="newConversationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newConversationModalLabel">Start New Conversation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('chat.create') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="participant" class="form-label">Select User</label>
            <select class="form-select" id="participant" name="participant_id" required>
              <option value="">Choose a user...</option>
              @foreach($users as $role => $roleUsers)
                <optgroup label="{{ $role == 'supplier' ? 'Importers' : ucfirst(str_replace('_', ' ', $role)) . 's' }}">
                  @foreach($roleUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </optgroup>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn" style="background: var(--coffee-brown); color: #fff; border-radius: 2rem;">Start Chat</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if(session('chat_created'))
  <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
    {{ session('chat_created') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<script>

if (window.Echo) {
    console.log('Echo is initialized');
    window.Echo.connector.pusher.connection.bind('connected', () => {
        console.log('Successfully connected to Pusher - Chat is ready for real-time messages');
        console.log('Current East Africa Time:', new Date().toLocaleString('en-GB', { timeZone: 'Africa/Nairobi' }));
    });
    window.Echo.connector.pusher.connection.bind('error', (error) => {
        console.error('Pusher connection error:', error);
    });
} else {
    console.error('Echo is not initialized - Real-time chat will not work');
}

document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messagesContainer');
    const messageInput = document.getElementById('messageInput');
    const messageForm = document.getElementById('messageForm');

    //  Echo listener for real-time messages
    @if(isset($conversation))
    if (typeof window.Echo !== 'undefined') {
        console.log('Setting up Echo listener for chat.{{ $conversation->id }}');
        
        // Remove any existing listeners to prevent duplicates
        window.Echo.leave('chat.{{ $conversation->id }}');
        
        window.Echo.private(`chat.{{ $conversation->id }}`)
            .listen('.MessageSent', (data) => {
                console.log('Received real-time message:', data);
                
                const isOwn = data.sender_id == {{ auth()->id() }};
                // Create a date object and format it in EAT timezone
                const messageTime = new Date(data.created_at).toLocaleString('en-GB', { 
                    timeZone: 'Africa/Nairobi',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });

                const messageHtml = `
                    <div class="message-row ${isOwn ? 'own' : ''}">
                        <div class="message-bubble">
                            ${data.message}
                            <div class="message-meta">
                                ${messageTime}
                                ${isOwn ? '<i class="fas fa-check text-secondary"></i>' : ''}
                            </div>
                        </div>
                    </div>
                `;
                
                messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                scrollToBottom();
                // Play a notification sound if the message is not from the current user
                if (!isOwn) {
                    try {
                        new Audio('/assets/notification.mp3').play().catch(e => console.log('No notification sound available'));
                    } catch (e) {
                        console.log('Audio playback failed:', e);
                    }
                }
            });
    } else {
        console.error('Echo is not defined! Real-time messaging will not work.');
    }
    @endif

    // Function to mark messages as read
    async function markMessagesAsRead() {
        if (!messagesContainer) return;
        
        const conversationId = window.location.pathname.split('/').pop();
        if (!conversationId) return;

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData();
            formData.append('_token', token);

            await fetch(`/chat/${conversationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: formData
            }).then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        // If CSRF token is invalid, refresh the page to get a new one
                        console.log('CSRF token expired, refreshing...');
                        window.location.reload();
                    }
                    throw new Error('Network response was not ok');
                }
                return response.json();
            }).then(data => {
                console.log('Messages marked as read');
            });
        } catch (error) {
            console.error('Error marking messages as read:', error);
        }
    }

    // Mark messages as read when the chat is visible
    if (document.visibilityState === 'visible') {
        markMessagesAsRead();
    }

    // Mark messages as read when the window becomes visible
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            markMessagesAsRead();
        }
    });

    // Mark messages as read when scrolling the chat
    let markReadTimeout;
    messagesContainer?.addEventListener('scroll', function() {
        clearTimeout(markReadTimeout);
        markReadTimeout = setTimeout(markMessagesAsRead, 1000);
    });

    // Function to refresh CSRF token
    async function refreshCsrfToken() {
        try {
            const response = await fetch('/sanctum/csrf-cookie', {
                method: 'GET',
                credentials: 'same-origin'
            });
            if (response.ok) {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                return token;
            }
        } catch (error) {
            console.error('Error refreshing CSRF token:', error);
        }
        return null;
    }

    // Refresh CSRF token every 30 minutes
    setInterval(refreshCsrfToken, 30 * 60 * 1000);

    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }
    scrollToBottom();

    if (messageInput) {
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }

    if (messageForm) {
        messageForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const messageText = messageInput.value.trim();
            if (messageText === '') return;

            // Try to send the message, with one retry if CSRF fails
            async function sendMessage(shouldRefreshToken = false) {
                if (shouldRefreshToken) {
                    await refreshCsrfToken();
                }

                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await fetch(messageForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        message: messageText,
                        _token: token
                    })
                });

                if (!response.ok) {
                    if (response.status === 419 && !shouldRefreshToken) {
                        // CSRF token expired, try once more with a fresh token
                        return sendMessage(true);
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                return response.json();
            }

            try {
                const data = await sendMessage();
                messageInput.value = '';
                if (data.message) {  
                    const messageHtml = `
                        <div class="message-row own">
                            <div class="message-bubble">
                                ${data.message}
                                <div class="message-meta">
                                    ${new Date().toLocaleString('en-GB', { timeZone: 'Africa/Nairobi', hour: '2-digit', minute: '2-digit', hour12: false })}
                                    <i class="fas fa-check text-secondary"></i>
                                </div>
                            </div>
                        </div>
                    `;
                    messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                    messageInput.style.height = 'auto';
                    scrollToBottom();
                    
                    //  ensure the message is visible
                    messagesContainer.offsetHeight;
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                } else if (data.status === 'error' && data.errors) {
                    console.error('Message errors:', data.errors);
                    alert('Error: ' + data.errors.join('\n'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to send message. The page will refresh to restore your session.');
                window.location.reload();
            }
        });

        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                messageForm.dispatchEvent(new Event('submit'));
            }
        });
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const conversations = document.querySelectorAll('.conversation-item');
            conversations.forEach(function(conv) {
                const name = conv.getAttribute('data-conversation-name').toLowerCase();
                if (name.includes(searchTerm)) {
                    conv.style.display = 'flex';
                } else {
                    conv.style.display = 'none';
                }
            });
        });
    }

    // We don't need this duplicate listener - removed to avoid conflicts
});
</script>
@endsection
