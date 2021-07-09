<?php

namespace Kaleidoscope\Factotum\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\Models\Category;
use Kaleidoscope\Factotum\Models\Capability;
use Kaleidoscope\Factotum\Models\User;



class CategoryPolicy
{

    use HandlesAuthorization;


	private function _checkCapabilityByContentType($user, $contentTypeID)
	{
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $contentTypeID)
								->first();
		if ( $capability ) {
			return ( $user->role->backend_access && $capability && $capability->edit ? true : false );
		}

		abort(404, 'Category not found');
	}


	private function _checkCapabilityByCategory( $user, $categoryID )
	{
		$category = Category::find($categoryID);

		if ( $category ) {
			$capability = Capability::where('role_id', $user->role_id)
									->where('content_type_id', $category->content_type_id)
									->first();
			return ( $user->role->backend_access && $capability && $capability->edit ? true : false );
		}

		abort(404, 'Category not found');
	}


	public function create(User $user)
	{
		$contentTypeID = request()->input('content_type_id');
		return $this->_checkCapabilityByContentType( $user, $contentTypeID );
	}


	public function read( User $user, $contentTypeID )
	{
		return $this->_checkCapabilityByContentType( $user, $contentTypeID );
	}


	public function readDetail( User $user, $categoryID )
	{
		return $this->_checkCapabilityByCategory( $user, $categoryID );
	}


	public function update(User $user, $categoryID)
	{
		return $this->_checkCapabilityByCategory( $user, $categoryID );
	}


	public function delete(User $user, $categoryID)
	{
		return $this->_checkCapabilityByCategory( $user, $categoryID );
	}


}
