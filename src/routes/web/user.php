<?php

/**
 * ========================================
 *
 *   USER PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'middleware' => 'auth',
	'prefix'     => 'user'
], function() {

	Route::get('/profile',                   'ProfileController@showProfileForm');
	Route::post('/profile',                  'ProfileController@update');

});