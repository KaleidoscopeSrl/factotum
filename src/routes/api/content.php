<?php

/**
 *
 *   CONTENT FIELD
 *
 */

Route::group([
	'prefix'    => 'content',
	'namespace' => 'Content'
], function () {

	Route::post('/create',              'CreateController@create');
	Route::post('/list',                'ReadController@getList');
	Route::post('/detail/{id}',         'ReadController@getDetail');
	Route::post('/update/{id}',         'UpdateController@update');
	Route::delete('/delete/{id}',       'DeleteController@remove');

});