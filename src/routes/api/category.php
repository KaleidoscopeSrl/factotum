<?php

/**
 *
 *   CATEGORY
 *
 */

Route::group([
	'prefix'    => 'category',
	'namespace' => 'Category'
], function () {

	Route::post('/create',              'CreateController@create');
	Route::post('/list',                'ReadController@getList');
	Route::post('/detail/{id}',         'ReadController@getDetail');
	Route::post('/update/{id}',         'UpdateController@update');
	Route::delete('/delete/{id}',       'DeleteController@remove');

});