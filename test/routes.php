<?php

use Illuminate\Http\Request;

Route::get('/userinos', '\P3in\Controllers\UserinoController@index'); //->middleware('api');
// Route::get('/userinos', function() {
//     return 'whoa';
// });