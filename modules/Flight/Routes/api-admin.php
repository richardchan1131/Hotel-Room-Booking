<?php
    Route::group(['prefix'=>'airline'],function (){
        Route::get('/getForSelect2','AirlineController@getForSelect2')->name('flight.admin.airline.getForSelect2');
    });
    Route::group(['prefix'=>'airport'],function (){
        Route::get('/getForSelect2','AirportController@getForSelect2')->name('flight.admin.airport.getForSelect2');
    });
    Route::group(['prefix'=>'seat-type'],function (){
        Route::get('getForSelect2','SeatTypeController@getForSelect2')->name('flight.admin.seat_type.getForSelect2');
    });
    Route::group(['prefix'=>'attribute'],function (){
        Route::get('getForSelect2','AttributeController@getForSelect2')->name('flight.admin.attribute.term.getForSelect2');
    });
    ;?>