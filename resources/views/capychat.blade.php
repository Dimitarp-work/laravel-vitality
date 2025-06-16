@extends('layouts.vitality')

@section('title', 'Capy Chat')

@section('content')
<style>
  html, body { overflow: hidden !important; }
</style>
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-6xl mx-auto px-6 py-8">
        <div class="max-h-screen flex items-center justify-center w-full">
            <div class="w-full bg-white rounded-2xl shadow p-8 py-12 flex flex-col max-h-[90vh] h-full">
                <div class="flex flex-col items-center">
                    <img src="/images/capybara-rub.gif" alt="Capybara" class="w-20 h-20 rounded-full" />
                    <h1 class="text-2xl font-bold text-pink-900 mt-2 text-center">Capy Chat</h1>
                    <div class="text-pink-700 text-center mt-1 mb-4">Chat with Capy, your chill wellness companion powered. Share your thoughts, feelings, or anything on your mind!</div>
                </div>
                <div id="chat-history" class="w-full flex-1 overflow-y-auto px-1" style="min-height:120px;">
                    @php $dividerShown = false; @endphp
                    @foreach($messages as $msg)
                        @if(!$dividerShown && $firstUnreadId && $msg->id == $firstUnreadId)
                            <div id="new-messages-divider" class="flex items-center my-2">
                                <div class="flex-grow border-t border-pink-200"></div>
                                <span class="mx-3 text-xs text-pink-500 bg-pink-100 px-3 py-1 rounded-full shadow">New messages below</span>
                                <div class="flex-grow border-t border-pink-200"></div>
                            </div>
                            @php $dividerShown = true; @endphp
                        @endif
                        @if($msg->sender === 'user')
                            <div class="flex justify-end mb-1">
                                <div class='bg-pink-400 text-white rounded-lg px-4 py-2 max-w-xl text-left break-words whitespace-pre-line'>{{ $msg->message }}</div>
                            </div>
                        @else
                            <div class="flex justify-start mb-1">
                                <div class='flex items-end gap-2'>
                                    <img src="/images/capybara-chat-icon.png" alt="Capybara" class="w-10 h-10 rounded-full" />
                                    <div class='bg-white border border-pink-100 text-pink-900 rounded-lg px-4 py-2 max-w-xs'>{{ $msg->message }}</div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <form id="capychat-form" class="w-full flex gap-2 items-center mt-4">
                    <input type="text" id="capychat-input" class="flex-1 border border-pink-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300 text-base" placeholder="Type your message..." autocomplete="off" required />
                    <button type="submit" class="bg-pink-400 hover:bg-pink-500 text-white rounded-lg px-5 py-2 font-semibold transition text-base">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const chatHistory = document.getElementById('chat-history');
    const chatForm = document.getElementById('capychat-form');
    const chatInput = document.getElementById('capychat-input');

    function appendMessage(text, sender, id = null) {
        const bubble = document.createElement('div');
        bubble.className = sender === 'user'
            ? 'flex justify-end mb-1'
            : 'flex justify-start mb-1';
        bubble.innerHTML = sender === 'user'
            ? `<div class='bg-pink-400 text-white rounded-lg px-4 py-2 max-w-xl text-left break-words whitespace-pre-line'>${text}</div>`
            : `<div class='flex items-end gap-2'><img src="/images/capybara-chat-icon.png" alt="Capybara" class="w-10 h-10 rounded-full" /><div class='bg-white border border-pink-100 text-pink-900 rounded-lg px-4 py-2 max-w-xs'>${text}</div></div>`;
        chatHistory.appendChild(bubble);
        chatHistory.scrollTop = chatHistory.scrollHeight;
        if (sender === 'capy' && id) {
            fetch('/capychat/mark-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ id })
            });
        }
    }

    function showTypingIndicator() {
        removeTypingIndicator();
        const chatHistory = document.getElementById('chat-history');
        const typingDiv = document.createElement('div');
        typingDiv.id = 'capy-typing-indicator';
        typingDiv.className = 'flex justify-start mb-1';
        typingDiv.innerHTML = `<div class='flex items-end gap-2'><img src="/images/capybara-chat-icon.png" alt="Capybara" class="w-10 h-10 rounded-full animate-bounce" /><div class='bg-white border border-pink-100 text-pink-400 rounded-lg px-4 py-2 max-w-xs italic'>Capy is typing...</div></div>`;
        chatHistory.appendChild(typingDiv);
        chatHistory.scrollTop = chatHistory.scrollHeight;
    }

    function removeTypingIndicator() {
        const typingDiv = document.getElementById('capy-typing-indicator');
        if (typingDiv && typingDiv.parentNode) {
            typingDiv.parentNode.removeChild(typingDiv);
        }
    }

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const msg = chatInput.value.trim();
        if (!msg) return;
        appendMessage(msg, 'user');
        chatInput.value = '';
        showTypingIndicator();
        fetch("{{ route('capychat.message') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: msg })
        })
        .then(res => res.json())
        .then(data => {
            removeTypingIndicator();
            if (data.capy && data.capy.message) {
                appendMessage(data.capy.message, 'capy', data.capy.id);
            } else {
                appendMessage(`<div class='flex items-center gap-4'><img src="/images/capybara-sleeping.jpeg" alt="Capybara sleeping" class="w-32 h-32 object-cover rounded-xl" style="min-width:8rem; min-height:8rem;"/><span class="text-pink-900 text-lg leading-snug">Capy got tired and fell asleep.<br>Try waking him up with another message.</span></div>`, 'capy');
            }
        })
        .catch(() => {
            removeTypingIndicator();
            appendMessage(`<div class='flex items-center gap-4'><img src="/images/capybara-sleeping.jpeg" alt="Capybara sleeping" class="w-32 h-32 object-cover rounded-xl" style="min-width:8rem; min-height:8rem;"/><span class="text-pink-900 text-lg leading-snug">Capy got tired and fell asleep.<br>Try waking him up with another message.</span></div>`, 'capy');
        });
    });

    window.addEventListener('DOMContentLoaded', () => {
        const divider = document.getElementById('new-messages-divider');
        const chatHistory = document.getElementById('chat-history');
        if (divider && chatHistory) {
            chatHistory.scrollTop = divider.offsetTop - chatHistory.offsetTop - 24;
        } else if (chatHistory) {
            chatHistory.scrollTop = chatHistory.scrollHeight;
        }
        setTimeout(() => {
            if (window.updateCapyUnreadBubble) window.updateCapyUnreadBubble();
        }, 300);
        const bubble = document.getElementById('capy-unread-bubble');
        if (bubble) {
            bubble.classList.add('hidden');
            bubble.textContent = '';
        }
    });
</script>
@endsection
