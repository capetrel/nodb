const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your WordPlate applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JavaScript files.
 |
 */

mix.disableSuccessNotifications()
    .setResourceRoot('../')
    .setPublicPath('public')
    .copyDirectory('ressources/fonts', 'public/fonts')
    .js('ressources/js/main.js', 'js/main.js')
    .sass('ressources/css/main.scss', 'css/main.css')
    .sourceMaps()
    .browserSync('http://bddless-site.test');