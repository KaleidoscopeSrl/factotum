<?php

namespace Kaleidoscope\Factotum\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Kaleidoscope\Factotum\Mail\AuthForgottenPassword;
use Kaleidoscope\Factotum\Repositories\UserRepository;
use Kaleidoscope\Factotum\Validators\UserValidator;


/**
 * Class UserService
 * @package Kaleidoscope\Factotum\Services
 */
class UserService extends BaseService
{
	/**
	 * UserService constructor.
	 * @param UserRepository $repository
	 * @param UserValidator $validator
	 */
	public function __construct(
		UserRepository $repository,
		UserValidator $validator
	)
	{
		parent::__construct($repository, $validator);
	}


	public function forgotPassword( $email )
	{
		$user = $this->repository->getByEmail( $email );

		if ( !$user ) {
			throw new \Exception('Utente non trovato.');
		}

		$data = $user->toArray();
		$newPassword = ( config('app.env') == 'local' || config('app.env') == 'testing' ? '12345678' : Str::random(8) );
		$data['password'] = Hash::make( $newPassword );
		$this->update( $user->id, $data);

		Mail::to( $user->email )
			->send( new AuthForgottenPassword( $user, $newPassword ) );

		if ( !Mail::failures() ) {
			return true;
		}

		throw new \Exception('Impossibile recuperare la password');
	}

}