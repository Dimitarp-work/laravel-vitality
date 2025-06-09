document.addEventListener('DOMContentLoaded', function () {
    // Mood widget logic
    const moodForm = document.getElementById('mood-form');
    const messageContent = document.getElementById('mood-message-content');
    const loadingGif = document.getElementById('mood-loading-gif');
    const messageDiv = document.getElementById('mood-message');
    const moodLabels = document.querySelectorAll('#mood-form [data-mood]');
    const weekMoodsDiv = document.getElementById('week-moods');
    // Tailwind classes for selected mood
    const selectedClasses = [
        'ring-4', 'ring-pink-300', 'bg-pink-100', 'rounded-full', 'shadow-md', 'scale-110', 'transition-all', 'duration-200'
    ];
    const selectedLabelClasses = ['text-pink-600', 'font-bold'];
    // Emoji map for moods
    const moodEmojis = {
        sad: '😢',
        stressed: '😣',
        neutral: '😐',
        calm: '😌',
        happy: '😊',
        none: '<span class="text-gray-400">?</span>'
    };
    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    // Get today as day string (Mon-Sun)
    function getTodayDay() {
        const jsDay = new Date().getDay();
        return days[(jsDay + 6) % 7];
    }

    // Render a single day mood cell for the weekly widget
    function renderDayMood(day, mood, isToday, isFirst, isLast) {
        const moodEmoji = moodEmojis[mood] || moodEmojis['none'];
        const highlight = isToday && mood !== 'none' ? 'ring-4 ring-pink-300 bg-pink-100 shadow-md transition-all duration-200' : '';
        const highlightNone = isToday && mood === 'none' ? 'ring-2 ring-pink-200 bg-white transition-all duration-200' : '';
        const dayLabel = `<span class="text-xs mt-1 ${isToday ? 'font-bold text-pink-700' : ''}">${day}</span>`;
        const margin = isFirst ? 'ml-2 sm:ml-4' : isLast ? 'mr-2 sm:mr-4' : 'mx-1 sm:mx-2';
        return `
            <div class="flex flex-col items-center min-w-[40px] sm:min-w-[48px] ${margin} pt-1">
                <span class="text-2xl sm:text-3xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full leading-none ${highlight} ${highlightNone}">
                    ${moodEmoji}
                </span>
                ${dayLabel}
            </div>
        `;
    }

    // Highlight the selected mood in the mood selector
    function setMoodSelectorState(mood) {
        const radio = moodForm.querySelector(`input[name='mood'][value='${mood}']`);
        if (!radio) return;
        radio.checked = true;
        moodForm.querySelectorAll('label span').forEach(span => {
            selectedClasses.forEach(cls => span.classList.remove(cls));
        });
        selectedClasses.forEach(cls => radio.nextElementSibling.classList.add(cls));
        moodLabels.forEach(label => {
            selectedLabelClasses.forEach(cls => label.classList.remove(cls));
        });
        const selectedLabel = moodForm.querySelector(`[data-mood='${mood}']`);
        if (selectedLabel) {
            selectedLabelClasses.forEach(cls => selectedLabel.classList.add(cls));
        }
    }

    // Show the supportive message and button, hide the loading GIF
    function setSupportiveMessage(message, isGemini) {
        messageDiv.textContent = message || '';
        if (loadingGif) loadingGif.classList.add('hidden');
        const messageContainer = document.getElementById('mood-message-container');
        if (messageContainer) messageContainer.classList.remove('hidden');
        const capyBtn = document.getElementById('capychat-btn-container');
        if (!capyBtn) return;
        if (isGemini) {
            capyBtn.classList.remove('hidden');
        } else {
            capyBtn.classList.add('hidden');
        }
    }

    // Render the weekly moods widget
    function renderWeekMoods(data) {
        const moods = data.week;
        const todayMessage = data.today_message;
        const isGemini = data.today_message_is_gemini || false;
        weekMoodsDiv.innerHTML = '';
        const today = getTodayDay();
        const todaysMood = moods[today] || null;
        days.forEach((day, idx) => {
            const mood = moods[day] || 'none';
            const isToday = day === today;
            weekMoodsDiv.innerHTML += renderDayMood(day, mood, isToday, idx === 0, idx === days.length - 1);
        });
        if (todaysMood) setMoodSelectorState(todaysMood);
        setSupportiveMessage(todayMessage, isGemini);
    }

    function parseResponse(response) {
        return response.json();
    }

    // Fetch and render week moods on page load
    function fetchWeekMoods() {
        fetch("/mood/week")
            .then(parseResponse)
            .then(renderWeekMoods);
    }
    fetchWeekMoods();

    // Mood selection event
    moodForm.addEventListener('change', function(e) {
        if (e.target.name !== 'mood') return;
        setMoodSelectorState(e.target.value);
        if (loadingGif) loadingGif.classList.remove('hidden');
        const messageContainer = document.getElementById('mood-message-container');
        if (messageContainer) messageContainer.classList.add('hidden');
        fetch("/mood", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ mood: e.target.value })
        })
            .then(parseResponse)
            .then(data => {
                if (!data.success) {
                    setSupportiveMessage('Something went wrong. Please try again.', false);
                    return;
                }
                setSupportiveMessage(data.message, data.today_message_is_gemini);
                fetchWeekMoods();
            })
            .catch(() => {
                setSupportiveMessage('Could not connect to the server.', false);
            });
    });

    // Thought form logic
    const thoughtForm = document.getElementById('thought-form');
    if (thoughtForm) {
        thoughtForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = thoughtForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            fetch(thoughtForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    submitBtn.disabled = false;
                    thoughtForm.reset();
                    if (data.xp !== undefined) {
                        document.getElementById('user-xp-text').textContent = `${data.xp_progress} / ${data.xp_to_next} XP`;
                        document.getElementById('user-level').textContent = `Level ${data.level}`;
                        document.getElementById('xp-bar').style.width = `${data.progress_percent}%`;
                    }
                    if (data.credits !== undefined) {
                        document.getElementById('user-credits').textContent = `${data.credits} Credits`;
                    }
                    alert(data.message || 'Thought saved!');
                })
                .catch(() => {
                    submitBtn.disabled = false;
                    alert('Something went wrong.');
                });
        });
    }
}); 