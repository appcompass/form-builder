<?php
// cp routes
Route::group([
    'prefix' => '/auth',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'web',
], function() {

    Route::get('login', 'AuthCpController@getLogin');
    Route::post('login', 'AuthCpController@postLogin');
    Route::get('logout', 'AuthCpController@getLogout');
    Route::get('lock-screen', 'AuthCpController@getLockScreen');
    Route::controller('', 'PasswordController');

});