import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/style.css',
                'resources/css/login.css', // Make sure this is included
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
