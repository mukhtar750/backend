module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './resources/**/*.css',
  ],
  theme: {
    extend: {
      colors: {
        'custom-purple': {
          DEFAULT: '#b81d8f',
          100: '#f3e5f6',
          200: '#e1bee7',
          700: '#9a1b76',
        },
      },
    },
  },
  safelist: [
    'bg-red-500',
    'bg-blue-500',
    'bg-green-500',
    // Add all possible dynamic color combinations here
  ],
  plugins: [],
}