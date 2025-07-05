@extends('layouts.app')
@section('sidebar-items')
    @includeIf('layouts.sidebar-items.' . auth()->user()->role)
@endsection
@php use Illuminate\Support\Str; @endphp
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
body, html {
    height: 100%;
}
.main-chat-wrapper {
    min-height: 100vh;
    height: 100vh;
    width: 100vw;
    overflow: hidden;
    background: var(--sidebar-bg);
}
.chat-sidebar {
    background: var(--sidebar-bg);
    height: 100vh;
    border-right: 1px solid #e0e0e0;
    display: flex;
    flex-direction: column;
    padding: 0;
}
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
    background: var(--chat-bg);
    height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 0;
}
.chat-header {
    padding: 1.2rem 2rem 1.2rem 2rem;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #fff;
}
.chat-header .avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: 2px solid var(--coffee-brown);
}
.chat-header .name {
    font-weight: 700;
    font-size: 1.15rem;
    color: #222;
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
    padding: 0.5rem 1rem;
    border-top: 1px solid #eee;
    background: #fff;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.chat-footer textarea {
    flex: 1 auto;
    border-radius: 2rem;
    border: 1px solid #ddd;
    padding: 0.7rem 1.2rem;
    resize: none;
    font-size: 1rem;
    min-height: 44px;
    max-height: 120px;
    background: #f7f6f4;
}
.chat-footer .send-btn {
    background: var(--coffee-brown);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    transition: background 0.2s;
}
.chat-footer .send-btn:hover {
    background: #6d4327;
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
            <span class="fw-bold" style="font-size: 1.6rem; color: #222;">Chats</span>
            
        </div>
       
         <div class="sidebar-search position-relative">
            <i class="fas fa-search"></i>
            <input type="text" class="form-control" placeholder="Search..." id="searchInput">
        </div>
       
        <div class="contact-list flex-grow-1">
            @foreach($users as $user)
                @php
                    $conv = $conversations->first(function($c) use ($user) {
                        return ($c->user_one_id == $user->id || $c->user_two_id == $user->id);
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
                <span class="role-badge text-capitalize">{{ $otherUser->role ?? 'Partner' }}</span>
                <span class="status"><i class="fas fa-circle"></i> Online</span>
               
            </div>
            <div class="chat-body flex-grow-1" id="messagesContainer">
                @forelse($conversation->messages as $message)
                    <div class="message-row {{ $message->sender_id == auth()->id() ? 'own' : '' }}">
                        <div class="message-bubble">
                            {{ $message->message }}
                            <div class="message-meta">
                                {{ $message->created_at->format('H:i') }}
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
                    <button type="submit" class="send-btn"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        @else
            <div class="flex-grow-1 d-flex align-items-center justify-content-center" style="background: #f7f6f4;">
                <div class="text-center">
                    <i class="fas fa-comments fa-5x mb-4" style="color: var(--coffee-brown);"></i>
                    <h3 style="color: #222;">Welcome to GlobalBean Connect Chat</h3>
                    <p class="mb-4 text-muted">Select a conversation from the sidebar to start chatting with your supply chain partners.</p>
                    <button class="btn" style="background: var(--coffee-brown); color: #fff; border-radius: 2rem;" data-bs-toggle="modal" data-bs-target="#newConversationModal">
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
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
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
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messagesContainer');
    const messageInput = document.getElementById('messageInput');
    const messageForm = document.getElementById('messageForm');

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
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const messageText = messageInput.value.trim();
            if (messageText === '') return;
            const formData = new FormData(messageForm);
            formData.append('message', messageText);

            fetch(messageForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => {
                const contentType = response.headers.get('content-type') || '';
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text); });
                }
                if (contentType.includes('application/json')) {
                    return response.json();
                } else {
                    throw new Error('Session expired or server error. Please refresh the page and log in again.');
                }
            })
            .then(data => {
                if (data.message_html) {
                    messagesContainer.insertAdjacentHTML('beforeend', data.message_html);
                    messageInput.value = '';
                    messageInput.style.height = 'auto';
                    scrollToBottom();
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                } else if (data.status === 'error' && data.errors) {
                    alert('Error: ' + data.errors.join('\n'));
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                let msg = error.message || '';
                alert('Debug info (show this to your developer):\n' + msg);
                if (msg.includes('419') || msg.toLowerCase().includes('csrf')) {
                    alert('Your session has expired (CSRF error). Please refresh the page and try again.');
                } else if (msg.includes('401')) {
                    alert('You are not authenticated. Please log in again.');
                } else if (msg.includes('403')) {
                    alert('You are not authorized to send messages in this conversation.');
                } else {
                    alert('Send failed: ' + msg);
                }
            });
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
     // Laravel Echo real-time chat listener
    @if(isset($conversation))
    if (window.Echo) {
        window.Echo.private('chat.{{ $conversation->id }}')
            .listen('MessageSent', (e) => {
                const isOwn = e.sender_id == {{ auth()->id() }};
                const bubble = `
                    <div class="message-row ${isOwn ? 'own' : ''}">
                        <div class="message-bubble">
                            ${e.message}
                            <div class="message-meta">
                                ${e.created_at}
                                ${isOwn ? (e.read_at ? '<i class=\"fas fa-check-double text-success\"></i>' : '<i class=\"fas fa-check text-secondary\"></i>') : ''}
                            </div>
                        </div>
                    </div>
                `;
                const messagesContainer = document.getElementById('messagesContainer');
                messagesContainer.insertAdjacentHTML('beforeend', bubble);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            });
    }
    @endif
});
</script>
@endsection
