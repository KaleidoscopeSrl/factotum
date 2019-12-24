<?php

/**
 *
 *   CATEGORY
 *
 */

Route::group([
	'prefix'     => 'category',
	'middleware' => 'auth:api',
	'namespace'  => 'Category'
], function () {

	Route::post('/create',                              'CreateController@create');
	Route::get('/list/{contentTypeId}',                 'ReadController@getList');
	Route::get('/list-grouped/{contentTypeId}',         'ReadController@getListGrouped');
	Route::get('/detail/{id}',                          'ReadController@getDetail');
	Route::post('/update/{id}',                         'UpdateController@update');
	Route::delete('/delete/{id}',                       'DeleteController@remove');

});