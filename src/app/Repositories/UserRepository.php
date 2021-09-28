<?php

namespace Kaleidoscope\Factotum\Repositories;

// use Kaleidoscope\Factotum\Models\Capability;

use Kaleidoscope\Factotum\Models\User;


/**
 * Class UserRepository
 * @package Kaleidoscope\Factotum\Repositories
 */
class UserRepository extends BaseRepository
{
	/**
	 * @return string
	 */
	public function model(): string
	{
		return User::class;
	}


//	public function isAdmin()
//	{
//		$user = $this->model;
//
//		return ($user->role->role == 'admin' ? true : false);
//	}
//

//	public function isProfileComplete()
//	{
//		$user = $this->model;
//
//		if ( !$user->profile->phone || !$user->profile->privacy || ( config('app.FACTOTUM_ECOMMERCE_INSTALLED') && !$user->profile->terms_conditions ) ) {
//			return false;
//		}
//
//		return true;
//	}
//
//
//	public function canConfigure($contentTypeID)
//	{
//		$user = $this->model;
//
//		$capability = Capability::where('role_id', $user->role_id)
//								->where('content_type_id', $contentTypeID)
//								->first();
//
//		return $capability && $capability->configure;
//	}
//
//
//	public function canEdit($contentTypeID)
//	{
//		$user = $this->model;
//
//		$capability = Capability::where('role_id', $user->role_id)
//								->where('content_type_id', $contentTypeID)
//								->first();
//
//		return $capability && $capability->edit;
//	}
//
//
//	public function canPublish($contentTypeID)
//	{
//		$user = $this->model;
//
//		$capability = Capability::where('role_id', $user->role_id)
//								->where('content_type_id', $contentTypeID)
//								->first();
//
//		return $capability && $capability->publish;
//	}
//
//
//	public function getByEmail( $email )
//	{
//		return $this->model->where('email', $email)->first();
//	}

}