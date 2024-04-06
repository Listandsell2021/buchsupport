import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { viteCommonjs } from '@originjs/vite-plugin-commonjs';
import vitePluginRequire from "vite-plugin-require";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/jsBundler/spa/app.js',
            ],
            refresh: ['resources/jsBundler/**'],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                },
            },
        }),
        viteCommonjs(),
        vitePluginRequire(),
    ],
    resolve: {
        alias: {
            '@': 'C:\\laragon\\www\\listandsell\\buchsupport/resources/jsBundler/spa',
            //'@': '/resources/jsBundler/spa',
        },
        extensions: ['.js', '.ts', '.tsx', '.vue', '.json'],
    },
});
