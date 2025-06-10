import './bootstrap';

import './moods.js';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Capy Chat unread message bubble
function isOnCapyChatPage() {
    return document.getElementById('chat-history') !== null;
}

function updateCapyUnreadBubble() {
    // If on Capy Chat page, do not show the bubble
    if (isOnCapyChatPage()) {
        const bubble = document.getElementById('capy-unread-bubble');
        if (bubble) {
            bubble.classList.add('hidden');
            bubble.textContent = '';
        }
        return;
    }
    fetch('/capychat/unread-count', {
        headers: {
            'Accept': 'application/json',
        },
        credentials: 'same-origin',
    })
        .then(res => res.json())
        .then(data => {
            const bubble = document.getElementById('capy-unread-bubble');
            if (bubble) {
                if (data.count > 0) {
                    bubble.textContent = data.count;
                    bubble.classList.remove('hidden');
                } else {
                    bubble.classList.add('hidden');
                }
            }
        });
}

document.addEventListener('DOMContentLoaded', () => {
    updateCapyUnreadBubble();
    setInterval(updateCapyUnreadBubble, 30000); // update every 30s
});

window.updateCapyUnreadBubble = updateCapyUnreadBubble;
