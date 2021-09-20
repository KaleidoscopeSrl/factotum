<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\Models\User;


class UserPolicy
{
    use HandlesAuthorization;

	// TODO: cambiare con repository
	public function create(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_users ? true : false );
	}

	public function read(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_users ? true : false );
	}

	public function update(User $user, $userID)
	{
		$userOnEdit = User::find($userID);
		return ( $userOnEdit && ( $userOnEdit->editable || !$userOnEdit->editable && auth()->user()->isAdmin() ) ? true : false );
	}

	public function delete(User $user, $userID)
	{
		$userOnEdit = User::find($userID);
		return ( $userOnEdit && ( $userOnEdit->editable || (!$userOnEdit->editable && auth()->user()->isAdmin() ) ) ? true : false );
	}

}
