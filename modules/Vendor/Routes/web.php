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
Route::group(['prefix'=>'vendor'],function(){
    Route::post('/register','VendorController@register')->name('vendor.register');

});

Route::group(['prefix'=>'vendor','middleware' => ['auth']],function(){
    Route::match(['get'],'/payouts','PayoutController@index')->name("vendor.payout.index");
    Route::post('/storePayoutAccounts','PayoutController@storePayoutAccounts')->name("vendor.payout.storePayoutAccounts");
    Route::post('/createPayoutRequest','PayoutController@createPayoutRequest')->name("vendor.payout.createPayoutRequest");

    Route::get('/booking-report','VendorController@bookingReport')->name("vendor.bookingReport");

    Route::prefix('team')->name('vendor.team.')->group(function(){
        Route::get('/','TeamController@index')->name("index");
        Route::post('/add','TeamController@add')->name("add");
        Route::get('/edit/{vendorTeam}','TeamController@edit')->name("edit");
        Route::get('/reSendRequest/{vendorTeam}','TeamController@reSendRequest')->name("re-send-request");
        Route::post('/store/{vendorTeam}','TeamController@store')->name("store");
        Route::get('/delete/{vendorTeam}','TeamController@delete')->name("delete")->middleware('signed');
    });

});

Route::group(['prefix'=>'vendor/enquiry-report'],function(){
    Route::get('/','EnquiryController@enquiryReport')->name("vendor.enquiry_report");
    Route::get('/bulkEdit/{id}','EnquiryController@enquiryReportBulkEdit')->name("vendor.enquiry_report.bulk_edit")->middleware(['signed']);
    Route::get('/{enquiry}/reply','EnquiryController@reply')->name('vendor.enquiry_report.reply');
    Route::post('/{enquiry}/reply/store','EnquiryController@replyStore')->name('vendor.enquiry_report.replyStore');
    Route::get('/del/{id}','EnquiryController@delete')->name('vendor.enquiry_report.delete');
});


Route::get('team-accept','TeamController@accept')->name('team-accept')->middleware('signed');
