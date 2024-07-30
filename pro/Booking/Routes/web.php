<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->namespace('\\Pro\\Booking\\Controllers')->group(function () {
    Route::prefix('user/booking')->name('user.booking.')->middleware(['auth', 'pro_plan'])->group(function () {
        Route::get('{code}/ticket', 'TicketController@index')->name('ticket');
        Route::get('ticket/scan/{b}/{t}', 'TicketController@scan')->name('ticket.scan');
    });
});
