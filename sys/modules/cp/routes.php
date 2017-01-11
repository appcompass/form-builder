<?php

Route::group([
    // 'prefix' => 'api',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'api',
], function($router) {
    // $router->get('notification-center', 'CpController@getNotificationCenter');
    // $router->get('dashboard', 'CpController@getDashboard');


    // // T@ODO: some day, it would be nice to allow this route to be the
    // // index of any UI that uses this API where it takes into account
    // // the authorized client's permissions on each route.
    // $router->get('', function () use ($router) {
    //     $rtn = [];
    //     foreach ($router->getRoutes() as $route) {
    //         $rtn[] = [
    //             'methods' => $route->getMethods(),
    //             'path' => $route->getPath(),
    //         ];
    //     }
    //     return $rtn;
    // });
});