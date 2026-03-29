import { defineConfig, loadEnv } from "vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig(({ mode }) => {
    // CourttenisTema está en packages/Webkul/CourttenisTema/
    // necesitamos subir 3 niveles para llegar a la raíz del proyecto
    const envDir = "../../../";

    Object.assign(process.env, loadEnv(mode, envDir));

    return {
        build: {
            outDir: "../../../public/themes/shop/courttenis/build",
            emptyOutDir: true,
            minify: "esbuild",
            cssCodeSplit: true,
            rollupOptions: {
                output: {
                    manualChunks: {
                        vue: ["vue"],
                        veeValidate: ["vee-validate", "@vee-validate/rules", "@vee-validate/i18n"],
                        vendor: ["axios", "mitt"]
                    }
                }
            }
        },

        envDir,

        server: {
            host: process.env.VITE_HOST || "localhost",
            port: process.env.VITE_PORT || 5173,
            cors: true,
        },

        plugins: [
            vue(),

            laravel({
                hotFile: "../../../public/shop-courttenis-vite.hot",
                publicDirectory: "../../../public",
                buildDirectory: "themes/shop/courttenis/build",
                input: [
                    // Apunta a TUS assets en CourttenisTema
                    "src/Resources/assets/css/app.css",
                    "src/Resources/assets/js/app.js",
                ],
                refresh: [
                    // Hot reload también en tus vistas Blade
                    "../../../resources/themes/courttenis/views/**/*.blade.php",
                ],
                preload: false,
            }),
        ],

        experimental: {
            renderBuiltUrl(filename, { hostType }) {
                if (hostType === "css") {
                    return path.basename(filename);
                }
            },
        },
    };
});
