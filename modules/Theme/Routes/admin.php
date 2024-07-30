<?php
use \Illuminate\Support\Facades\Route;

Route::get('/', 'ThemeController@index')->name('theme.admin.index');
Route::post('active/{theme}', 'ThemeController@activate')->name('theme.admin.activate');
Route::post('seeding/{theme}', 'ThemeController@seeding')->name('theme.admin.seeding');
