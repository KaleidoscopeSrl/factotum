<?php

/**
 * ========================================
 *
 *   MAILGUN SEMI-PUBLIC ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'    => 'mailgun',
	'namespace' => 'Mailgun'
], function () {

	Route::post('/delivered',             'DeliveredController@delivered');
	Route::post('/permanent-failure',     'FailureController@permamentFailure');
	Route::post('/temporary-failure',     'FailureController@temporaryFailure');
	Route::post('/complained',            'FailureController@complained');
	Route::post('/opened',                'TriggerController@opened');
	Route::post('/clicked',               'TriggerController@clicked');
	Route::post('/unsubscribed',          'TriggerController@unsubscribed');

});
