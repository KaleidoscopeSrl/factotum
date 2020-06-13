<?php

/**
 * ========================================
 *
 *   CART PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'checkout',
	'middleware' => 'auth'
], function() {

	Route::get('',                               'ReadController@prepareCheckout');

});