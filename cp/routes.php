<?php

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => 'auth:api',
], function ($router) {
    // $router->get('notification-center', 'CpController@getNotificationCenter');
    // $router->get('dashboard', 'CpController@getDashboard');
    // $router->resource('storage', StorageController::class);
});

