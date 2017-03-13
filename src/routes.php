<?php

Route::group([
    'prefix' => 'auth',
    'namespace' => 'P3in\Controllers',
], function ($router) {
    $router->post('login', 'AuthController@login');
    $router->get('logout', 'AuthController@logout')->middleware(['auth']);
    $router->get('user', 'AuthController@user')->middleware('auth');
});

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => ['auth', 'api']
], function ($router) {
    // $router->get('notification-center', 'CpController@getNotificationCenter');
    // $router->get('dashboard', 'CpController@getDashboard');
    $router->resource('users', UsersController::class);
    $router->resource('roles', RolesController::class);
    $router->resource('roles.permissions', RolePermissionsController::class);
    $router->resource('permissions', PermissionsController::class);
    $router->resource('users.roles', UserRolesController::class);
    $router->resource('users.permissions', UserPermissionsController::class);

    $router->resource('galleries', GalleriesController::class);
    $router->resource('galleries.photos', GalleryPhotosController::class);
    $router->post('galleries/{gallery}/photos/sort', 'GalleryPhotosController@sort'); // @TODO see about this
    $router->resource('galleries.videos', GalleryVideosController::class);

    $router->delete('menus/links/{link_id}', 'MenusController@deleteLink');
    $router->resource('menus', MenusController::class);
    $router->resource('pages', PagesController::class);
    $router->resource('pages.contents', PageContentController::class);
    // @TODO use generic forms getter once that's done (maybe)
    $router->get('menus/forms/{form}', 'MenusController@getForm');
    $router->post('menus/forms/{form}', 'MenusController@storeForm');
    $router->resource('websites', WebsitesController::class);
    $router->resource('websites.menus', WebsiteMenusController::class);
    $router->resource('websites.navigation', WebsiteMenusController::class);
    $router->resource('websites.pages', WebsitePagesController::class);
    // $router->resource('pages.contents', PageContentsController::class); // @TODO: websites.pages.contents
    // $router->resource('pages.sections', PageSectionsController::class); // @TODO: websites.pages.sections
    $router->resource('websites.redirects', WebsiteRedirectsController::class);

    $router->resource('resources', ResourcesController::class);
    $router->resource('forms', FormsController::class);
});

// Public Front-end website endpoints
Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => ['web'],
], function ($router) {
    $router->group([
        'prefix' => 'content',
    ], function ($router) {
        $router->get('menus', 'PublicWebsiteController@getSiteMenus');
        $router->get('site-meta', 'PublicWebsiteController@getSiteMeta');
        $router->get('{path?}', 'PublicWebsiteController@getPageData')->where('path', '(.*)');
    });

    $router->group([
        'prefix' => 'render',
    ], function ($router) {
        $router->get('sitemap.{type}', 'PublicWebsiteController@renderSitemap')->where('type', '(xml|html|txt|ror-rss|ror-rdf)');
        $router->get('robots.txt', 'PublicWebsiteController@renderRobotsTxt');
    });

    $router->group([
        'prefix' => 'forms',
    ], function ($router) {
        $router->get('token', 'PublicWebsiteController@getToken');
        $router->post('{path?}', 'PublicWebsiteController@submitForm')->where('path', '(.*)');
    });
});