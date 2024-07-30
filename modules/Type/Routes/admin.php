<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'{type}/'],function(){
    Route::get('/','TypeController@index')->name('type.admin.index');
    Route::get('/create','TypeController@create')->name('type.admin.create');
    Route::get('/edit/{id}','TypeController@edit')->name('type.admin.edit');
    Route::post('/store/{id}','TypeController@store')->name('type.admin.store');
    Route::post('/bulkEdit','TypeController@bulkEdit')->name('type.admin.bulkEdit');
    Route::get('/recovery','TypeController@recovery')->name('type.admin.recovery');

    Route::group(['prefix'=>'attribute'],function(){
        Route::get('/','AttributeController@index')->name('type.admin.attribute.index');
        Route::get('/edit/{id}','AttributeController@edit')->name('type.admin.attribute.edit');
        Route::post('/store/{id}','AttributeController@store')->name('type.admin.attribute.store');
        Route::post('/editAttrBulk','AttributeController@editAttrBulk')->name('type.admin.attribute.editAttrBulk');


        Route::get('/terms/{attr_id}','AttributeController@terms')->name('type.admin.attribute.term.index');
        Route::get('/term_edit/{id}','AttributeController@term_edit')->name('type.admin.attribute.term.edit');
        Route::post('/term_store/{id}','AttributeController@term_store')->name('type.admin.attribute.term.store');
        Route::post('/editTermBulk','AttributeController@editTermBulk')->name('type.admin.attribute.term.editTermBulk');
    });
});
