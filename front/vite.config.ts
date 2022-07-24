import {defineConfig, loadEnv} from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig(({ mode}) => {
  const env = { ...loadEnv(mode, process.cwd(), "CONFIG_")};

  return {
    base: env.CONFIG_BASE,
    plugins: [react()],
    server: {
      proxy: {
        '^/api/.*': {
          target: 'http://localhost:8000',
          changeOrigin: true,
        }
      }
    },
    build: {
      outDir: "../public",
      emptyOutDir: false,
      assetsDir: "assets",
      target: "es2015",
    }
  }
})
