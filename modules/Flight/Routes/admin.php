<?php

use \Illuminate\Support\Facades\Route;


Route::get('/','FlightController@index')->name('flight.admin.index');
Route::get('/create','FlightController@create')->name('flight.admin.create');
Route::get('/edit/{id}','FlightController@edit')->name('flight.admin.edit');
Route::post('/store/{id}','FlightController@store')->name('flight.admin.store');
Route::post('/bulkEdit','FlightController@bulkEdit')->name('flight.admin.bulkEdit');
Route::get('/recovery','FlightController@recovery')->name('flight.admin.recovery');

Route::group(['prefix'=>'{flight_id}/flight-seat'],function (){
    Route::get('/','FlightSeatController@index')->name('flight.admin.flight.seat.index');
    Route::get('edit/{id}','FlightSeatController@edit')->name('flight.admin.flight.seat.edit');
    Route::post('store/{id}','FlightSeatController@store')->name('flight.admin.flight.seat.store');
    Route::post('/bulkEdit','FlightSeatController@bulkEdit')->name('flight.admin.flight.seat.bulkEdit');
});
Route::group(['prefix'=>'airline'],function (){
    Route::get('/','AirlineController@index')->name('flight.admin.airline.index');
    Route::get('edit/{id}','AirlineController@edit')->name('flight.admin.airline.edit');
    Route::post('store/{id}','AirlineController@store')->name('flight.admin.airline.store');
    Route::post('/bulkEdit','AirlineController@bulkEdit')->name('flight.admin.airline.bulkEdit');
});
Route::group(['prefix'=>'airport'],function (){
    Route::get('/','AirportController@index')->name('flight.admin.airport.index');
    Route::get('edit/{id}','AirportController@edit')->name('flight.admin.airport.edit');
    Route::post('store/{id}','AirportController@store')->name('flight.admin.airport.store');
    Route::post('/bulkEdit','AirportController@bulkEdit')->name('flight.admin.airport.bulkEdit');
    Route::get('/import-iata','AirportController@importIATA')->name('flight.admin.airport.importIATA')->middleware('signed');

});
Route::group(['prefix'=>'seat-type'],function (){
    Route::get('/','SeatTypeController@index')->name('flight.admin.seat_type.index');
    Route::get('edit/{id}','SeatTypeController@edit')->name('flight.admin.seat_type.edit');
    Route::post('store/{id}','SeatTypeController@store')->name('flight.admin.seat_type.store');
    Route::post('/bulkEdit','SeatTypeController@bulkEdit')->name('flight.admin.seat_type.bulkEdit');

});
Route::group(['prefix'=>'attribute'],function (){
    Route::get('/','AttributeController@index')->name('flight.admin.attribute.index');
    Route::get('edit/{id}','AttributeController@edit')->name('flight.admin.attribute.edit');
    Route::post('store/{id}','AttributeController@store')->name('flight.admin.attribute.store');
    Route::post('/editAttrBulk','AttributeController@editAttrBulk')->name('flight.admin.attribute.bulkEdit');

    Route::get('terms/{id}','AttributeController@terms')->name('flight.admin.attribute.term.index');
    Route::get('term_edit/{id}','AttributeController@term_edit')->name('flight.admin.attribute.term.edit');
    Route::match(['get','post'],'term_store','AttributeController@term_store')->name('flight.admin.attribute.term.store');
    Route::post('/editTermBulk','AttributeController@editTermBulk')->name('flight.admin.attribute.editTermBulk');
});
