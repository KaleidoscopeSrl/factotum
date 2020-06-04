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
	'namespace'  => 'Auth',
], function() {

	Route::get('/logout',     'AuthController@logout')->name('logout');

});