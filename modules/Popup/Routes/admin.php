<?php

use \Illuminate\Support\Facades\Route;


Route::get('/','PopupController@index')->name('popup.admin.index');
Route::get('/create','PopupController@create')->name('popup.admin.create');
Route::get('/edit/{id}','PopupController@edit')->name('popup.admin.edit');
Route::post('/store/{id}','PopupController@store')->name('popup.admin.store');
Route::post('/bulkEdit','PopupController@bulkEdit')->name('popup.admin.bulkEdit');
Route::get('/recovery','PopupController@recovery')->name('popup.admin.recovery');
