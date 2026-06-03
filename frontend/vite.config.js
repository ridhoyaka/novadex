import { defineConfig } from 'vite';

export default defineConfig({
    root: '.',
    build: {
        outDir: 'dist',
        rollupOptions: {
            input: {
                index: 'index.html',
                katalog: 'katalog.html',
                kategori: 'kategori.html',
                peta: 'peta.html',
                detail: 'detail.html',
            },
        },
    },
});
