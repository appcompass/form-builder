<?php
Route::group([
    // 'prefix' => 'cp',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'web',
], function() {

    Route::resource('photos', 'CpPhotosController');
    Route::resource('galleries.photos', 'CpGalleryPhotosController');
    Route::get('download-gallery-photos/{galleries}', 'CpGalleryPhotosController@downloadPhotos');
});
