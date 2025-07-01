@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 h-100">
    <div class="row h-100 overflow-hidden">
        <!-- Conversations Sidebar -->
        <div class="col-md-4 col-lg-3 p-0 border-end bg-brown-100">
            <div class="d-flex flex-column h-100">
                <!-- Header -->
                <div class="bg-brown text-white p-3">
                    <h4 class="mb-1">Chats</h4>
                    <small class="text-light">{{ $conversations->count() }} active conversations</small>
                </div>

                <!-- Search -->
                <div class="p-3 border-bottom">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search contacts..." id="searchInput">
                    </div>
                </div>

                <!-- Contacts List (all users except self) -->
                <div class="flex-grow-1 overflow-auto">
                    @foreach($users as $user)
                        @php
                            $conv = $conversations->first(function($c) use ($user) {
                                return $c->participant_id == $user->id;
                            });
                        @endphp
                        <a href="{{ $conv ? route('chat.show', $conv->id) : route('chat.create') }}"
                           class="d-block text-decoration-none conversation-item {{ isset($conversation) && isset($conv) && $conversation->id === $conv->id ? 'active' : '' }}"
                           data-conversation-name="{{ $user->name }}">
                            <div class="d-flex align-items-center p-3 border-bottom hover-bg-light">
                                <!-- Avatar -->
                                <div class="position-relative me-3">
                                    <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=007bff&color=fff' }}"
                                         class="rounded-circle"
                                         width="50"
                                         height="50"
                                         alt="{{ $user->name }}">
                                    @if(isset($user->is_online) && $user->is_online)
                                        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width: 15px; height: 15px;"></span>
                                    @endif
                                </div>

                                <!-- Contact Info -->
                                <div class="flex-grow-1 min-width-0">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0 text-truncate text-dark">{{ $user->name }}</h6>
                                        <div class="d-flex flex-column align-items-end">
                                            @if($conv && $conv->unread_count > 0)
                                                <span class="badge bg-primary rounded-pill mb-1">{{ $conv->unread_count > 99 ? '99+' : $conv->unread_count }}</span>
                                            @endif
                                            <small class="text-muted">
                                                {{ $conv && $conv->last_message ? $conv->last_message->created_at->format('H:i') : '' }}
                                            </small>
                                        </div>
                                    </div>
                                    <!-- Last Message -->
                                    <p class="mb-1 text-muted small text-truncate">
                                        @if($conv && $conv->last_message)
                                            @if($conv->last_message->sender_id == auth()->id())
                                                <span class="text-primary">You: </span>
                                            @endif
                                            {{ $conv->last_message->message }}
                                        @else
                                            <em>No conversation yet</em>
                                        @endif
                                    </p>
                                    <!-- Role Badge -->
                                    @if(isset($user->role))
                                        <span class="badge 
                                            @if($user->role === 'supplier') bg-success
                                            @elseif($user->role === 'manufacturer') bg-info
                                            @elseif($user->role === 'distributor') bg-warning
                                            @elseif($user->role === 'retailer') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($user->role ?? 'Partner') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Quick Actions -->
                <div class="p-3 border-top bg-light">
                    <div class="row g-2">
                        <div class="col-6">
                            <!-- Button trigger modal -->
                            <button class="btn btn-brown rounded-pill px-4 py-2" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                                <i class="fas fa-plus me-2"></i>Start New Conversation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Panel -->
        <div class="col-md-8 col-lg-9 p-0 d-flex flex-column">
            @if(isset($conversation))
                <!-- Chat Header -->
                <div class="bg-brown text-white p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ $conversation->participant->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($conversation->participant->name ?? 'User') . '&background=8B4513&color=fff' }}" 
                                 class="rounded-circle me-3" 
                                 width="40" 
                                 height="40" 
                                 alt="User">
                            <div>
                                <h6 class="mb-0">{{ $conversation->participant->name ?? 'Unknown User' }}</h6>
                                <small class="text-light">
                                    @if(isset($conversation->participant->is_online) && $conversation->participant->is_online)
                                        <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i>Online
                                    @else
                                        <i class="fas fa-circle text-secondary me-1" style="font-size: 8px;"></i>Last seen recently
                                    @endif
                                </small>
                            </div>
                        </div>

                        <!-- Chat Actions -->
                        <div class="d-flex">
                            <button class="btn btn-link text-white me-2" title="Voice Call">
                                <i class="fas fa-phone"></i>
                            </button>
                            <button class="btn btn-link text-white me-2" title="Video Call">
                                <i class="fas fa-video"></i>
                            </button>
                            <button class="btn btn-link text-white" title="More Options">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="flex-grow-1 overflow-auto p-3 bg-brown-100" id="messagesContainer" style="height: 400px;">
                    @forelse($conversation->messages as $message)
                        @include('partials.message', ['message' => $message])
                    @empty
                        <div class="text-center text-brown py-5">
                            <i class="fas fa-comments fa-3x mb-3 text-brown opacity-50"></i>
                            <h5>No messages yet</h5>
                            <p>Start the conversation by sending a message below</p>
                        </div>
                    @endforelse
                </div>
                <div class="p-1 border-top bg-white">
                     <form action="{{ route('chat.store', $conversation->id) }}" method="POST" id="messageForm">
                     @csrf
                    <div class="input-group">

                         <textarea name="message"
                        class="form-control"
                        placeholder="Type a message..."
                        rows="1"
                        id="messageInput"
                        required
                        style="flex-grow: 1;"></textarea> 

                        <button type="submit" class="btn btn-brown">
                        <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                    </form>
            </div>

            @else
                <!-- Empty State -->
                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-brown">
                    <div class="text-center">
                        <i class="fas fa-comments fa-5x mb-4 text-brown opacity-50"></i>
                        <h3 class="text-dark">Welcome to GlobalBean Connect Chat</h3>
                        <p class="mb-4">Select a conversation from the sidebar to start chatting with your supply chain partners.</p>
                        <!-- Button trigger modal -->
                        <button class="btn btn-brown rounded-pill px-4 py-2" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                            <i class="fas fa-plus me-2"></i>Start New Conversation
                        </button>
                    </div>
                </div>
            @endif
        </div>
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
        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div class="modal-body">
          <div class="mb-3">
            <label for="participant" class="form-label">Select User</label>
            <select class="form-select" id="participant" name="participant_id" required>
              <option value="">Choose a user...</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-brown">Start Chat</button>
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

