<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\Models\User;


class ProductCategoryPolicy
{

    use HandlesAuthorization;

	public function create(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_product_categories ? true : false );
	}


	public function read( User $user )
	{
		return ( $user->role->backend_access && $user->role->manage_product_categories ? true : false );
	}


	public function update(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_product_categories ? true : false );
	}


	public function delete(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_product_categories ? true : false );
	}

}
