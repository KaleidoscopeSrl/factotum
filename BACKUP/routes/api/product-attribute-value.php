<?php

/**
 *
 *   PRODUCT ATTRIBUTES
 *
 */

Route::group([
	'prefix'     => 'product-attribute-value',
	'middleware' => 'auth:api',
	'namespace'  => 'ProductAttributeValue'
], function() {

	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\ProductAttributeValue'], function() {
		Route::post('/create',             'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\ProductAttributeValue'], function() {
		Route::get('/list/{productAttributeId}',                  'ReadController@getList');
		Route::post('/list-paginated/{productAttributeId}',       'ReadController@getListPaginated');
		Route::post('/filtered-list/{productAttributeId}',        'ReadController@getFilteredList');
		Route::get('/detail/{id}',                                'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\ProductAttributeValue,id'], function() {
		Route::post('/update/{id}',        'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\ProductAttributeValue,id'], function() {
		Route::delete('/delete/{id}',                        'DeleteController@remove');
		Route::post('/delete-product-attribute-values',      'DeleteController@removeProductAttributeValues');
	});

});
