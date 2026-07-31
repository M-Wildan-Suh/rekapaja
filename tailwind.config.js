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
                dynapuff: ['"DynaPuff"', 'cursive'],
                sourgummy: ['"Sour Gummy"', 'cursive'],
            },
            colors: {
                'byolink-1' : '#3b82f6',
                'byolink-2' : '#fac534',
                'byolink-3' : '#1e40af',
            }
        },
    },

    plugins: [forms],
};
