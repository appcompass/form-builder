<?php

Route::group([
  // 'prefix' => '/',
  'namespace' => 'P3in\Controllers'
], function() {

  Route::resource('pages', 'PagesController');
  Route::resource('cp/pages', 'CpPagesController');
  Route::resource('cp/pages/{id}/section', 'CpPageSectionsController');
  Route::resource('cp/section', 'CpSectionsController');

});