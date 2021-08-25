<?php

/**
 * ========================================
 *
 *   USER PROTECTED ROUTES
 *
 * ========================================
 */

use Illuminate\Support\Facades\Route;

Route::group([
	'middleware' => 'auth',
	'prefix'     => 'user'
], function() {

	Route::get('/profile',                   'ProfileController@showProfileForm');
	Route::post('/profile',                  'ProfileController@update');

});