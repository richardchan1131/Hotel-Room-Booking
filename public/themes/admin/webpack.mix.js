const mix = require('laravel-mix');


mix.webpackConfig({
    output: {
        path: __dirname + '/../../dist/admin',
    }
});
mix.disableSuccessNotifications();
//mix.setPublicPath('../dist/admin');

mix
    .sass('scss/app.scss', 'css')
    .sass('../../module/page/admin/scss/builder.scss', 'module/page/css');

mix.sass('module/template/admin/scss/live.scss', 'module/template/admin/live')

mix.js('js/app.js', 'js').extract(['vue']).vue({version: 2});
