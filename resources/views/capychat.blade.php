@extends('layouts.vitality')

@section('title', 'Capy Chat')

@section('content')
<div class="w-full max-w-2xl mx-auto mt-8 bg-white rounded-2xl shadow p-8 flex flex-col items-center">
    <div class="text-4xl mb-2">🦫</div>
    <h1 class="text-2xl font-bold text-pink-900 mb-1">Capy Chat</h1>
    <div class="text-pink-700 mb-6 text-center">Chat with Capybara, your AI wellness companion powered by Gemini. Share your thoughts, feelings, or anything on your mind!</div>
    <div class="w-full flex flex-col gap-2 bg-pink-50 rounded-xl p-4 min-h-[320px] max-h-[400px] overflow-y-auto mb-4" id="capychat-history">
        <!-- Chat bubbles will be appended here -->
    </div>
    <form id="capychat-form" class="w-full flex gap-2 items-center">
        <input type="text" id="capychat-input" class="flex-1 border border-pink-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300 text-base" placeholder="Type your message..." autocomplete="off" required />
        <button type="submit" class="bg-pink-400 hover:bg-pink-500 text-white rounded-lg px-5 py-2 font-semibold transition text-base">Send</button>
    </form>
    <div id="capychat-loading" class="mt-4 hidden flex-col items-center">
        <span class="text-3xl animate-bounce">🦫</span>
        <span class="text-pink-400 text-sm mt-1">Capybara is thinking...</span>
    </div>
</div>
<script>
    const chatHistory = document.getElementById('capychat-history');
    const chatForm = document.getElementById('capychat-form');
    const chatInput = document.getElementById('capychat-input');
    const loadingDiv = document.getElementById('capychat-loading');

    function appendMessage(text, sender) {
        const bubble = document.createElement('div');
        bubble.className = sender === 'user'
            ? 'flex justify-end mb-1'
            : 'flex justify-start mb-1';
        bubble.innerHTML = sender === 'user'
            ? `<div class='bg-pink-400 text-white rounded-lg px-4 py-2 max-w-xs text-right'>${text}</div>`
            : `<div class='flex items-end gap-2'><span class='text-2xl'>🦫</span><div class='bg-white border border-pink-100 text-pink-900 rounded-lg px-4 py-2 max-w-xs'>${text}</div></div>`;
        chatHistory.appendChild(bubble);
        chatHistory.scrollTop = chatHistory.scrollHeight;
    }

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const msg = chatInput.value.trim();
        if (!msg) return;
        appendMessage(msg, 'user');
        chatInput.value = '';
        loadingDiv.classList.remove('hidden');
        // TODO: Integrate backend here
        setTimeout(() => {
            loadingDiv.classList.add('hidden');
            appendMessage('This is a placeholder Capybara reply!', 'capy');
        }, 1200);
    });
</script>
@endsection 