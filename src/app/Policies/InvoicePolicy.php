<?php

namespace Kaleidoscope\Factotum\Policies;

use Kaleidoscope\Factotum\User;

use Illuminate\Auth\Access\HandlesAuthorization;

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
