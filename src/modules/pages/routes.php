<?php

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => 'web',
], function() {

    Route::post('render-page/form-submissions', 'PagesController@submitForm');
    Route::get('render-page/sitemap.{type}', 'PagesController@renderSitemap')->where('type', '(xml|html|txt|ror-rss|ror-rdf)');
    Route::get('render-page/robots.txt', 'PagesController@renderRobotsTxt');
    Route::any('render-page/{path?}', 'PagesController@renderPage')->where('path', '(.*)');

    Route::group([
        // 'prefix' => 'cp',
    ], function(){
        Route::resource('websites.pages', 'CpWebsitePagesController');
        Route::resource('websites.pages.section', 'CpWebsitePageSectionsController');
    });

});