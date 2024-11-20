import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/syndash.css',
                'resources/css/bootstrap.min.css',
                'resources/css/icons.css',
                'resources/css/metisMenu.min.css',
                'resources/css/select2-bootstrap4.css',
                'resources/css/select2.min.css',
		        'resources/css/custom.css',
                'resources/js/app.js',
                'resources/js/syndash.js',
                'resources/js/main.js',
                'resources/js/guest.js',
                'resources/js/import.js'
            ],
            refresh: true,
        }),
    ],
});
