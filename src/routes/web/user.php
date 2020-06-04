<?php

/**
 * ========================================
 *
 *   USER PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'    => 'user',
	'namespace' => 'User'
], function() {

	Route::get('/profile',                   'ProfileController@showProfileForm');
	Route::post('/profile',                  'ProfileController@update');

	Route::get('/delivery-address',          'ProfileController@showDeliveryAddressForm');
	Route::post('/delivery-address',         'ProfileController@saveDeliveryAddress');

	Route::get('/invoice-address',           'ProfileController@showInvoiceAddressForm');
	Route::post('/invoice-address',          'ProfileController@saveInvoiceAddress');

});