import { openDeleteModal, initializeCelebration } from './celebration';
import { initializeConfetti } from './confetti';

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
    const isRecurringCheckbox = document.getElementById('isRecurring');
    const formData = {
        title: title.trim(),
        isRecurring: isRecurringCheckbox?.checked || false
    };

    const response = await fetch('/checkins', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    });

    const data = await response.json();

    if (!response.ok) {
        // Handle Laravel validation errors
        if (response.status === 422 && data.errors) {
            // Get all error messages for the title field
            const titleErrors = data.errors.title;
            if (titleErrors && titleErrors.length > 0) {
                throw new Error(titleErrors[0]); // Use the first error message
            }
        }
        throw new Error(data.message || 'Failed to create check-in');
    }

    return data;
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
    const newCheckin = document.createElement('div');
    newCheckin.className = 'group grid grid-cols-[1fr,120px] gap-4 p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all relative';
    newCheckin.innerHTML = `
        <div class="min-w-0 flex items-center gap-2">
            ${checkinData.isRecurring ? '<span class="material-icons text-pink-400 text-sm" title="Recurring check-in">repeat</span>' : ''}
            <span class="text-pink-900 break-all">${checkinData.title}</span>
        </div>
        <div class="flex justify-end">
            <button
                type="button"
                data-id="${checkinData.id}"
                data-completed="false"
                class="complete-btn whitespace-nowrap text-white font-semibold px-4 py-2 rounded transition bg-pink-500 hover:bg-pink-600"
            >
                Not Done
            </button>
        </div>
        <form action="/checkins/${checkinData.id}" method="POST" class="delete-form absolute -top-3 -right-3">
            <input type="hidden" name="_token" value="${token}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="button" onclick="openDeleteModal('${checkinData.id}')" class="delete-btn h-6 w-6 rounded-full bg-red-100 hover:bg-red-200 flex items-center justify-center transition-colors shadow-sm border border-red-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </form>
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
    const form = e.target;

    // Remove any existing error messages and error states
    clearErrors(titleInput);

    if (!titleInput.value.trim()) {
        displayError(titleInput, 'Please enter a check-in title');
        return;
    }

    try {
        submitButton.disabled = true;
        console.log('Sending request with title:', titleInput.value);

        const data = await createCustomCheckIn(titleInput.value);
        console.log('Response data:', data);

        if (data.success) {
            const checkinsContainer = document.querySelector('.bg-white.rounded-2xl.shadow .space-y-4');
            const newCheckin = createNewCheckInElement(data.checkin);
            checkinsContainer.appendChild(newCheckin);

            totalCount++;
            updateProgress();
            titleInput.value = '';
        }
    } catch (error) {
        console.error('Error adding check-in:', error);
        displayError(titleInput, error.message);
    } finally {
        submitButton.disabled = false;
    }
}

function displayError(input, message) {
    // Add error class to input
    input.classList.add('border-red-500', 'focus:ring-red-500');

    // Get the label element
    const label = document.querySelector('label[for="custom-checkin-title"]');

    // Update label with error message and styling
    label.innerHTML = `<span class="material-icons text-red-500 text-sm">error_outline</span><span>${message}</span>`;
    label.classList.remove('text-gray-500');
    label.classList.add('text-red-500', 'flex', 'items-center', 'gap-1');
}

function clearErrors(input) {
    // Remove error class from input
    input.classList.remove('border-red-500', 'focus:ring-red-500');

    // Reset label to original state
    const label = document.querySelector('label[for="custom-checkin-title"]');
    label.textContent = `Max ${CheckInConstants.TITLE_MAX_LENGTH} characters`;
    label.classList.remove('text-red-500', 'flex', 'items-center', 'gap-1');
    label.classList.add('text-gray-500');
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

    // Initialize celebration functionality
    initializeCelebration();

    // Initialize confetti
    initializeConfetti();
});
