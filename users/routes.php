<?php

Route::group([
    // 'prefix' => 'api',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'api',
], function ($router) {
    $router->resource('users', UsersController::class);
    $router->resource('groups', GroupsController::class);
    $router->resource('permissions', PermissionsController::class);
    $router->resource('users.groups', UserGroupsController::class);
    $router->resource('users.permissions', UserPermissionsController::class);

    // $router->get('login', 'AuthCpController@getLogin');
    // $router->post('login', 'AuthCpController@postLogin');
    // $router->get('logout', 'AuthCpController@getLogout');

    // $router->get('lock-screen', 'AuthCpController@getLockScreen');
    // $router->post('lock-screen', 'AuthCpController@postLockScreen');
});
