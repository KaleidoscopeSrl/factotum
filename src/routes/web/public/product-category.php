<?php

/**
 *
 *   PRODUCT CATEGORY
 *
 */

Route::group([
	'namespace'  => 'Ecommerce\ProductCategory'
], function () {


	Route::get('/categoria-prodotto/{productCategorySlug}',  'ReadController@getProductsByCategory');

});




