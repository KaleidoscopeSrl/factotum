<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\Models\User;
use Kaleidoscope\Factotum\Repositories\UserRepository;


class UserPolicy
{

    use HandlesAuthorization;


    protected $repository;


    public function __construct( UserRepository $repository )
    {
    	$this->repository = $repository;
    }


    private function _baseEditingCheck( $id = null )
	{
		$editingUser = $this->repository->find( $id );

		if ( !$editingUser || ( $editingUser && !$editingUser->editable ) ) {
			return false;
		}
	}


	public function create(?User $user) : bool
	{
		return auth_user_role()->manage_users;
	}


	public function read(?User $user) : bool
	{
		return auth_user_role()->manage_users;
	}


	public function update(?User $user, $id = null) : bool
	{
		$this->_baseEditingCheck( $id );

		return auth_user_role()->manage_users;
	}


	public function delete(?User $user, $id = null ) : bool
	{
		$this->_baseEditingCheck( $id );

		return auth_user_role()->manage_users;
	}


	public function deleteMultipleUsers(): bool
	{
		return auth_user_role()->role === \ConstRoles::ADMIN;
	}


}
