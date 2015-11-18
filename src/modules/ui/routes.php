<?php

Route::group([
	// 'prefix' => 'cp',
	// 'namespace' => 'P3in\Controllers'
], function() {
    Route::controller('/', '\P3in\Controllers\UiController');
});