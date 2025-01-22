import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        chunkSizeWarningLimit: 3600,
        commonjsOptions: {
            include: /node_modules/,
        },
    },
    esbuild: {
        drop: ["console", "debugger"],
    },
});
