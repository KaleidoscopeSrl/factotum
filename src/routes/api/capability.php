<?php

/**
 *
 *   USERS
 *
 */

Route::group([
	'prefix' => 'capability',
	'middleware' => 'auth:api',
	'namespace' => 'Capability'
], function () {

	Route::post('/create', 'CreateController@create');
	Route::post('/list', 'ReadController@getList');
	Route::post('/detail/{id}', 'ReadController@getDetail');
	Route::post('/update/{id}', 'UpdateController@update');
	Route::post('/delete/{id}', 'DeleteController@remove');

});
