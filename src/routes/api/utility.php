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

	Route::group(['middleware' => 'can:backend-access,Kaleidoscope\Factotum\Role'], function() {
		Route::get('/available-languages',       'Controller@getAvailableLanguages');
		Route::get('/pages-by-language',         'Controller@getPagesByLanguage');
		Route::post('/check-seo-keyword',        'Controller@checkSeoKeyword');
	});

});
