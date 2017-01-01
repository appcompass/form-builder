<?php

Route::group([
    'prefix' => 'api',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'api',
], function($router) {
    $router->resource('galleries', GalleriesController::class);
});
