<?php

// Route::resource('nav', 'P3in\Controllers\NavigationController');

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => 'web',
], function() {

    Route::resource('websites.menus', MenusController::class);

});
