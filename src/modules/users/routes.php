<?php
Route::group([
    // 'prefix' => 'cp',
    'namespace' => 'P3in\Controllers'
], function() {

    // website routes
    Route::resource('users', 'CpUsersController');

});