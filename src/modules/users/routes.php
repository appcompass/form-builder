<?php
Route::group([
	// 'prefix' => 'cp',
	'namespace' => 'P3in\Controllers'
], function() {

	// user routes
	Route::get('users', 'UserController@getIndex');

});