@props([
    'title' => 'Confirm Deletion',
    'message' => 'Are you sure you want to delete this item? This action cannot be undone.',
    'cancelText' => 'Cancel',
    'confirmText' => 'Delete',
    'feature' => 'checkins'
])

<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-xl shadow-md p-6 max-w-sm w-full transform transition-transform duration-300 scale-95">
        <h3 class="text-lg font-medium mb-4">{{ $title }}</h3>
        <p class="text-gray-600 mb-6">{{ $message }}</p>
        <div class="flex justify-end gap-2">
            <button onclick="window.ModalUtils.closeDeleteModal()"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                {{ $cancelText }}
            </button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                    {{ $confirmText }}
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    @vite(['resources/js/modal-utils.js', "resources/js/{$feature}_modal.js"])
@endpush
