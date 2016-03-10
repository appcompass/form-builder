<?php
Route::group([
    // 'prefix' => 'cp',
    'namespace' => 'P3in\Controllers',
    'middleware' => ['web', 'auth'],
], function() {

    Route::resource('galleries', 'CpGalleriesController');

});
