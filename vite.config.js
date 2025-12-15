import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'
import react from "@vitejs/plugin-react";

export default ({ mode }) => {
  process.env = { ...process.env, ...loadEnv(mode, process.cwd()) }

  return defineConfig({
    build: {
      outDir: './public/build/',
    },
    server: {
      host: true,
      port: 5173,
      strictPort: true,
      origin: 'http://' + process.env.VITE_DEV_SERVER_DOCKER_HOST_NAME,
      cors: true, // Allow any origin
      hmr: {
        host: process.env.VITE_DEV_SERVER_DOCKER_HOST_NAME,
        protocol: "ws",
        clientPort: 80,
      },
      watch: {
        ignored: [
          '**/.idea/**',
          '**/app/**',
          '**/tests/**',
          '**/bootstrap/**',
          '**/public/**',
          '**/vendor/**',
          '**/storage/**',
          '**/node_modules/**',
        ],
      },
    },
    resolve: {
      alias: {
        '@': '/resources/js',
      },
    },
    plugins: [
      laravel({
        input: 'resources/js/app.tsx',
        refresh: true,
      }),
      react(),
      tailwindcss(),
    ],
  })
}
