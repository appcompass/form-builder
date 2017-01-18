<?php

Route::group([
    'prefix' => 'auth',
    'namespace' => 'P3in\Controllers',
], function ($router) {
    $router->post('login', 'AuthController@login')->middleware('guest');
    $router->get('logout', 'AuthController@logout')->middleware('auth:api');
});

Route::group([
    // 'prefix' => 'api',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'auth:api',
], function ($router) {

    $router->resource('users', UsersController::class);
    $router->resource('groups', GroupsController::class);
    $router->resource('permissions', PermissionsController::class);
    $router->resource('users.groups', UserGroupsController::class);
    $router->resource('users.permissions', UserPermissionsController::class);

});
