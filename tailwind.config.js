module.exports = {
  theme: {
    extend: {
      width: {
        "9": "2.25rem",
        "3/10": "30%",
        "28px": "28px"
      },
      height: {
        "28px": "28px",
        "9": "2.25rem"
      }
    },
  },
  variants: {
    outline: ['focus', 'responsive', 'hover'],
    backgroundColor: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
  },
  plugins: [],
}
