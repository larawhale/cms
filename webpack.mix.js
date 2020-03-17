let mix = require('laravel-mix');

mix.js('src/resources/js/app.js', 'src/public/js')
    .sass('src/resources/sass/app.scss', 'src/public/css');
