<?php
use \Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'payout'],function(){
    Route::get('/','PayoutController@index')->name('vendor.admin.payout.index');
    Route::post('/bulkEdit','PayoutController@bulkEdit')->name('vendor.admin.payout.bulkEdit');
});
Route::group(['prefix'=>'plan'],function(){
    Route::get('/','PlanController@index')->name('vendor.admin.plan.index');
    Route::get('/create','PlanController@create')->name('vendor.admin.plan.create');
    Route::get('/edit/{id}','PlanController@edit')->name('vendor.admin.plan.edit');
    Route::get('/getForSelect2','PlanController@getForSelect2')->name('vendor.admin.plan.getForSelect2');
    Route::post('/bulkEdit','PlanController@bulkEdit')->name('vendor.admin.plan.bulkEdit');
});
