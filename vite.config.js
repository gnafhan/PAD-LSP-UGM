import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [laravel(['resources/css/app.css', 'resources/js/app.js'])],
    optimizeDeps: {
        exclude: ['vanilla-calendar-pro'], // Hindari error saat build
    },
});

