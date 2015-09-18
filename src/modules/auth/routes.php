<?php
Route::group([
	// 'prefix' => 'cp',
	'namespace' => 'P3in\Controllers'
], function() {

	Route::get('login', 'AuthController@getLogin');
	Route::post('login', 'AuthController@postLogin');
	Route::get('logout', 'AuthController@getLogout');
	Route::get('lock-screen', 'AuthController@getLockScreen');

});