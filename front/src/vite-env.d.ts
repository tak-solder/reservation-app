/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_ROUTER_BASENAME: string;
  readonly VITE_API_URL: string;
  // その他の環境変数...
}

interface ImportMeta {
  readonly env: ImportMetaEnv;
}
