import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import typography from '@tailwindcss/typography';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss({
            config: {
                theme: { extend: {} },
                plugins: [typography],
                content: [
                    './resources/**/*.blade.php',
                    './resources/**/*.js',
                    './resources/**/*.vue',
                ],
            },
        }),
    ],
});
