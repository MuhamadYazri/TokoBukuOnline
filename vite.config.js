import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // hapus ketika production
    server: {
        host: "0.0.0.0",
        port: 5173,
        strictPort: true,
        hmr: {
            host: "tokobukuonline.me",
            protocol: "ws", // WebSocket protocol
            clientPort: 5173,
        },
        cors: {
            origin: "*", // development only!
            credentials: true,
        },
        watch: {
            usePolling: true, // For Windows file watching
        },
    },
    // server: {
    //     allowedHosts: ["pseudorhombohedral-larissa-spiteless.ngrok-free.dev"],
    // },
});
