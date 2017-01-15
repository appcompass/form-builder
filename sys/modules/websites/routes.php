<?php

Route::group([
    // 'prefix' => 'api',
    'namespace' => 'P3in\Controllers',
    'middleware' => 'api',
], function ($router) {
    $router->resource('websites', WebsitesController::class);
    $router->resource('websites.menus', WebsiteMenusController::class);
    $router->resource('websites.navigation', WebsiteMenusController::class);
    $router->resource('websites.pages', WebsitePagesController::class);
    $router->resource('pages.contents', PageContentsController::class); // @TODO: websites.pages.contents
    $router->resource('websites.settings', WebsiteSettingsController::class);
    $router->resource('websites.redirects', WebsiteRedirectsController::class);

    $router->resource('menus', MenusController::class);

    // Public Front-end website endpoints
    $router->group([
        'prefix' => 'render',
        'middleware' => 'web',
    ], function ($router) {

        // $router->post('form-submissions', 'PagesController@submitForm');
        // $router->get('sitemap.{type}', 'PagesController@renderSitemap')->where('type', '(xml|html|txt|ror-rss|ror-rdf)');
        // $router->get('robots.txt', 'PagesController@renderRobotsTxt');
        // $router->any('{path?}', 'PagesController@renderPage')->where('path', '(.*)');
    });
});
