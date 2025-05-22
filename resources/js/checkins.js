// DOM Elements and State Management
let completedCount;
let totalCount;
let token;

// Initialize state and elements
function initializeState() {
    const progressText = document.getElementById('progress-text');
    completedCount = parseInt(progressText.dataset.completed);
    totalCount = parseInt(progressText.dataset.total);
    token = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!token) {
        console.error('CSRF token not found');
    }
}

// UI Update Functions
function setButtonComplete(button) {
    button.classList.remove('bg-pink-500', 'hover:bg-pink-600');
    button.classList.add('bg-green-500', 'hover:bg-green-600');
    button.textContent = 'Completed';
    button.disabled = true;
    button.dataset.completed = 'true';
    completedCount++;
    updateProgress();
}

function updateProgress() {
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');

    if (progressBar && progressText) {
        const percentage = Math.round((completedCount / totalCount) * 100);
        progressBar.style.width = `${percentage}%`;
        progressText.textContent = `${completedCount}/${totalCount}`;
    }
}

// Requests to DB
async function completeCheckIn(checkInId) {
    const response = await fetch(`/checkins/${checkInId}/complete`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        credentials: 'same-origin'
    });
    return response.json();
}

async function createCustomCheckIn(title) {
    const response = await fetch('/checkins', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title: title.trim() })
    });

    if (!response.ok) {
        const data = await response.json();
        throw new Error(data.message || 'Failed to create check-in');
    }

    return response.json();
}

// Event Handler Functions
function createCompleteButtonHandler(button) {
    return async function(e) {
        e.preventDefault();
        if (button.disabled) return;

        try {
            button.disabled = true;
            const data = await completeCheckIn(button.dataset.id);

            if (data.success) {
                setButtonComplete(button);
            } else {
                button.disabled = false;
            }
        } catch (error) {
            console.error('Error completing check-in:', error);
            button.disabled = false;
        }
    };
}

function createNewCheckInElement(checkinData) {
    const newCheckin = document.createElement('label');
    newCheckin.className = 'group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer';
    newCheckin.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="text-xl">💧</span>
            <span class="text-pink-900">${checkinData.title}</span>
        </div>
        <button
            type="button"
            data-id="${checkinData.id}"
            data-completed="false"
            class="complete-btn text-white font-semibold px-4 py-2 rounded transition bg-pink-500 hover:bg-pink-600"
        >
            Not Done
        </button>
    `;

    const newButton = newCheckin.querySelector('.complete-btn');
    newButton.addEventListener('click', createCompleteButtonHandler(newButton));

    return newCheckin;
}

async function handleCustomFormSubmit(e) {
    e.preventDefault();
    console.log('Form submitted');

    const titleInput = document.getElementById('custom-checkin-title');
    const submitButton = e.target.querySelector('button[type="submit"]');

    if (!titleInput.value.trim()) {
        alert('Please enter a check-in title');
        return;
    }

    try {
        submitButton.disabled = true;
        console.log('Sending request with title:', titleInput.value);

        const data = await createCustomCheckIn(titleInput.value);
        console.log('Response data:', data);

        if (data.success) {
            const checkinsContainer = document.querySelector('.space-y-4');
            const newCheckin = createNewCheckInElement(data.checkin);
            checkinsContainer.appendChild(newCheckin);

            totalCount++;
            updateProgress();
            titleInput.value = '';
        }
    } catch (error) {
        console.error('Error adding check-in:', error);
        alert('Failed to add check-in. Please try again.');
    } finally {
        submitButton.disabled = false;
    }
}

// init
document.addEventListener('DOMContentLoaded', function() {
    initializeState();

    // Initialize complete buttons
    const completeButtons = document.querySelectorAll('.complete-btn');
    completeButtons.forEach(button => {
        button.addEventListener('click', createCompleteButtonHandler(button));
    });

    // Initialize custom check-in form
    const customForm = document.getElementById('custom-checkin-form');
    customForm.addEventListener('submit', handleCustomFormSubmit);
});
