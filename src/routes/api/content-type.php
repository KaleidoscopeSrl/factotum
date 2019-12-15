<?php

/**
 *
 *   CONTENT TYPE
 *
 */

Route::group([
	'prefix'     => 'content-type',
	'middleware' => 'auth:api',
	'namespace'  => 'ContentType'
], function () {

	Route::post('/create',              'CreateController@create');
	Route::get('/list',                 'ReadController@getList');
	Route::get('/detail/{id}',          'ReadController@getDetail');
	Route::put('/update/{id}',          'UpdateController@update');
	Route::delete('/delete/{id}',       'DeleteController@remove');

});