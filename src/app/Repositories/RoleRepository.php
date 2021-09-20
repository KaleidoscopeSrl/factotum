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
	 * RoleRepository constructor.
	 * @param Role $model
	 */
	public function __construct(Role $model)
	{
		parent::__construct($model);
	}

}