module.exports = {
  theme: {
    extend: {
      width: {
        "9": "2.25rem",
        "28px": "28px",
        "500px": "500px",
      },
      height: {
        "28px": "28px",
        "500px": "500px",
        "9": "2.25rem",
      },
      top: {
        "7/10": "70%",
        "1/2": "50%"
      },
      left: {
        "1/2": "50%"
      },
      lineHeight: {
        "16": "4rem"
      }
    },
  },
  variants: {
    outline: ['focus', 'responsive', 'hover'],
    backgroundColor: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
  },
  plugins: [],
}
