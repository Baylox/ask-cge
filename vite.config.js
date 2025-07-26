import { defineConfig } from 'vite';
import symfonyPlugin from 'vite-plugin-symfony';

export default defineConfig({
  plugins: [symfonyPlugin()],
  build: {
    rollupOptions: {
      input: {
        app: './assets/app.js' // Main entry point for the application
      }
    },
    outDir: 'public/build',
    emptyOutDir: true,
  },
});


