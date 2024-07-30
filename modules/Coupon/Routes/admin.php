<?php
use \Illuminate\Support\Facades\Route;
Route::get('/','CouponController@index')->name('coupon.admin.index');
Route::get('/create','CouponController@create')->name('coupon.admin.create');
Route::get('/edit/{id}','CouponController@edit')->name('coupon.admin.edit');
Route::post('/store/{id}','CouponController@store')->name('coupon.admin.store');
Route::post('/bulkEdit','CouponController@bulkEdit')->name('coupon.admin.bulkEdit');

Route::get('/get_services', 'CouponController@getServiceForSelect2')->name('coupon.admin.getServices');