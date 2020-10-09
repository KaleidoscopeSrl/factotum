<?php

/**
 *
 *   CAMPAIGNS
 *
 */

Route::group([
	'prefix'     => 'campaign',
	'middleware' => 'auth:api',
	'namespace'  => 'Campaign'
], function() {

	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Campaign'], function() {
		Route::post('/create',             'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Campaign'], function() {
		Route::get('/list',                'ReadController@getList');
		Route::post('/list-paginated',     'ReadController@getListPaginated');
		Route::get('/detail/{id}',         'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Campaign,id'], function() {
		Route::post('/update/{id}',              'UpdateController@update');
		Route::post('/send/{id}',                'SendController@send');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Campaign,id'], function() {
		Route::delete('/delete/{id}',             'DeleteController@remove');
		Route::post('/delete-campaigns',          'DeleteController@removeCampaigns');
	});

});

