<?php
Route::group([
	'prefix' => 'cp',
	'namespace' => 'P3in\Controllers'
], function() {

	// website routes
	Route::resource('websites', 'CpWebsiteController');
	Route::resource('websites.settings', 'CpWebsiteSettingsController');

	// this should be moved to pages?
  // F: I'm not sure, because it handles pages through websites, that's why i've left it here
	Route::resource('websites.pages', 'CpWebsitePagesController');

});