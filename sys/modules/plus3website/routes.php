<?php
use Facebook\Facebook;

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => 'auth:api',
], function ($router) {
});
Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => ['web', 'validateWebsite'],
], function ($router) {
    $router->group([
        'prefix' => 'facebook',
    ], function ($router) {
        $router->get('feed', 'FacebookController@getFeed');
    });
});
