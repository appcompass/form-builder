<?php
Route::group([
	'prefix' => 'cp',
	'namespace' => 'P3in\Controllers'
], function() {

	// website routes
	Route::resource('websites', 'CpWebsiteController');
	Route::resource('websites.settings', 'CpWebsiteSettingsController');

	// this should be moved to pages?
	Route::resource('websites.pages', 'CpWebsitePagesController');

});