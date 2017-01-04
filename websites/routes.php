<?php

Route::group([
    'prefix' => 'api',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'api',
], function($router) {
    $router->resource('websites', WebsitesController::class);
    $router->resource('pages', PagesController::class);
    $router->resource('websites.pages', WebsitePagesController::class);
    $router->resource('menus', MenusController::class);
});