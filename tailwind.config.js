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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Colores institucionales basados en el logo
                'primary': {
                    50: '#f0f4f8',
                    100: '#d9e2ec',
                    200: '#bcccdc',
                    300: '#9fb3c8',
                    400: '#829ab1',
                    500: '#627d98',
                    600: '#486581',
                    700: '#334e68',
                    800: '#243b53',
                    900: '#1a365d', // Navy blue principal
                    950: '#102a43',
                },
                'secondary': {
                    50: '#fffbeb',
                    100: '#fef3c7',
                    200: '#fde68a',
                    300: '#fcd34d',
                    400: '#fbbf24',
                    500: '#d4a017', // Gold/Amarillo principal
                    600: '#b8860b',
                    700: '#92400e',
                    800: '#78350f',
                    900: '#451a03',
                },
                'navy': {
                    DEFAULT: '#1a365d',
                    light: '#2d4a6f',
                    dark: '#102a43',
                },
                'gold': {
                    DEFAULT: '#d4a017',
                    light: '#f0c040',
                    dark: '#b8860b',
                },
            },
        },
    },

    plugins: [forms],
};
