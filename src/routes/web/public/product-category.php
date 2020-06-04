<?php

/**
 *
 *   PRODUCT CATEGORY
 *
 */

Route::group([
	'namespace'  => 'ProductCategory'
], function () {


	Route::get('/categoria-prodotto/{productCategorySlug}',  'ReadController@getProductsByCategory');

});




