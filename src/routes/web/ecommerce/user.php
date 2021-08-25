<?php

/**
 * ========================================
 *
 *   USER PROTECTED ROUTES
 *
 * ========================================
 */

use Illuminate\Support\Facades\Route;

Route::group([
	'prefix'     => 'user'
], function() {

	if ( !config('factotum.guest_cart') ) {
		Route::group([
			'middleware' => 'auth',
			'prefix'     => 'customer-addresses'
		], function() {
			Route::get('/',                          'ProfileController@showCustomerAddresses');
			Route::get('/edit/{type}',               'ProfileController@showCustomerAddressForm');
			Route::get('/edit/{type}/{id?}',         'ProfileController@showCustomerAddressForm');
			Route::post('/edit/{type}/{id?}',        'ProfileController@saveCustomerAddress');
			Route::post('/set-default',              'ProfileController@setDefaultCustomerAddress');
			Route::get('/get-province-input',        'ProfileController@getProvinceInput');
			Route::get('/get-province-select',       'ProfileController@getProvinceSelect');
		});
	} else {
		Route::group([
			'prefix'     => 'customer-addresses'
		], function() {
			Route::post('/edit/{type}',                  'ProfileController@saveCustomerAddress');
		});
	}

});