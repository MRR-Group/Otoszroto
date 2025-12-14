/** @type {import('tailwindcss').Config} */

export default {
  content: ["./resources/js/**/*.{html,js,ts,tsx}"],
  theme: {
    extend: {
      colors: {
        background: "#0b0d10",
        panel:      "#12151b",
        input:      "#0f1217",
        primary:    "#7a5cff",
        accent:     "#4dd3ff",
        text:       "#e9edf1",
        muted:      "#9aa6b2",
        border:     "rgba(255,255,255,.08)",
        ok:         "#2ecc71",
        warn:       "#f39c12",
        danger:     "#e74c3c",
      },
      borderRadius: {
        '2lg': '10px',
      },
    }
  },
  plugins: [],
}