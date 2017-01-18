<?php

Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    // $router->resource('addresses', 'AddressesController');
});
