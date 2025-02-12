import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/filament/admin/theme.css'
            ],
            refresh: [
                ...refreshPaths,
                "app/Filament/**/*.php",
                "app/Forms/Components/**/*.php",
                "app/Livewire/**/*.php",
                "app/Infolists/Components/**/*.php",
                "app/Providers/Filament/**/*.php",
                "app/Tables/Columns/**/*.php"
            ],
        }),
    ],
});
