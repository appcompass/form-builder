<?php

// Route::resource('nav', 'P3in\Controllers\NavigationController');

Route::group([
  'namespace' => 'P3in\Controllers'
  ], function() {

  Route::resource('websites.navigation', 'CpWebsiteNavigationController');

});
