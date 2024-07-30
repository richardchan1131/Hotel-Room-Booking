const mix = require('laravel-mix');

mix.webpackConfig({
    output: {
        path: __dirname + '/../../../dist/frontend/module/template/preview',
    }
});

mix.js('js/preview.js', 'js').vue({version: 2});
mix.sass('scss/live-preview.scss', 'css')
