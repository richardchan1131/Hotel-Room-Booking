<?php
use Illuminate\Support\Facades\Route;

Route::get('/','ContactController@index')->name('contact.admin.index');
Route::post('/bulkEdit','ContactController@bulkEdit')->name('contact.admin.bulkEdit');

Route::get('getForSelect2','ContactController@getForSelect2')->name('contact.admin.getForSelect2');
