<?php

Route::group([
    // 'prefix' => 'api',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'api',
], function ($router) {
    // $router->get('notification-center', 'CpController@getNotificationCenter');
    // $router->get('dashboard', 'CpController@getDashboard');
});

Route::get('', function () {
    return '';
});
