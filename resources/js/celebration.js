// Celebration functionality
function openDeleteModal(id) {
    // Set form action URL
    document.getElementById('deleteForm').action = `/checkins/${id}`;

    // Show the modal
    document.getElementById('deleteModal').classList.remove('hidden');
}

// Function to check if all check-ins are complete
function checkAllComplete(wasJustCompleted = false) {
    const progressText = document.getElementById('progress-text');
    if (!progressText) return;

    const [completed, total] = progressText.textContent.split('/').map(Number);

    // Only show celebration if this was just completed and it completed all check-ins
    if (wasJustCompleted && completed === total && total > 0) {
        // Show celebration overlay with fade in
        const overlay = document.getElementById('celebrationOverlay');
        overlay.classList.remove('hidden');
        // Trigger reflow to ensure the transition works
        overlay.offsetHeight;
        overlay.classList.remove('opacity-0');

        // Hide after 3 seconds with fade out
        setTimeout(() => {
            overlay.classList.add('opacity-0');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300); // Wait for fade out animation to complete
        }, 3000);
    }
}

// Initialize celebration functionality
function initializeCelebration() {
    // Listen for changes in the progress text
    const progressText = document.getElementById('progress-text');
    if (progressText) {
        let previousCompleted = parseInt(progressText.dataset.completed);

        const observer = new MutationObserver(() => {
            const [completed] = progressText.textContent.split('/').map(Number);
            // Check if a new check-in was completed
            const wasJustCompleted = completed > previousCompleted;
            previousCompleted = completed;
            checkAllComplete(wasJustCompleted);
        });

        observer.observe(progressText, {
            childList: true,
            characterData: true,
            subtree: true
        });
    }
}

// Export functions for use in other files
export {
    openDeleteModal,
    initializeCelebration
};
