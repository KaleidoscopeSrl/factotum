<?php

/**
 *
 *   USERS
 *
 */

Route::group([
	'prefix'     => 'setting',
	'middleware' => 'auth:api',
	'namespace'  => 'Setting'
], function () {


	Route::group(['middleware' => 'can:manage-settings,Kaleidoscope\Factotum\Role'], function() {
		Route::post('/save-homepage-languages',       'Controller@saveHomepageByLanguage');
	});


});
