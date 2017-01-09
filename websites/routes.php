<?php

Route::group([
    // 'prefix' => 'api',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'api',
], function($router) {
    $router->resource('websites', WebsitesController::class);
    $router->resource('websites.pages', WebsitePagesController::class);
    // $router->resource('websites.pages.sections', WebsitePagesSectionsController::class);
    $router->resource('websites.menus', WebsiteMenusController::class);

    // $router->resource('websites.settings', 'WebsiteSettingsController');
    // $router->resource('websites.redirects', 'WebsiteRedirectsController');

    // @QUESTION: menus are web specific, do we need this?
    $router->resource('menus', MenusController::class);

    // Public Front-end website endpoints
    $router->group([
        'middleware' => 'web',
    ], function($router){

        // $router->post('render-page/form-submissions', 'PagesController@submitForm');
        // $router->get('render-page/sitemap.{type}', 'PagesController@renderSitemap')->where('type', '(xml|html|txt|ror-rss|ror-rdf)');
        // $router->get('render-page/robots.txt', 'PagesController@renderRobotsTxt');
        // $router->any('render-page/{path?}', 'PagesController@renderPage')->where('path', '(.*)');

    });
});