<?php

/**
 * ========================================
 *
 *   CART PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'    => 'cart'
], function() {

	Route::get('/get-cart-panel',                'ReadController@ajaxGetCartPanel');

});