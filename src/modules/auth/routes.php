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

});

// // public routes
// Route::group([
//  'prefix' => 'auth',
//  'namespace' => 'P3in\Controllers'
// ], function() {

//  Route::get('login', 'AuthController@getLogin');
//  Route::post('login', 'AuthController@postLogin');
//  Route::get('logout', 'AuthController@getLogout');

// });