const mix = require('laravel-mix');
require('dotenv').config();

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

const domain = process.env.APP_URL;
mix.disableSuccessNotifications()
    .setResourceRoot('../')
    .setPublicPath('public')
    .copyDirectory('resources/fonts', 'public/fonts')
    .js('resources/js/main.js', 'js/main.js')
    .js('resources/js/test.js', 'js/test.js')
    .sass('resources/css/main.scss', 'css/main.css')
    .sass('resources/css/test.scss', 'css/test.css')
    .sourceMaps()
    .browserSync('http://' + domain);