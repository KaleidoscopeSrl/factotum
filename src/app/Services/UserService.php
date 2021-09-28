<?php

namespace Kaleidoscope\Factotum\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Exception;

use Kaleidoscope\Factotum\Mail\AuthForgottenPassword;

use Kaleidoscope\Factotum\Filters\UserFilter;
use Kaleidoscope\Factotum\Repositories\UserRepository;
use Kaleidoscope\Factotum\Skeleton;
use Kaleidoscope\Factotum\Transformers\UserTransformer;
use Kaleidoscope\Factotum\Validators\UserValidator;


/**
 * Class UserService
 * @package Kaleidoscope\Factotum\Services
 */
class UserService extends BaseService
{

	protected $profileService;


	/**
	 * UserService constructor.
	 * @param UserRepository $repository
	 * @param UserValidator $validator
	 */
	public function __construct(
		Skeleton $skeleton,
		ProfileService $profileService
	)
	{
		parent::__construct($skeleton);

		$this->setFilter( UserFilter::class );
		$this->setValidator( UserValidator::class );
		$this->setRepository( UserRepository::class );
		$this->setTransformer( UserTransformer::class );

		$this->profileService = $profileService;
	}



	/**
	 * @param array $data
	 * @return Model|null
	 * @throws Exception
	 */
	public function create(array $data): ?Model
	{
		$user = parent::create( $data );

		$data['user_id'] = $user->id;
		$this->profileService->create( $data );

		$user->load('profile');

		return $user;
	}



	/**
	 * @param $id
	 * @param array $data
	 * @return Model|null
	 * @throws Exception
	 */
	public function update($id, array $data): ?Model
	{
		$user = parent::update( $id, $data );

		$data['user_id'] = $user->id;

		$this->profileService->update( $user->profile->id, $data );

		return $user;
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