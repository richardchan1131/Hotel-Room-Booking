<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'{module}'],function(){
    Route::get('/','CrudController@index')->name('module.admin.index');
    Route::get('/create','CrudController@create')->name('module.admin.create');
    Route::post('/store/{id}','CrudController@store')->name('module.admin.store');
    Route::get('/edit/{id}','CrudController@edit')->name('module.admin.edit');
});
