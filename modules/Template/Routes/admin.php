<?php

use Illuminate\Support\Facades\Route;

Route::match(['get'], '/edit/{id}', 'TemplateController@edit')->name('template.admin.edit');

Route::get('/getForSelect2', 'TemplateController@getForSelect2')->name('template.admin.getForSelect2');
Route::get('/getBlocks', 'TemplateController@getBlocks')->name('template.admin.getBlocks');

Route::post('/store', 'TemplateController@store')->name('template.admin.store');

//import/export
Route::match(['get', 'post'], '/importTemplate', 'TemplateController@importTemplate')->name('template.admin.importTemplate');
Route::match(['get'], '/exportTemplate/{id}', 'TemplateController@exportTemplate')->name('template.admin.exportTemplate');

Route::group(['prefix' => 'live', 'as' => 'template.admin.live.'], function () {
    Route::get('/{template}', 'LiveEditorController@index')->name('index');
    Route::post('/block-preview', 'LiveEditorController@preview')->name('preview');
});
