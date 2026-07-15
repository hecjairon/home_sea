import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';
import path from 'node:path';

const isBuild = process.env.NODE_ENV === 'production' || process.argv.includes('build');

const vitePort = Number(process.env.VITE_PORT || 7552);

export default defineConfig({
  plugins: [react(), tailwindcss()],
  root: path.resolve(__dirname),
  base: isBuild ? '/wp-content/themes/homesea_theme/dist/' : '/',
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    origin: `http://localhost:${vitePort}`,
    cors: true,
    allowedHosts: true,
    hmr: {
      host: 'localhost',
      port: vitePort,
      clientPort: vitePort,
    },
  },
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: path.resolve(__dirname, 'src/main.jsx'),
    },
  },
});
