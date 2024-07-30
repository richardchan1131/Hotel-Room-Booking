<?php

use \Illuminate\Support\Facades\Route;

Route::get('/','DashboardController@index')->name('admin.index');
