<?php

/**
 *
 *   PRODUCT
 *
 */

Route::group([
	'namespace'  => 'Ecommerce\Product'
], function () {

	Route::post('/ricerca-prodotto',         'ReadController@searchProduct');

});




