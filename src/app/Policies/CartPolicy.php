<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\Models\User;


class CartPolicy
{

    use HandlesAuthorization;


	public function create(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_carts ? true : false );
	}

	public function read(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_carts ? true : false );
	}

	public function update(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_carts ? true : false );
	}

	public function delete(User $user, $brandID)
	{
		return ( $user->role->backend_access && $user->role->manage_carts ? true : false );
	}

}
