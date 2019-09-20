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

	Route::post('/save-homepage-languages',       'Controller@saveHomepageByLanguage');

});
