<?php

Route::group([
    'prefix' => 'api',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'api',
], function($router) {
    $router->resource('users', UsersController::class);
    $router->resource('groups', GroupsController::class);
    $router->resource('permissions', PermissionsController::class);
    $router->resource('users/{user}/groups', UserGroupsController::class);
    $router->resource('users/{user}/permissions', UserPermissionsController::class);
});