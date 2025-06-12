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
        },
    },

    plugins: [forms],

    safelist: [
        'ring-4',
        'ring-pink-300',
        'ring-2',
        'ring-pink-200',
        'bg-pink-100',
        'bg-white',
        'shadow-md',
        'scale-110',
        'transition-all',
        'duration-200',
        'rounded-full',
        'text-pink-600',
        'font-bold',
        'text-pink-700',
        'text-gray-400',
        'text-2xl',
        'text-3xl',
        'w-10',
        'h-10',
        'w-12',
        'h-12',
        'min-w-[40px]',
        'sm:min-w-[48px]',
        'ml-2',
        'sm:ml-4',
        'mr-2',
        'sm:mr-4',
        'mx-1',
        'sm:mx-2',
        'pt-1',
    ],
};
