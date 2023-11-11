/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
        colors:{
            dark: '#212121'
        }
    },
  },
  plugins: [
    require('tailwindcss-plugins/pagination'),
  ],
}

