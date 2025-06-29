import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/checkins.js',
                'resources/js/celebration.js',
                'resources/js/confetti.js',
                'resources/js/modal-utils.js',
                'resources/js/checkins_modals.js',
                'resources/js/reminders_modals.js',
                'resources/js/articles_modal.js',
            ],
            refresh: true,
        }),
    ],
});

