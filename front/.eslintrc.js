module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  extends: [
    // Reactの構文チェック
    'plugin:react/recommended',
    // airbnbスタイルコード構文チェック
    'airbnb',
    // React hooksの構文チェック
    'airbnb/hooks',
    // ESLintの推奨ルールセット
    'eslint:recommended',
    // 型チェックが不要なルールを適応
    'plugin:@typescript-eslint/recommended',

    'prettier',
  ],
  parser: '@typescript-eslint/parser',
  parserOptions: {
    ecmaFeatures: {
      jsx: true,
    },
    ecmaVersion: 'latest',
    sourceType: 'module',
  },
  plugins: [
    'react',
    '@typescript-eslint',
  ],
  rules: {
    'import/extensions': [
      'error',
      {
        ts: 'never',
        tsx: 'never',
      },
    ],
    'react/jsx-filename-extension': [
      'error',
      {
        extensions: ['.jsx', '.tsx'],
      },
    ],
    "no-use-before-define": "off",
    "@typescript-eslint/no-use-before-define": ["error"],
    "react/function-component-definition": [
      "error",
      {
        "namedComponents": "arrow-function",
        "unnamedComponents": "arrow-function"
      }
    ],
    "react/jsx-props-no-spreading": "off",

    // 'react/react-in-jsx-scope': 'off',
    'no-useless-constructor': 'off',
    'no-shadow': 'off',

    "react/require-default-props": "off"
  },
  settings: {
    'import/resolver': {
      node: {
        paths: ['src'],
        extensions: ['.js', '.ts', '.jsx', '.tsx'],
      },
    },
  },
};
