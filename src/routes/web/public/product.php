<?php

/**
 *
 *   PRODUCT
 *
 */

Route::group([
	'prefix'    => 'product'
], function () {

	Route::post('/search',         'ReadController@searchProduct');

});




