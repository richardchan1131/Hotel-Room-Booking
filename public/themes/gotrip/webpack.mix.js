const mix = require('laravel-mix');

// Admin
mix.webpackConfig({
    output: {
        path:__dirname+'/dist/frontend',
    }

});

mix.sass('sass/app.scss','css');
mix.sass('sass/user.scss','css');
mix.sass('module/space/scss/space.scss','module/space/css');
mix.sass('module/hotel/scss/hotel.scss','module/hotel/css');
mix.sass('module/flight/scss/flight.scss','module/flight/css');
mix.sass('sass/rtl.scss','css');
mix.combine([
    '../../js/functions.js',
    'js/home.js',
    'js/custom.js',
], 'dist/frontend/js/gotrip.js');

mix.combine([
    '../../js/filter-map.js',
    'js/custom-filter-map.js',
], 'dist/frontend/js/filter-map.js');

mix.browserSync({
    proxy:'localhost:8000',
    files: ["sass/*.scss", "../../../themes/Gotrip/**/*.php",'../../js/*.js','js/*.js']
});
