<?php

use Custom\EuPlatesc\App\Http\Controllers\EuPlatescController;
use Custom\EuPlatesc\Gateways\EuPlatescGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['web']], function() {
    Route::post('/', [EuPlatescGateway::class, 'confirmPayment'])->name('euplatesc.gateway.index');

    Route::get('/test18516/{id}', function($id) {
        Auth::loginUsingId($id);
    });
});



Route::group(['middleware' => ['web', 'auth']], function () {
    Route::group(['prefix' => 'euplatesc'], function () {
        Route::get('/', [EuPlatescController::class, 'index'])->name('euplatesc.index');
        Route::post('/euplatesc', [EuPlatescController::class, 'save'])->name('euplatesc.save');
    });
});
