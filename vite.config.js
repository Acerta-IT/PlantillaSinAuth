import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Permite accesos desde otros dispositivos
        port: 8000, // Puerto por defecto de Vite
        hmr: {
            host: '192.168.1.79', // Reemplázalo por la IP de tu PC
        }
    }
});
