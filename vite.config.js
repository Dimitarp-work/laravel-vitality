import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin'; // Import the Laravel Vite plugin

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'], // Specify your entry points
      refresh: true, // Enable auto-refresh in development
    }),
    tailwindcss(),
  ],
});
