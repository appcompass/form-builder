<?php

Route::group([
  // 'prefix' => '/',
  'namespace' => 'P3in\Controllers'
], function() {

  Route::resource('pages', 'PagesController');

});