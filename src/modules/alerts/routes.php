<?php

use P3in\Models\User;
use Illuminate\Http\Request;
use App\Events\Alert as AlertEvent;
use P3in\Models\Alert as AlertModel;

Route::group([
    'namespace' => 'P3in\Controllers',
    'middleware' => ['web', 'auth'],
], function() {

    Route::resource('/alerts', 'AlertsController');

});