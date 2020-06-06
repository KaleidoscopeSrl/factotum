<?php

/**
 * ========================================
 *
 *   USER PUBLIC ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'    => 'user',
	'namespace' => 'User'
], function() {

	// USER ROUTES
	Route::get('/register',                          'RegisterController@showRegistrationForm')->name('register');
	Route::post('/register',                         'RegisterController@register');
	Route::get('/thank-you',                         'RegisterController@showThankyou');
	Route::get('/confirm-password',                  'RegisterController@showConfirmForm')->name('password.confirm');
	Route::post('/confirm-password',                 'RegisterController@confirm');

	Route::get('/email/verify',                      'VerificationController@show' )->name('verification.notice');
	Route::get('/email/verify/{id}/{hash}',          'VerificationController@verify' )->name('verification.verify');
	Route::post('/email/resend',                     'VerificationController@resend' )->name('verification.resend');

});