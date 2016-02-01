<?php
Route::group([
    // 'prefix' => 'cp',
    'namespace' => 'P3in\Controllers'
], function() {

    Route::resource('photos', 'CpPhotosController');
    Route::resource('galleries.photos', 'CpGalleryPhotosController');

});