<?php

/**
 * ========================================
 *
 *   PROTECTED ROUTES
 *
 * ========================================
 */

use Illuminate\Support\Facades\Route;

Route::group([
	'prefix'     => 'auth',
	'middleware' => 'auth'
], function() {

	Route::get('/logout',     'AuthController@logout')->name('logout');

});