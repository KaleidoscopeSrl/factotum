<?php

namespace Kaleidoscope\Factotum\Repositories;

use Kaleidoscope\Factotum\Models\Role;


/**
 * Class RoleRepository
 * @package Kaleidoscope\Factotum\Repositories
 */
class RoleRepository extends BaseRepository
{

	/**
	 * @return string
	 */
	public function model(): string
	{
		return Role::class;
	}

}