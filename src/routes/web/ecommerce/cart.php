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

	if ( !config('factotum.guest_cart') ) {
		Route::group([
			'middleware' => 'auth'
		], function() {
			Route::get('',                               'ReadController@readCart');
			Route::post('/add-product',                  'UpdateController@addProduct');
			Route::post('/remove-product',               'UpdateController@removeProduct');
			Route::post('/drop-product',                 'UpdateController@dropProduct');
		});
	} else {
		Route::get('',                               'ReadController@readCart');
		Route::post('/add-product',                  'UpdateController@addProduct');
		Route::post('/remove-product',               'UpdateController@removeProduct');
		Route::post('/drop-product',                 'UpdateController@dropProduct');
	}

});