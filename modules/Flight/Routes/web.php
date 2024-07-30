<?php
use \Illuminate\Support\Facades\Route;

Route::group(['prefix'=>config('flight.flight_route_prefix')],function(){
    Route::get('/','FlightController@index')->name('flight.search'); // Search
    Route::post('getData/{id}',"FlightController@getData")->name('flight.getData');


    Route::get('/airport/search','AirportController@search')->name('flight.airport.search'); // Search
});


Route::group(['prefix'=>'user/'.config('flight.flight_route_prefix'),'middleware' => ['auth','verified']],function(){
    Route::get('/','ManageFlightController@manageFlight')->name('flight.vendor.index');
    Route::get('/create','ManageFlightController@createFlight')->name('flight.vendor.create');
    Route::get('/edit/{id}','ManageFlightController@editFlight')->name('flight.vendor.edit');
    Route::get('/del/{id}','ManageFlightController@deleteFlight')->name('flight.vendor.delete');
    Route::post('/store/{id}','ManageFlightController@store')->name('flight.vendor.store');
    Route::get('bulkEdit/{id}','ManageFlightController@bulkEditFlight')->name("flight.vendor.bulk_edit");
    Route::get('/booking-report/bulkEdit/{id}','ManageFlightController@bookingReportBulkEdit')->name("flight.vendor.booking_report.bulk_edit");
	Route::get('clone/{id}','ManageFlightController@cloneFlight')->name("flight.vendor.clone");
    Route::get('/recovery','ManageFlightController@recovery')->name('flight.vendor.recovery');
    Route::get('/restore/{id}','ManageFlightController@restore')->name('flight.vendor.restore');

    Route::group(['prefix'=>'{flight_id}/flight-seat'],function (){
        Route::get('/','ManageFlightSeatController@index')->name('flight.vendor.seat.index');
        Route::get('create','ManageFlightSeatController@create')->name('flight.vendor.seat.create');
        Route::get('edit/{id}','ManageFlightSeatController@edit')->name('flight.vendor.seat.edit');
        Route::post('store/{id}','ManageFlightSeatController@store')->name('flight.vendor.seat.store');
        Route::post('delete/{id}','ManageFlightSeatController@delete')->name('flight.vendor.seat.delete');
        Route::post('/bulkEdit','ManageFlightSeatController@bulkEdit')->name('flight.vendor.seat.bulkEdit');
    });
});

