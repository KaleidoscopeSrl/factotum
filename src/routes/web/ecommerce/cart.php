<?php

/**
 * ========================================
 *
 *   CART PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'cart',
	'middleware' => 'auth'
], function() {

	Route::get('',                               'ReadController@readCart');

	Route::post('/add-product',                  'UpdateController@addProduct');
	Route::post('/remove-product',               'UpdateController@removeProduct');
	Route::post('/drop-product',                 'UpdateController@dropProduct');

});