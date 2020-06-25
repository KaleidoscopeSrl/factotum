<?php

namespace Kaleidoscope\Factotum\Policies;

use Kaleidoscope\Factotum\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerAddressPolicy
{
    use HandlesAuthorization;

	public function create(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_users ? true : false );
	}

	public function read(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_users ? true : false );
	}

	public function update(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_users ? true : false );
	}

	public function delete(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_users ? true : false );
	}
}
