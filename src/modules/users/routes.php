<?php
Route::group([
    // 'prefix' => 'cp',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'web',
], function() {

    // website routes
    Route::resource('users', 'CpUsersController');

});