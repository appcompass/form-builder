<?php
Route::group([
	// 'prefix' => 'cp',
	'namespace' => 'P3in\Controllers'
], function() {

	// user routes
	Route::get('users', 'UserController@getIndex');
	Route::get('users/web-users', 'UserController@getWebUsers');
	Route::get('users/agents', 'UserController@getAgents');
	Route::get('users/landlords', 'UserController@getAgents');

});