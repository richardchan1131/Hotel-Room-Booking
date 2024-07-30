<?php
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Route;

Route::get('t.gif','TrackingController@track');
Route::get('update_tracking_cpc','TrackingController@update_tracking_cpc')->name('tracking.update_tracking_cpc');
Route::get('tracking/go/{id}','TrackingController@go')->name('tracking.go');
Route::get('tracking/test2','TrackingController@test');
Route::get('update_vendor_tracking','TrackingController@tool_update_vendor_tracking');
