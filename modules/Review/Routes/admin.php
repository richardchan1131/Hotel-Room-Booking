<?php
use Illuminate\Support\Facades\Route;

Route::match(['get','post'],'/','ReviewController@index')->name('review.admin.index');
Route::post('/bulkEdit','ReviewController@bulkEdit')->name('review.admin.bulkEdit');
