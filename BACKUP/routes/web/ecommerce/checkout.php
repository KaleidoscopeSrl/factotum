<?php

/**
 * ========================================
 *
 *   CART PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'checkout'
], function() {

	$middlewares = [];

	if ( !config('factotum.guest_cart') ) {
		$middlewares['middleware'] = 'auth';
	}

	Route::group( $middlewares, function() {
		Route::get('',                                 'CheckoutController@prepareCheckout');
		Route::post('',                                'CheckoutController@proceedCheckout');
		Route::post('/set-delivery-address',           'CheckoutController@setDeliveryAddress');
		Route::post('/set-guest-delivery-address',     'CheckoutController@setGuestDeliveryAddress');
		Route::post('/set-invoice-address',            'CheckoutController@setInvoiceAddress');
		Route::post('/set-guest-invoice-address',      'CheckoutController@setGuestInvoiceAddress');
		Route::post('/set-shipping',                   'CheckoutController@setShipping');
		Route::post('/get-shipping/{countryCode?}',    'CheckoutController@getShipping');
	});

});