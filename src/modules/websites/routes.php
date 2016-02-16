<?php
Route::group([
    // 'prefix' => 'cp',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'web'
], function() {

    // website routes
    Route::resource('websites', 'CpWebsiteController');
    Route::resource('websites.settings', 'CpWebsiteSettingsController');
    Route::resource('websites.redirects', 'CpWebsiteRedirectsController');
});