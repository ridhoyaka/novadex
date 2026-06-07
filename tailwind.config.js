import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'arsa': {
                    50: '#f6f2e8',
                    100: '#ebe4d7',
                    200: '#ded6c6',
                    300: '#c9bcaa',
                    400: '#a89985',
                    500: '#756b5b',
                    600: '#545d55',
                    700: '#2a302c',
                    800: '#1a1f1c',
                    900: '#10130f',
                    950: '#070807',
                },
                'gold': {
                    50: '#fff8df',
                    100: '#f7e8b8',
                    200: '#ecd58b',
                    300: '#e2bd62',
                    400: '#d4a945',
                    500: '#bf8f2e',
                    600: '#a57924',
                    700: '#7d5c18',
                    800: '#5f4314',
                    900: '#3f2d10',
                },
            },
        },
    },

    plugins: [forms],
};
