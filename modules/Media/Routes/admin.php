<?php
use Illuminate\Support\Facades\Route;
Route::get('/','MediaController@index')->name('media.admin.index');
Route::post('/getLists','MediaController@getLists')->name('media.admin.getLists')->withoutMiddleware('dashboard');

Route::post('/edit_image','MediaController@editImage')->name('media.admin.edit.image');
