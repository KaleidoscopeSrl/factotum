<?php

/**
 *
 *   PRODUCT CATEGORY
 *
 */

Route::group([
	'prefix'     => 'product-category',
	'middleware' => 'auth:api',
	'namespace'  => 'ProductCategory'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\ProductCategory'], function() {
		Route::post('/create',                      'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\ProductCategory'], function() {
		Route::get('/list/',                        'ReadController@getList');
		Route::post('/list-grouped',                'ReadController@getListGrouped');
		Route::get('/list-flatten',                 'ReadController@getListFlatten');
		Route::get('/detail/{id}',                  'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\ProductCategory,id'], function() {
		Route::post('/update/{id}',                 'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\ProductCategory,id'], function() {
		Route::delete('/delete/{id}',               'DeleteController@remove');
	});


});




