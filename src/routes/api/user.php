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
	Route::post('/list',                'ReadController@getList');
	Route::post('/detail/{id}',         'ReadController@getDetail');
	Route::post('/update/{id}',         'UpdateController@update');
	Route::post('/delete/{id}',         'DeleteController@remove');

});