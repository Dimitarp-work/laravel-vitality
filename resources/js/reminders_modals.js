// Reminders specific modal functions
window.openDeleteModal = function(id) {
    window.ModalUtils.openDeleteModal(id, '/reminders');
};

window.closeDeleteModal = function() {
    window.ModalUtils.closeDeleteModal();
};
