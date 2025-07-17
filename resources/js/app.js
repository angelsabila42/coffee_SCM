import './bootstrap';

// Real-time chat listener example (to be included in your chat page script)
// Usage: window.listenForChat(conversationId, callback)
window.listenForChat = function(conversationId, onMessage) {
    if (!window.Echo) {
        console.error('Echo is not available. Check if Laravel Echo and Pusher are properly configured.');
        return;
    }
    
    console.log('Setting up chat listener for conversation:', conversationId);
    
    try {
        window.Echo.private('chat.' + conversationId)
            .listen('MessageSent', (e) => {
                console.log('Received message via helper:', e);
                if (typeof onMessage === 'function') {
                    onMessage(e);
                }
            });
        console.log('Listener registered successfully');
    } catch (error) {
        console.error('Error setting up chat listener:', error);
    }
};

