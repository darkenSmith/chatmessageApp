import mix from 'laravel-mix';

// Compile JavaScript and CSS
mix.js('resources/js/app.js', 'public/js')  // Compiling JS
    .postCss('resources/css/app.css', 'public/css');
