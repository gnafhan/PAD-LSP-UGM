import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
import { resolve } from "path";
import path from "path";

export default defineConfig({
    plugins: [
        laravel([
            "resources/css/app.css",
            "resources/js/app.js",
            "resources/js/asesor.js",
            "resources/js/quill-editor.js",
        ]),
    ],
    optimizeDeps: {
        exclude: ["vanilla-calendar-pro"], // Hindari error saat build
    },

    resolve: {
        alias: {
            flowbite: "node_modules/flowbite/dist/flowbite.js",
        },
    },

    define: {
        global: "globalThis",
    },
});
