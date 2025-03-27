const mix = require('laravel-mix');

// Compile JavaScript and CSS
mix.js('resources/js/app.js', 'public/js')  // Compiling JS
    .postCss('resources/css/app.css', 'public/css', [ // Compiling CSS
        require('tailwindcss')  // Using TailwindCSS
    ])
    .version();  // For cache busting in production
