<?php

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => ['auth', 'api'],
], function ($router) {
    $router->resource('menus', MenusController::class);
    $router->resource('websites', WebsitesController::class);
    $router->resource('websites.menus', WebsiteMenusController::class);
    $router->resource('websites.navigation', WebsiteMenusController::class);
    $router->resource('websites.pages', WebsitePagesController::class);
    // $router->resource('pages', PagesController::class); // @TODO this is redundant, see below.  We don't want auth on this one but do want validateWebsite.
    $router->resource('pages.contents', PageContentsController::class); // @TODO: websites.pages.contents
    $router->resource('pages.sections', PageSectionsController::class); // @TODO: websites.pages.sections
    $router->resource('websites.settings', WebsiteSettingsController::class); // @TODO:  Discuss this, not sure it's needed anymore since L5.3 fixed their Json field API.
    $router->resource('websites.redirects', WebsiteRedirectsController::class);
});

// Public Front-end website endpoints
Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => ['web', 'validateWebsite'],
], function ($router) {
    $router->group([
        'prefix' => 'content',
    ], function($router){
        $router->get('{path?}', 'PagesController@getPageData')->where('path', '(.*)');
    });

    $router->group([
        'prefix' => 'render',
    ], function($router){
        $router->get('sitemap.{type}', 'PagesController@renderSitemap')->where('type', '(xml|html|txt|ror-rss|ror-rdf)');
        $router->get('robots.txt', 'PagesController@renderRobotsTxt');
        $router->get('{path?}', 'PagesController@renderPage')->where('path', '(.*)');
    });

    $router->group([
        'prefix' => 'forms',
    ], function($router){
        $router->get('token', function(){
            return csrf_token();
        });
        $router->post('{path?}', 'PagesController@submitForm')->where('path', '(.*)');
    });

});
