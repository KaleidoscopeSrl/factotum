<?php

/**
 *
 *   NEWSLETTER SUBSCRIPTION
 *
 */

Route::group([
	'prefix'     => 'newsletter-subscription',
	'namespace'  => 'NewsletterSubscription'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\NewsletterSubscription'], function() {
		Route::post('/create',                                   'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\NewsletterSubscription'], function() {
		Route::post('/list-paginated',                           'ReadController@getListPaginated');
		Route::get('/detail/{id}',                               'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\NewsletterSubscription,id'], function() {
		Route::post('/update/{id}',                              'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\NewsletterSubscription,id'], function() {
		Route::delete('/delete/{id}',                            'DeleteController@remove');
		Route::post('/delete-newsletter-subscriptions',          'DeleteController@removeNewsletterSubscriptions');
	});


});
