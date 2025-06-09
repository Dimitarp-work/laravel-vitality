@extends('layouts.vitality')

@section('title', 'Capy Chat')

@section('content')
<style>
  html, body { overflow: hidden !important; }
</style>
<div class="max-h-screen flex items-center justify-center w-full max-w-6xl mx-auto">
    <div class="w-full bg-white rounded-2xl shadow p-8 py-12 flex flex-col max-h-[90vh] h-full">
        <div class="flex flex-col items-center">
            <img src="/images/capybara-rub.gif" alt="Capybara" class="w-20 h-20 rounded-full" />
            <h1 class="text-2xl font-bold text-pink-900 mt-2 text-center">Capy Chat</h1>
            <div class="text-pink-700 text-center mt-1 mb-4">Chat with Capybara, your AI wellness companion powered by Gemini. Share your thoughts, feelings, or anything on your mind!</div>
        </div>
        <div id="chat-history" class="w-full flex-1 overflow-y-auto px-1" style="min-height:120px;">
            @foreach($messages as $msg)
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
        <div id="capychat-loading" class="mt-4 hidden flex-col items-center">
            <span class="text-3xl animate-bounce">🦫</span>
            <span class="text-pink-400 text-sm mt-1">Capybara is thinking...</span>
        </div>
    </div>
</div>
<script>
    const chatHistory = document.getElementById('chat-history');
    const chatForm = document.getElementById('capychat-form');
    const chatInput = document.getElementById('capychat-input');
    const loadingDiv = document.getElementById('capychat-loading');

    function appendMessage(text, sender) {
        const bubble = document.createElement('div');
        bubble.className = sender === 'user'
            ? 'flex justify-end mb-1'
            : 'flex justify-start mb-1';
        bubble.innerHTML = sender === 'user'
            ? `<div class='bg-pink-400 text-white rounded-lg px-4 py-2 max-w-xl text-left break-words whitespace-pre-line'>${text}</div>`
            : `<div class='flex items-end gap-2'><img src="/images/capybara-chat-icon.png" alt="Capybara" class="w-10 h-10 rounded-full" /><div class='bg-white border border-pink-100 text-pink-900 rounded-lg px-4 py-2 max-w-xs'>${text}</div></div>`;
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
            loadingDiv.classList.add('hidden');
            if (data.capy && data.capy.message) {
                appendMessage(data.capy.message, 'capy');
            } else {
                appendMessage('Sorry, Capybara could not reply right now.', 'capy');
            }
        })
        .catch(() => {
            loadingDiv.classList.add('hidden');
            appendMessage('Sorry, Capybara could not reply right now.', 'capy');
        });
    });
</script>
@endsection
