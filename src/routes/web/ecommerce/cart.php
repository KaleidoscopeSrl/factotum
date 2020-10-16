<?php

/**
 * ========================================
 *
 *   CART PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'cart'
], function() {

	$middlewares = [];

	if ( !config('factotum.guest_cart') ) {
		$middlewares['middleware'] = 'auth';
	}

	Route::group($middlewares, function() {
		Route::get('',                               'ReadController@readCart');
		Route::post('/add-product',                  'UpdateController@addProduct');
		Route::post('/remove-product',               'UpdateController@removeProduct');
		Route::post('/drop-product',                 'UpdateController@dropProduct');

		Route::post('/apply-discount-code',          'UpdateController@applyDiscountCode');
		Route::post('/remove-discount-code',         'UpdateController@removeDiscountCode');
	});

});