<?php
    use Illuminate\Support\Facades\Route;

    Route::get('/testSms','SmsController@testSms')->name('sms.admin.testSms');
