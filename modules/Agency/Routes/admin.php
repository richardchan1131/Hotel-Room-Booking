<?php
use Illuminate\Support\Facades\Route;

Route::get('/','AgenciesController@index')->name('agencies.admin.index');

/** agencies */
Route::match(['get'],'/','AgenciesController@index')->name('agencies.admin.index');
// Route::match(['get'],'/agencyContact','AgenciesController@showAgencyContact')->name('agencies.admin.contact');
Route::match(['get',],'/form/{id?}','AgenciesController@create')->name('agencies.admin.create');
Route::post('/store/{id?}','AgenciesController@store')->name('agencies.admin.store');
Route::post('/bulkEdit','AgenciesController@bulkEdit')->name('agencies.admin.bulkEdit');

// Route::get('/contact', 'AgenciesController@showContact')->name('agencies.admin.showContact');