<style>
:root {
    --bs-brown: #8B4513;
    --bs-brown-100: #f7f3ef;
    --bs-brown-200: #e5d3c6;
    --bs-brown-300: #d4b896;
    --bs-brown-400: #a67c52;
    --bs-brown-500: #8B4513;
}
.bg-brown {
    background-color: var(--bs-brown) !important;
}
.bg-brown-100 {
    background-color: var(--bs-brown-100) !important;
}
.text-brown {
    color: var(--bs-brown) !important;
}
.text-brown-100 {
    color: var(--bs-brown-100) !important;
}
.border-brown {
    border-color: var(--bs-brown) !important;
}
.btn-brown {
    background-color: brown;
    color: #fff;
    border: none;
}
.btn-brown:hover, .btn-brown:focus {
    background-color: #5a3721;
    color: #fff;
}
.btn-outline-brown {
    color: var(--bs-brown);
    border: 1px solid var(--bs-brown);
    background: transparent;
}
.btn-outline-brown:hover, .btn-outline-brown:focus {
    background: var(--bs-brown);
    color: #fff;
}
.conversation-item:hover {
    background-color: #f8f9fa !important;
}

.conversation-item.active {
    background-color: var(--bs-brown-100) !important;
    border-left: 4px solid var(--bs-brown);
}

.hover-bg-light:hover {
    background-color: #f8f9fa;
}

#messagesContainer {
    scroll-behavior: smooth;
}

#messageInput {
    resize: none;
    max-height: 120px;
}

.p-3.rounded {
    border-radius: 1.5rem !important;
}
</style>

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
            .then(response => response.json())
            .then(data => {
                if (data.message_html) {
                    messagesContainer.insertAdjacentHTML('beforeend', data.message_html);
                    messageInput.value = '';
                    messageInput.style.height = 'auto';
                    scrollToBottom();
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
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
                    conv.style.display = 'block';
                } else {
                    conv.style.display = 'none';
                }
            });
        });
    }

    // Auto-refresh messages every 3 seconds
    @if(isset($conversation))
    let lastMessageId = {{ $conversation->messages->last()->id ?? 0 }};
    setInterval(function() {
        fetch('{{ route("chat.messages", $conversation->id) }}')
            .then(response => response.json())
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    let newMessagesHtml = '';
                    let updatedLastMessageId = lastMessageId;
                    data.messages.forEach(message => {
                        if (message.id > lastMessageId) {
                            newMessagesHtml += `<div class="mb-3 d-flex ${message.is_own ? 'justify-content-end' : 'justify-content-start'}">
                                <div class="d-flex align-items-end ${message.is_own ? 'flex-row-reverse' : ''}" style="max-width: 70%;">
                                    ${!message.is_own ? `<img src=\"${message.sender_avatar}\" class=\"rounded-circle me-2\" width=\"32\" height=\"32\" alt=\"Sender\">` : ''}
                                    <div class="p-3 rounded ${message.is_own ? 'bg-brown text-white' : 'bg-white border border-brown'}">
                                        <p class="mb-1">${message.message}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="${message.is_own ? 'text-brown-100' : 'text-brown'}">${message.created_at}</small>
                                            ${message.is_own ? `<div class="ms-2">${message.read_at ? '<i class=\"fas fa-check-double text-success\"></i>' : '<i class=\"fas fa-check text-brown-100\"></i>'}</div>` : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                            updatedLastMessageId = Math.max(updatedLastMessageId, message.id);
                        }
                    });
                    if (newMessagesHtml) {
                        messagesContainer.insertAdjacentHTML('beforeend', newMessagesHtml);
                        scrollToBottom();
                        lastMessageId = updatedLastMessageId;
                    }
                }
            })
            .catch(error => console.error('Error refreshing messages:', error));
    }, 3000);
    @endif
});
</script>
@endsection
