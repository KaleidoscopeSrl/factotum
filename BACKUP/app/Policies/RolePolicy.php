<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\Models\Role;
use Kaleidoscope\Factotum\Models\User;


class RolePolicy
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

	public function update(User $user, $roleID)
	{
		$role = Role::find($roleID);
		return ( $role->editable || !$role->editable && auth()->user()->isAdmin() ? true : false );
	}

	public function delete(User $user, $roleID)
	{
		$role = Role::find($roleID);
		return ( $role->editable || !$role->editable && auth()->user()->isAdmin() ? true : false );
	}

	public function backendAccess(User $user)
	{
		return ( $user->role->backend_access ? true : false );
	}

	public function manageSettings(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_settings ? true : false );
	}

}
