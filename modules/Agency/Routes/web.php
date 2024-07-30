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

Route::group(['prefix'=> 'agency'],function(){
    Route::get('/','AgenciesController@index')->name('agencies.search');
    Route::get('/{slug}','AgenciesController@detail')->name('agencies.detail');
});

Route::group(['prefix'=> 'agent'],function() {
    Route::get('/','AgentController@index')->name('agent.search');
    // Route::match(['get'],'/agentContact','AgentController@getAgentContact')->name('agent.getAgentContact');
    Route::get('/{id}','AgentController@detail')->name('agent.detail');
    Route::match(['post'],'/contactAgent','AgentController@submitDetailContact')->name('agent.contact');

    // Route::get('/getAgentContact','AgentController@getAgentContact')->name('agent.getAgentContact');
});
    Route::group(['prefix'=>'user/agency','middleware' => ['auth','verified']],function(){
        Route::get('/','AgencyManagerController@manageAgency')->name('agency.vendor.index');
        Route::get('/edit/{id}','AgencyManagerController@edit')->name('agency.vendor.edit');
        Route::post('/store/{id}','AgencyManagerController@store')->name('agency.vendor.store');
        Route::prefix('{agency_id}/agent')->group(function (){
            Route::get('/list','AgencyManagerController@listAgent')->name('agency.vendor.agent.index');
            Route::post('/store','AgencyManagerController@storeAgent')->name('agency.vendor.agent.store');
            Route::get('/remove/{id}','AgencyManagerController@removeAgent')->name('agency.vendor.agent.remove');
        });
    });

Route::post('/vendor/register','\\Modules\\Vendor\\Controllers\\VendorController@register')->name('vendor.register');
