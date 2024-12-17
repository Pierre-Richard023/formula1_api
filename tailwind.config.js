/** @type {import('tailwindcss').Config} */

module.exports = {
    darkMode: 'selector',
    content: [
        "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    normal: '#E11D48',
                    light: '#E7476D',
                    dark: '#B0193A'
                },
                secondary: {
                    normal: '#5B2434',
                    light: '#7A3E51',
                    dark: '#451B29'
                },
            }
        },
    },
    plugins: [
        // require('flowbite/plugin')
    ],
}
