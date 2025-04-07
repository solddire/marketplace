/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,js,vue}", 
  ],
  theme: {
    extend: {
        spacing: {
          'n65p': '-65%',
          '34px': '34px',
          'n8px': '-8px',
        }
    },
  },
  plugins: [],
}