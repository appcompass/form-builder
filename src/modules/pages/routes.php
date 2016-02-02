<?php

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => 'web',
], function() {

    Route::post('render-page/form-submissions', 'PagesController@submitForm');

    Route::any('render-page/{path?}', 'PagesController@renderPage')->where('path', '(.*)');

    Route::group([
        // 'prefix' => 'cp',
    ], function(){
        Route::resource('websites.pages', 'CpWebsitePagesController');
        Route::resource('websites.pages.section', 'CpWebsitePageSectionsController');
    });

});