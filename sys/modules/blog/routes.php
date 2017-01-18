<?php

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => 'auth:api',
], function ($router) {

    // $router->resource('websites.blog-entries', 'CpWebsiteBlogEntriesController');
    // $router->resource('websites.blog-categories', 'CpWebsiteBlogCategoriesController');
    // $router->resource('websites.blog-tags', 'CpWebsiteBlogTagsController');
});
