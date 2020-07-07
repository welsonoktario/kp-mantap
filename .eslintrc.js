module.exports = {
  env: {
    browser: true,
    amd: true,
    node: true,
    es2020: true,
  },
  extends: [
    'eslint:recommended',
    'plugin:vue/essential',
    'plugin:prettier/recommended',
    'prettier',
    'prettier/vue',
  ],
  parserOptions: {
    ecmaVersion: 11,
    sourceType: 'module',
  },
  plugins: ['vue'],
  rules: {
    indent: ['error', 2],
    'linebreak-style': ['error', 'unix'],
    quotes: ['error', 'single'],
    semi: ['error', 'always'],
    'prettier/prettier': ['error'],
  },
};
