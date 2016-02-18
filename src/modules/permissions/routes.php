<?php
Route::group([
	'namespace' => 'P3in\Controllers',
    'middleware' => 'web',
], function() {
    Route::resource('permissions', 'CpPermissionsController');
    Route::resource('groups', 'CpGroupsController');
    Route::resource('groups.permissions', 'CpGroupPermissionsController');
});