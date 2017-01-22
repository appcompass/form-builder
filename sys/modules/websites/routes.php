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
    $router->resource('pages', PagesController::class);
    $router->resource('pages.contents', PageContentsController::class); // @TODO: websites.pages.contents
    $router->resource('pages.sections', PageSectionsController::class); // @TODO: websites.pages.sections
    $router->resource('websites.settings', WebsiteSettingsController::class); // @TODO:  Discuss this, not sure it's needed anymore since L5.3 fixed their Json field API.
    $router->resource('websites.redirects', WebsiteRedirectsController::class);
});

// Public Front-end website endpoints
Route::group([
    'prefix' => 'render',
    'namespace' => 'P3in\Controllers',
    'middleware' => ['web', 'validateWebsite'],
], function ($router) {
    // $router->post('form-submissions', 'PagesController@submitForm');
    // $router->get('sitemap.{type}', 'PagesController@renderSitemap')->where('type', '(xml|html|txt|ror-rss|ror-rdf)');
    // $router->get('robots.txt', 'PagesController@renderRobotsTxt');
    $router->any('{path?}', 'PagesController@renderPage')->where('path', '(.*)');
});
