<?php

use Illuminate\Support\Facades\Route;

Route::prefix('topic')->name('support.admin.topic.')->middleware(['pro_plan'])->group(function () {
    Route::get('/', 'Topic\TopicController@index')->name('index');
    Route::get('/edit/{id}', 'Topic\TopicController@edit')->name('edit');
    Route::get('/create', 'Topic\TopicController@create')->name('create');
    Route::get('/clone/{id}', 'Topic\TopicController@clone')->name('clone');
    Route::post('/store/{id}', 'Topic\TopicController@store')->name('store');
    Route::post('/bulkEdit', 'Topic\TopicController@bulkEdit')->name('bulkEdit');

    Route::get('/category', 'Topic\CategoryController@index')->name('category.index');

    Route::get('category/getForSelect2', 'Topic\CategoryController@getForSelect2')->name('category.getForSelect2');

    Route::get('/category/edit/{id}', 'Topic\CategoryController@edit')->name('category.edit');

    Route::post('/category/store/{id}', 'Topic\CategoryController@store')->name('category.store');
    Route::post('/category/bulkEdit', 'Topic\CategoryController@bulkEdit')->name('category.bulkEdit');

    Route::get('/tag', 'Topic\TagController@index')->name('tag.index');
    Route::get('/tag/edit/{id}', 'Topic\TagController@edit')->name('tag.edit');
    Route::post('/tag/store/{id}', 'Topic\TagController@store')->name('tag.store');
    Route::post('/tag/bulkEdit', 'Topic\TagController@bulkEdit')->name('tag.bulkEdit');
});
Route::prefix('ticket')->name('support.admin.ticket.')->middleware(['pro_plan'])->group(function () {
    Route::get('/', 'Ticket\TicketController@index')->name('index');
    Route::post('/bulkEdit', 'Ticket\TicketController@bulkEdit')->name('bulkEdit');

    Route::get('/category', 'Ticket\CategoryController@index')->name('category.index');
    Route::get('category/getForSelect2', 'Ticket\CategoryController@getForSelect2')->name('category.getForSelect2');
    Route::get('/category/edit/{id}', 'Ticket\CategoryController@edit')->name('category.edit');
    Route::post('/category/store/{id}', 'Ticket\CategoryController@store')->name('category.store');
    Route::post('/category/bulkEdit', 'Ticket\CategoryController@bulkEdit')->name('category.bulkEdit');
});
