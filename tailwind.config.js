/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/views/**/*.blade.php",
    "./resources/views/**/*.blade.php",
    "./resources/**/*.js",
  ],
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "so-orange": "#f48024",
        "so-orange-light": "#f69c55",
      },
    },
  },
  plugins: [],
};
