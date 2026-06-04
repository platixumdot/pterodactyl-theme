import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'public/vendor/pltx-theme',
    emptyOutDir: false,
    rollupOptions: {
      input: {
        theme: 'resources/css/theme.css',
        app: 'resources/js/theme.js',
      },
      output: {
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith('.css')) {
            return 'css/[name][extname]';
          }
          return 'js/[name][extname]';
        },
        entryFileNames: ({ name }) => `js/${name}.js`,
      },
    },
  },
});
