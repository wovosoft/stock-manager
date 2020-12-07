const mix = require('laravel-mix');
// require('laravel-mix-purgecss');
// https://laracasts.com/discuss/channels/elixir/mix-npm-run-hot-browser-crash-uncaught-typeerror-cannot-read-property-call-of-undefined?page=1#reply=584824

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js/')
        }
    }
});

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    // .purgeCss()
    .version();
// .js('resources/js/app-server.js', 'public/js');

mix.options({
    hmrOptions: {
        host: 'bdpos.test',
        port: '8080'
    }
});
