<div class="mb-3 d-flex {{ $message->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}" data-message-id="{{ $message->id }}">
    <div class="d-flex align-items-end {{ $message->sender_id == auth()->id() ? 'flex-row-reverse' : '' }}" style="max-width: 70%;">
        @if($message->sender_id != auth()->id())
            <img src="{{ $message->sender->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($message->sender->name) . '&background=8B4513&color=fff' }}" 
                 class="rounded-circle me-2" 
                 width="32" 
                 height="32" 
                 alt="Sender">
        @endif

        <div class="p-3 rounded {{ $message->sender_id == auth()->id() ? 'bg-brown text-white' : 'bg-white border border-brown' }}">
            <p class="mb-1">{{ $message->message }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <small class="{{ $message->sender_id == auth()->id() ? 'text-brown-100' : 'text-brown' }}">
                    {{ $message->created_at->format('H:i') }}
                </small>
                @if($message->sender_id == auth()->id())
                    <div class="ms-2">
                        @if($message->read_at)
                            <i class="fas fa-check-double text-success"></i>
                        @else
                            <i class="fas fa-check text-brown-100"></i>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
