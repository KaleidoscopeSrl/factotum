<?php

namespace Kaleidoscope\Factotum\Policies;

use Kaleidoscope\Factotum\ProductCategory;
use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Capability;

use Illuminate\Auth\Access\HandlesAuthorization;


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


	public function update(User $user, $categoryID)
	{
		return ( $user->role->backend_access && $user->role->manage_product_categories ? true : false );
	}


	public function delete(User $user, $categoryID)
	{
		return ( $user->role->backend_access && $user->role->manage_product_categories ? true : false );
	}

}
