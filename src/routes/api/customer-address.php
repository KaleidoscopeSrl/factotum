<?php

/**
 *
 *   CUSTOMER ADDRESSES
 *
 */

Route::group([
	'prefix'     => 'customer-address',
	'middleware' => 'auth:api',
	'namespace'  => 'CustomerAddress'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\CustomerAddress'], function() {
		Route::post('/create',                       'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\CustomerAddress'], function() {
		Route::get('/list',                          'ReadController@getList');
		Route::post('/list-paginated',               'ReadController@getListPaginated');
		Route::get('/detail/{id}',                   'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\CustomerAddress,id'], function() {
		Route::post('/update/{id}',                  'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\CustomerAddress,id'], function() {
		Route::delete('/delete/{id}',                    'DeleteController@remove');
		Route::post('/delete-customer-addresses',        'DeleteController@removeCustomerAddresses');
	});

});


