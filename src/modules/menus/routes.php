<?php

// Route::resource('nav', 'P3in\Controllers\NavigationController');

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => 'web',
], function() {

    Route::post('/websites/{website}/link', '\P3in\Controllers\MenusController@addLink');
    Route::delete('/websites/{website}/link/{link}', '\P3in\Controllers\MenusController@deleteLink');
    Route::resource('websites.menus', MenusController::class);

});
