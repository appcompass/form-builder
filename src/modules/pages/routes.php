<?php

Route::group([
  // 'prefix' => '/',
  'namespace' => 'P3in\Controllers'
], function() {

    Route::any('render-page/{path?}', 'PagesController@renderPage')->where('path', '(.*)');

    Route::group([
        // 'prefix' => 'cp',
    ], function(){
        Route::resource('websites.pages', 'CpWebsitePagesController');
        Route::resource('websites.pages.section', 'CpWebsitePageSectionsController');
    });

});