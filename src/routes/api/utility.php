<?php

/**
 *
 *   USERS
 *
 */

Route::group([
	'prefix'     => 'utility',
	'middleware' => 'auth:api',
	'namespace'  => 'Utility'
], function () {

	Route::post('/available-languages',       'Controller@getAvailableLanguages');
	Route::post('/pages-by-language',         'Controller@getPagesByLanguage');

});
