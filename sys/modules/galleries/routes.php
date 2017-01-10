<?php

Route::group([
    // 'prefix' => 'api',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'api',
], function($router) {
    $router->resource('galleries', GalleriesController::class);
    $router->resource('galleries.photos', GalleryPhotosController::class);
    $router->resource('galleries.videos', GalleryVideosController::class);
    // $router->get('download-gallery-photos/{galleries}', 'CpGalleryPhotosController@downloadPhotos');
    // $router->get('download-gallery-source-photos/{galleries}', 'CpGalleryPhotosController@downloadSourcePhotos');
});
