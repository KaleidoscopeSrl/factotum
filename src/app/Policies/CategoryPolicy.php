<?php

namespace Kaleidoscope\Factotum\Policies;

use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Capability;

use Illuminate\Auth\Access\HandlesAuthorization;


class CategoryPolicy
{
    use HandlesAuthorization;


	/**
	 * Determine whether the user can view the category.
	 *
	 * @param  \Factotum\User  $user
	 * @param  \Factotum\Category  $category
	 * @return mixed
	 */
	public function view( User $user )
	{
		return ( $user->role->backend_access && $user->role->manage_categories ? true : false );
	}


	/**
	 * Determine whether the user can create contentFields.
	 *
	 * @param  \Factotum\User  $user
	 * @return mixed
	 */
	public function create(User $user, $contentTypeID)
	{
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $contentTypeID)
								->first();
		return ( $capability && $capability->configure ? true : false );
	}


	/**
	 * Determine whether the user can update the contentField.
	 *
	 * @param  \Factotum\User  $user
	 * @param  \Factotum\Category  $category
	 * @return mixed
	 */
	public function update(User $user, $categoryID)
	{
		$category = Category::find($categoryID);
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $category->content_type_id)
								->first();
		return ( $capability && $capability->configure ? true : false );

	}

	/**
	 * Determine whether the user can delete the contentField.
	 *
	 * @param  \Factotum\User  $user
	 * @param  \Factotum\Category  $category
	 * @return mixed
	 */
	public function delete(User $user, $categoryId)
	{
		$category = Category::find( $categoryId );
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $category->content_type_id)
								->first();
		return ( $capability && $capability->configure ? true : false );
	}

}
