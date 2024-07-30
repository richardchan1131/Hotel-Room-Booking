<?php
use \Illuminate\Support\Facades\Route;

Route::group(['prefix'=>config('booking.booking_route_prefix')],function(){
    Route::post('/{code}/apply-coupon','CouponController@applyCoupon')->name('coupon.apply');
    Route::post('/{code}/remove-coupon','CouponController@removeCoupon')->name('coupon.remove');
});
