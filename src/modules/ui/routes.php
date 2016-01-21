<?php

Route::group([
	// 'prefix' => 'cp',
	'namespace' => 'P3in\Controllers'
], function() {
    Route::get('/', 'UiController@getIndex');
    Route::get('/left-nav', 'UiController@getLeftNav');
    Route::get('/left-alerts', 'UiController@getLeftAlerts');
    Route::get('/notification-center', 'UiController@getNotificationCenter');
    Route::get('/dashboard', [
        'as' => 'dashboard',
        'uses' => 'UiController@getDashboard'
    ]);
    Route::get('/user-full-name', 'UiController@getUserFullName');
    Route::get('/user-avatar/{size}', 'UiController@getUserAvatar');
    Route::get('/user-nav', 'UiController@getUserNav');
    Route::post('/request-meta', 'UiController@postRequestMeta');

    Route::post('/delete-modal', 'UiController@postDeleteModal');

    Route::post('/clone-resource', 'UiController@postCloneResource');

});