let mix = require('laravel-mix');
let Stylelint = require('stylelint-webpack-plugin');

mix.extend('stylelint', function(webpackConfig, ...args) {
    webpackConfig.plugins.push(
        new Stylelint({
            configFile: '.stylelintrc.js',
            context: './src/resources/sass/',
            fix: true,
        }),
    );
});

mix.stylelint();

// mix.js('src/resources/js/app.js', 'src/public/js')
//     .sass('src/resources/sass/app.scss', 'src/public/css');
