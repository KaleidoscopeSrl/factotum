<?php

/**
 *
 *   CAMPAIGNS
 *
 */

Route::group([
	'prefix'     => 'campaign-email',
	'middleware' => 'auth:api',
	'namespace'  => 'CampaignEmail'
], function() {

	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\CampaignEmail'], function() {
		Route::post('/create',             'CreateController@create');
		Route::post('/create-multiple',    'CreateController@createMultiple');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\CampaignEmail'], function() {
		Route::get('/list/{campaignId}',           'ReadController@getList');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\CampaignEmail,id'], function() {
		Route::delete('/delete/{id}',                  'DeleteController@remove');
		Route::post('/delete-campaign-emails',         'DeleteController@removeCampaignEmails');
	});

});

