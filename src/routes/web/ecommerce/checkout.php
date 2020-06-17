<?php

/**
 * ========================================
 *
 *   CART PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'checkout',
	'middleware' => 'auth'
], function() {

	Route::get('',                               'CheckoutController@prepareCheckout');
	Route::post('',                              'CheckoutController@proceedCheckout');

	Route::post('/set-delivery-address',         'CheckoutController@setDeliveryAddress');
	Route::post('/set-invoice-address',          'CheckoutController@setInvoiceAddress');
	Route::post('/set-shipping',                 'CheckoutController@setShipping');

});