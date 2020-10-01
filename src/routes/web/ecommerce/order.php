<?php

/**
 * ========================================
 *
 *   CART PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'order'
], function() {

	$middlewares = [];

	if ( !config('factotum.guest_cart') ) {
		$middlewares['middleware'] = 'auth';
	}

	Route::group( $middlewares, function() {
		Route::get('/list',                           'ReadController@getList');
		Route::get('/detail/{id}',                    'ReadController@getDetail');
		Route::post('/set-order-transaction',         'UpdateController@setOrderTransaction');
	});

	Route::get('/thank-you/{id}',                 'ReadController@showThankyou');

});