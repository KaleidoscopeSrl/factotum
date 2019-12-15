<?php

/**
 *
 *   USERS
 *
 */

Route::group([
	'prefix'     => 'user',
	'middleware' => 'auth:api',
	'namespace'  => 'User'
], function () {

	Route::post('/create',              'CreateController@create');
	Route::get('/list',                 'ReadController@getList');
	Route::get('/detail/{id}',          'ReadController@getDetail');
	Route::put('/update/{id}',          'UpdateController@update');
	Route::delete('/delete/{id}',       'DeleteController@remove');

});