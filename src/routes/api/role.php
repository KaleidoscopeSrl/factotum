<?php

/**
 *
 *   ROLES
 *
 */

Route::group([
	'prefix'     => 'role',
	'middleware' => 'auth:api',
	'namespace'  => 'Role'
], function () {

	Route::post('/create',              'CreateController@create');
	Route::post('/list',                'ReadController@getList');
	Route::post('/full-list',           'ReadController@getFullList');
	Route::post('/detail/{id}',         'ReadController@getDetail');
	Route::post('/update/{id}',         'UpdateController@update');
	Route::post('/delete/{id}',         'DeleteController@remove');

});