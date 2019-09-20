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

	Route::post('/create',                              'CreateController@create');
	Route::post('/list/{contentTypeId}',                'ReadController@getList');
	Route::post('/list-grouped/{contentTypeId}',        'ReadController@getListGrouped');
	Route::post('/detail/{id}',                         'ReadController@getDetail');
	Route::post('/update/{id}',                         'UpdateController@update');
	Route::delete('/delete/{id}',                       'DeleteController@remove');

});