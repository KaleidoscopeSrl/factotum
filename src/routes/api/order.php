<?php

/**
 *
 *   ORDERS
 *
 */

Route::group([
	'prefix'     => 'order',
	'middleware' => 'auth:api',
	'namespace'  => 'Order'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Order'], function() {
		Route::post('/create',                       'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Order'], function() {
		Route::post('/list-paginated',               'ReadController@getListPaginated');
		Route::get('/list',                          'ReadController@getList');
		Route::get('/detail/{id}',                   'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Order,id'], function() {
		Route::post('/update/{id}',                  'UpdateController@update');
		Route::post('/change-orders-status',         'UpdateController@changeOrdersStatus');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Order,id'], function() {
		Route::delete('/delete/{id}',                'DeleteController@remove');
	});

});


