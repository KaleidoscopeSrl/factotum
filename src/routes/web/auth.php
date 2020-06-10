<?php

/**
 * ========================================
 *
 *   PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'auth',
	'middleware' => 'auth'
], function() {

	Route::get('/logout',     'AuthController@logout')->name('logout');

});