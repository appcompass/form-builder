<?php
Route::group([
	'prefix' => 'cp',
	'namespace' => 'P3in\Controllers'
], function() {

	// user routes
	Route::get('websites', 'WebsiteController@index');
	Route::post('websites', 'WebsiteController@create');

	Route::group(['prefix' => 'websites/{id}'], function () {
		Route::get('/', 'WebsiteController@show');
		Route::get('connection', 'WebsiteController@showConnection');
		Route::post('connection', 'WebsiteController@updateConnection');
		Route::get('settings', 'WebsiteController@showSettings');
	});

});