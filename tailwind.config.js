const colors = require("tailwindcss/colors");

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        colors: {
            primaryColor: "#5F3F2F",
            backgroundColor: '#E7E6D4',
            transparent: "transparent",
            current: "currentColor",
            black: colors.black,
            white: colors.white,
            gray: colors.gray,
            emerald: colors.emerald,
            indigo: colors.indigo,
            yellow: colors.yellow,
            red: colors.red,
        },
        extend: {
            fontFamily: {
                sans: ['"Fira Sans"', "sans-serif"],
                spectral: ["Spectral", "serif"],
            },
        },
    },
    plugins: [require("daisyui")],
};
