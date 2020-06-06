<?php

/**
 * ========================================
 *
 *   CART PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'    => 'cart',
	'namespace' => 'Ecommerce\Cart'
], function() {

	Route::post('/add-product',                  'CartController@addProduct');
	// Route::post('/remove-product',               'CartController@removeProduct');

});