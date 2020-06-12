<?php

/**
 * ========================================
 *
 *   USER PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'middleware' => 'auth',
	'prefix'     => 'user'
], function() {

	Route::get('/customer-addresses',                           'ProfileController@showCustomerAddresses');
	Route::get('/customer-addresses/edit/{type}',               'ProfileController@showCustomerAddressForm');
	Route::get('/customer-addresses/edit/{type}/{id?}',         'ProfileController@showCustomerAddressForm');

	Route::post('/customer-addresses/edit/{type}/{id?}',        'ProfileController@saveCustomerAddress');

	Route::post('/customer-addresses/set-default',              'ProfileController@setDefaultCustomerAddress');

//	Route::get('/delivery-address',          'ProfileController@showDeliveryAddressForm');
//
//
//	Route::get('/invoice-address',           'ProfileController@showInvoiceAddressForm');
//	Route::post('/invoice-address',          'ProfileController@saveInvoiceAddress');

});