const mix = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
// .js('resources/js/app-server.js', 'public/js');
// https://laracasts.com/discuss/channels/elixir/mix-npm-run-hot-browser-crash-uncaught-typeerror-cannot-read-property-call-of-undefined?page=1#reply=584824

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js/')
        }
    }
});
mix.options({
    hmrOptions: {
        host: 'bdpos.test',
        port: '8080'
    }
});
