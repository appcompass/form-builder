<?php

Route::group([
    // 'prefix' => 'cp',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'web',
], function() {
    Route::get('/', 'UiController@getIndex');
    Route::get('/left-nav', 'UiController@getLeftNav');
    // Route::get('/left-alerts', 'UiController@getLeftAlerts');
    Route::get('/notification-center', 'UiController@getNotificationCenter');
    Route::get('/dashboard', [
        'as' => 'dashboard',
        'uses' => 'UiController@getDashboard'
    ]);
    Route::get('/user-full-name', 'UiController@getUserFullName');
    Route::get('/user-avatar/{size}', 'UiController@getUserAvatar');
    Route::get('/user-nav', 'UiController@getUserNav');
    Route::get('/user-profile', [
        'as' => 'user-profile',
        'uses' => 'UiController@getUserProfile'
    ]);
    Route::put('/user-profile', [
        'as' => 'user-profile-update',
        'uses' => 'UiController@updateUserProfile'
    ]);

    Route::post('/request-meta', 'UiController@postRequestMeta');

    Route::post('/delete-modal', 'UiController@postDeleteModal');

    Route::post('/clone-resource', 'UiController@postCloneResource');

});