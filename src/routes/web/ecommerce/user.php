<?php

/**
 * ========================================
 *
 *   USER PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'user'
], function() {

	if ( !config('factotum.guest_cart') ) {
		Route::group([
			'middleware' => 'auth'
		], function() {
			Route::get('/customer-addresses',                           'ProfileController@showCustomerAddresses');
			Route::get('/customer-addresses/edit/{type}',               'ProfileController@showCustomerAddressForm');
			Route::get('/customer-addresses/edit/{type}/{id?}',         'ProfileController@showCustomerAddressForm');
			Route::post('/customer-addresses/edit/{type}/{id?}',        'ProfileController@saveCustomerAddress');
			Route::post('/customer-addresses/set-default',              'ProfileController@setDefaultCustomerAddress');
		});
	} else {
		Route::post('/customer-addresses/edit/{type}',                  'ProfileController@saveCustomerAddress');
	}

});