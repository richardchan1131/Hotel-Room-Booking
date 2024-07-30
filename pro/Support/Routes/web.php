<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::prefix('support')->name('support.')->group(function () {
    Route::get('/', 'SupportController@index')->name('index');
    Route::prefix('topic')->name('topic.')->group(function () {
        Route::get('/', 'Topic\TopicController@index')->name('index');
        Route::get('{slug}', 'Topic\TopicController@detail')->name('detail');
        Route::get('cat/{slug}', 'Topic\CategoryController@index')->name('cat');
        Route::get('tag/{slug}', 'Topic\TagController@index')->name('tag');
    });
    Route::prefix('ticket')->name('ticket.')->middleware('auth')->group(function () {
        Route::get('/', 'Ticket\TicketController@index')->name('index');
        Route::get('/create', 'Ticket\TicketController@create')->name('create');
        Route::post('/store/{id?}', 'Ticket\TicketController@store')->name('store');
        Route::get('/detail/{id}', 'Ticket\TicketController@detail')->name('detail');

        Route::post('/reply_store/{id}', 'Ticket\TicketController@reply_store')->name('reply_store');
        Route::post('/action/{id}', 'Ticket\TicketController@action')->name('action');

    });
    Route::prefix('note')->middleware('auth')->name('note.')->group(function () {
        Route::post('/delete/{id}', 'NoteController@delete')->name('delete');
        Route::post('/update/{id}', 'NoteController@update')->name('update');
    });
});
