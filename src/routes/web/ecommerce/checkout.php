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

	Route::get('',                               'ReadController@prepareCheckout');

	Route::post('/set-delivery-address',         'UpdateController@setDeliveryAddress');
	Route::post('/set-invoice-address',          'UpdateController@setInvoiceAddress');
	Route::post('/set-shipping',                 'UpdateController@setShipping');


});