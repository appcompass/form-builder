<?php

Route::group([
  // 'prefix' => '/',
  'namespace' => 'P3in\Controllers'
], function() {

    Route::any('render-page/{path?}', 'PagesController@renderPage')->where('path', '(.*)');

    Route::group([
        // 'prefix' => 'cp',
    ], function(){
        Route::resource('pages', 'CpPagesController');
        Route::resource('pages.section', 'CpPageSectionsController');
        Route::resource('section', 'CpSectionsController');
        Route::resource('websites.pages', 'CpWebsitePagesController');
    });

});