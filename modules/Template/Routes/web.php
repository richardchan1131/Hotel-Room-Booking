<?php

use Illuminate\Support\Facades\Route;

Route::get('template/preview/{template}', 'LiveController@preview')->name('template.preview');
