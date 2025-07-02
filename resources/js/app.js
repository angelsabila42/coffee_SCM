import './bootstrap';

// Real-time chat listener example (to be included in your chat page script)
// Usage: window.listenForChat(conversationId, callback)
window.listenForChat = function(conversationId, onMessage) {
    if (!window.Echo) return;
    window.Echo.private('chat.' + conversationId)
        .listen('MessageSent', (e) => {
            if (typeof onMessage === 'function') {
                onMessage(e);
            }
        });
};

