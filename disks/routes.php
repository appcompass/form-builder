<?php

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => ['auth', 'api']
], function ($router) {
    $router->resource('storage', DiskController::class);
});
