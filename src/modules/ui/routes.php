<?php

Route::group([
	// 'prefix' => 'cp',
	'namespace' => 'P3in\Modules\CoreModule'
], function() {

	Route::get('/', 'CoreController@getIndex');
	Route::get('left-nav', 'CoreController@getLeftNav');
	Route::get('left-alerts', 'CoreController@getLeftAlerts');
	Route::get('notification-center', 'CoreController@getNotificationCenter');
	Route::get('dashboard', 'CoreController@getDashboard');
	Route::get('user-full-name', 'CoreController@getUserFullName');
	Route::get('user-avatar/{size}', 'CoreController@getUserAvatar');
	Route::get('user-nav', 'CoreController@getUserNav');
    // Route::controller('/', 'UiController');
});