/** @type {import('tailwindcss').Config} */
module.exports = {
  daisyui: {
    themes:["light","dark", "nord", "lemonade", "cmyk"]
  },
  content: ["./**/*.php", 'node_modules/preline/dist/*.js'],
  theme: {
    fontFamily: {
      'poppins': ['Poppins', 'sans-serif'],
    },
    extend: {
      backgroundImages:{
        'Interstellar': "url('./images/interstellar_movie-wide.jpg')",
      }
    },
  },
  plugins: [
    require('daisyui'),
    require('preline/plugin'),
    require('@tailwindcss/forms'),
    
  ],
}

