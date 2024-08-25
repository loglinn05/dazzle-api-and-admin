/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/**/*.{html,php,vue,js,ts,jsx,tsx}"],
    theme: {
        fontFamily: {
            logo: "Italianno",
            text: "Quicksand",
            header: "Raleway",
        },
        extend: {},
    },
    plugins: [],
    corePlugins: {
        preflight: false,
    },
};
