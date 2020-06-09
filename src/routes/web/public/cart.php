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

	Route::get('/get-cart-panel',                'CartController@ajaxGetCartPanel');

});