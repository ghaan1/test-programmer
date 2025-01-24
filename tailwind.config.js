import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "custom-red-bg": "#f03c2f",
                "custom-red-icon": "#f75d54",
                "custom-red-button": "#f22519",
                "custom-red-active-sidebar": "#f65c52",
                "custom-red-add-button": "#f52619",
                "custom-greed-excel-button": "#067605",
            },
        },
    },
    plugins: [],
};
