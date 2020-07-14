<?php

/**
 *
 *   CAMPAIGN TEMPLATES
 *
 */

Route::group([
	'prefix'     => 'campaign-template',
	'middleware' => 'auth:api',
	'namespace'  => 'CampaignTemplate'
], function() {

	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\CampaignTemplate'], function() {
		Route::post('/create',             'CreateController@create');
		Route::post('/preview/{id}',       'PreviewController@preview');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\CampaignTemplate'], function() {
		Route::get('/list',                'ReadController@getList');
		Route::post('/list-paginated',     'ReadController@getListPaginated');
		Route::get('/detail/{id}',         'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\CampaignTemplate,id'], function() {
		Route::post('/update/{id}',        'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\CampaignTemplate,id'], function() {
		Route::delete('/delete/{id}',                  'DeleteController@remove');
		Route::post('/delete-campaign-templates',      'DeleteController@removeCampaignTemplates');
	});

});
