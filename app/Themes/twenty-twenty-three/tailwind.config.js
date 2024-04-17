/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.{html,js,php}",
    "./*.{html,js,php}"
  ],
  theme: {
    extend: {
      colors: {
        "primary-color": "var(--primary-color)",
        "secondary-color": "var(--secondary-color)"
      },
    },
  },
  plugins: [],
}

