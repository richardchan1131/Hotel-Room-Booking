<?php
use \Illuminate\Support\Facades\Route;

Route::get('term/getForSelect2','TermController@index')->name('core.admin.term.getForSelect2');
Route::post('markAsRead','NotificationController@markAsRead')->name('core.admin.notification.markAsRead');
Route::post('markAllAsRead','NotificationController@markAllAsRead')->name('core.admin.notification.markAllAsRead');
Route::get('notifications','NotificationController@loadNotify')->name('core.admin.notification.loadNotify');


Route::group(['prefix'=>'updater'],function (){
    Route::get('/','UpdaterController@index')->name('core.admin.updater.index');
    Route::post('/store_license','UpdaterController@storeLicense')->name('core.admin.updater.store_license');
    Route::post('/check_update','UpdaterController@checkUpdate')->name('core.admin.updater.check_update');
    Route::post('/do_update','UpdaterController@doUpdate')->name('core.admin.updater.do_update');
});

Route::get('settings/index/{group}', 'SettingsController@index')->name('core.admin.settings.index');
Route::post('settings/store/{group}', 'SettingsController@store')->name('core.admin.settings.store');

Route::get('tools', 'ToolsController@index')->name('core.admin.tool.index');

Route::group(['prefix' => 'menu'], function () {
    Route::get('/', 'MenuController@index')->name('core.admin.menu.index');
    Route::get('/create', 'MenuController@create')->name('core.admin.menu.create');
    Route::get('/edit/{id}', 'MenuController@edit')->name('core.admin.menu.edit');
    Route::post('/store', 'MenuController@store')->name('core.admin.menu.store');
    Route::post('/getTypes', 'MenuController@getTypes')->name('core.admin.menu.getTypes');
    Route::post('/searchTypeItems','MenuController@searchTypeItems')->name('core.admin.menu.searchTypeItems');

    Route::post('/bulkEdit','MenuController@bulkEdit')->name('core.admin.menu.bulkEdit');

});

Route::group(['prefix'=>'module'],function (){
    Route::get('/','ModuleController@index')->name('core.admin.module.index');
    Route::post('/bulkEdit','ModuleController@bulkEdit')->name('core.admin.module.bulkEdit');
});
