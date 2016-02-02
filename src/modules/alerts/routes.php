<?php

use App\Events\Alert as AlertEvent;
use P3in\Models\User;
// use Auth;
use P3in\Models\Alert as AlertModel;

Route::group([
    'prefix' => '/alerts',
    'namespace' => 'P3in\Controllers',
    'middleware' => ['web', 'auth'],
], function() {

    Route::get('login', function() {

      event(new AlertEvent('info', "User Logged in", "User ".Auth()->user()->fullName." logged in.", Auth::user()));

      return "Logged in / Event Emitted";

    });


    Route::get('logout', function() {

      $user = Auth::user();

      Auth::logout();

      event(new AlertEvent('info', "User Disconnected", "User ".$user->fullName." logged off.", $user));

      return "Logged out / Event Emitted";

    });



    Route::get('notifications/alerts/{level}', function($level) {

      $hash = Request::get('hash');

      return AlertModel::where('level', 'info')
        ->byHash($hash)
        ->firstOrFail()
        ->matchPerms(Request::user());

    });

    Route::get('alerts', function() {

      return view('alerts::alerts');

    });
});