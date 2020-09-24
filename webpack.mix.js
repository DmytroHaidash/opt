const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js')]
});

mix.js('resources/js/client/app.js', 'public/js/client.js')
    .js('resources/js/admin/app.js', 'public/js/admin.js')
    .js('resources/js/editor/editor.js', 'public/js/editor.js')
    .sass('resources/sass/client/app.scss', 'public/css/client.css')
    .sass('resources/sass/admin/app.scss', 'public/css/admin.css');
