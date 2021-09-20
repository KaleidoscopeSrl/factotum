<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\Models\User;


class InvoicePolicy
{

    use HandlesAuthorization;

	public function read(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_orders ? true : false );
	}

	public function delete(User $user, $brandID)
	{
		return ( $user->role->backend_access && $user->role->manage_orders ? true : false );
	}

}
