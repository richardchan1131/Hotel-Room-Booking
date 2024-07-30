<?php
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\Route;

Route::get('/check-cookie','CookieController@saveCookie')->name('core.cookie.check');
Route::get('/custom-css','StyleController@customCss')->name('core.style.customCss');

Route::group(['prefix'=>'notify','middleware'=>'auth'],function(){
    Route::post('markAsRead','NotificationController@markAsRead')->name('core.notification.markAsRead');
    Route::post('markAllAsRead','NotificationController@markAllAsRead')->name('core.notification.markAllAsRead');
    Route::get('notifications','NotificationController@loadNotify')->name('core.notification.loadNotify');
});

Route::get('sitemap.xml','SitemapController@index')->name('sitemap.index');
Route::get('sitemap-{id}.xml','SitemapController@path')->name('sitemap.path');

Route::get('tools/clear-cache', 'ToolsController@clearCache')->name('core.tool.clearCache');
