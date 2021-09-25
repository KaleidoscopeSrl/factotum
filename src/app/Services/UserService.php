<?php

namespace Kaleidoscope\Factotum\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Collection;

use Kaleidoscope\Factotum\Mail\AuthForgottenPassword;
use Kaleidoscope\Factotum\Repositories\ProfileRepository;
use Kaleidoscope\Factotum\Repositories\UserRepository;
use Kaleidoscope\Factotum\Validators\UserValidator;


/**
 * Class UserService
 * @package Kaleidoscope\Factotum\Services
 */
class UserService extends BaseService
{

	protected $profileRepository;


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

		$this->profileRepository = app()->make( ProfileRepository::class );
	}



	/**
	 * @param array $data
	 * @return Model|null
	 * @throws Exception
	 */
	public function create(array $data): ?Model
	{
		$user = parent::create( $data );
		
		$this->profileRepository->startTransaction();

		try {
			$data['user_id'] = $user->id;
			$result = $this->profileRepository->create($data);
dd($result);
			echo '<pre>';
			print_r($result->toArray());die;

			$this->profileRepository->commitTransaction();

			return $user;
		} catch (Exception $exception) {
			$this->profileRepository->rollBackTransaction();
			throw $exception;
		}
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