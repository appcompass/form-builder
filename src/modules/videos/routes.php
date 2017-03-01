<?php
Route::group([
    // 'prefix' => 'cp',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'web',
], function() {

    Route::resource('videos', 'CpVideosController');
    Route::resource('galleries.videos', 'CpGalleryVideosController');

});
