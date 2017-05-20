<?php

namespace Kaleidoscope\Factotum\Policies;

use Kaleidoscope\Factotum\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaPolicy
{
    use HandlesAuthorization;

	public function view(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_media ? true : false );
	}

	public function create(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_media ? true : false );
	}

	public function update(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_media ? true : false );
	}

	public function delete(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_media ? true : false );
	}

}
