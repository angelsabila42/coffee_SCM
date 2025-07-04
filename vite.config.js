import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],

    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    server: {
    host: '127.0.0.1',
}

});
