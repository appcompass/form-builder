<?php
Route::group([
	'prefix' => 'cp',
	'namespace' => 'P3in\Controllers'
], function() {

	// website routes
	Route::resource('websites', 'CpWebsiteController');
	Route::resource('websites.settings', 'CpWebsiteSettingsController');

	Route::resource('websites.pages', 'CpWebsitePagesController');

});