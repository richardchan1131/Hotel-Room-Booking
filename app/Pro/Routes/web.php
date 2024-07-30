<?php

use \Illuminate\Support\Facades\Route;

Route::prefix('pro')->name('pro.')->middleware(['web', 'auth', 'dashboard'])->group(function () {
    Route::get('/upgrade', [\App\Pro\Controllers\UpgradeController::class, 'index'])->name('upgrade');
    Route::post('/buy', [\App\Pro\Controllers\BuyController::class, 'index'])->name('buy');
});
