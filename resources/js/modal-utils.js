// Shared modal functionality
window.ModalUtils = {
    openDeleteModal: function(id, baseUrl) {
        // Set form action URL
        document.getElementById('deleteForm').action = `${baseUrl}/${id}`;

        // Show the modal with fade in
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        // Trigger reflow to ensure the transition works
        modal.offsetHeight;
        modal.classList.remove('opacity-0');
        modal.querySelector('div').classList.remove('scale-95');
    },

    closeDeleteModal: function() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // Wait for fade out animation to complete
    }
};
