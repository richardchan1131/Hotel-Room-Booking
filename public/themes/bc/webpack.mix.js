const mix = require('laravel-mix');

// Admin
mix.webpackConfig({
    output: {
        path:__dirname+'/../../dist/frontend',
    }

});

mix.sass('../../sass/app.scss','css');
mix.sass('../../sass/contact.scss','css');
mix.sass('../../sass/rtl.scss','css');
mix.sass('../../sass/notification.scss','css');
// ----------------------------------------------------------------------------------------------------
//Booking
mix.sass('../../module/booking/scss/checkout.scss','module/booking/css');
mix.sass('../../module/user/scss/user.scss','module/user/css');
mix.sass('../../module/user/scss/profile.scss','module/user/css');
mix.sass('../../module/tour/scss/tour.scss','module/tour/css');
mix.sass('../../module/hotel/scss/hotel.scss','module/hotel/css');
mix.sass('../../module/news/scss/news.scss','module/news/css');
mix.sass('../../module/media/scss/browser.scss','module/media/css');
mix.sass('../../module/space/scss/space.scss','module/space/css');
mix.sass('../../module/location/scss/location.scss','module/location/css');
mix.sass('../../module/car/scss/car.scss','module/car/css');
mix.sass('../../module/event/scss/event.scss','module/event/css');
mix.sass('../../module/social/scss/social.scss','module/social/css');
mix.sass('../../module/flight/scss/flight.scss','module/flight/css');
mix.sass('../../module/boat/scss/boat.scss','module/boat/css');
mix.sass('../../module/support/scss/support.scss', 'module/support/css');

mix.browserSync({
    proxy: 'http://localhost:8000',
    host: 'booking.test',
    open:"external",
    files: [
        '../../../modules/**/Views/*.blade.php',
    ]
});

mix.disableSuccessNotifications();
