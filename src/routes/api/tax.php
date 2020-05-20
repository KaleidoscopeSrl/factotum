<?php

/**
 *
 *   TAXES
 *
 */

Route::group([
	'prefix'     => 'tax',
	'middleware' => 'auth:api',
	'namespace'  => 'Tax'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Tax'], function() {
		Route::post('/create',             'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Tax'], function() {
		Route::get('/list',                'ReadController@getList');
		Route::post('/list-paginated',     'ReadController@getListPaginated');
		Route::get('/detail/{id}',         'ReadController@getDetail');

	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Tax,id'], function() {
		Route::post('/update/{id}',        'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Tax,id'], function() {
		Route::delete('/delete/{id}',      'DeleteController@remove');
		Route::post('/delete-taxes',       'DeleteController@removeTaxes');
	});


});