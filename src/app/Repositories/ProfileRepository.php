<?php

namespace Kaleidoscope\Factotum\Repositories;

use Kaleidoscope\Factotum\Models\Profile;


/**
 * Class ProfileRepository
 * @package Kaleidoscope\Factotum\Repositories
 */
class ProfileRepository extends BaseRepository
{
	/**
	 * @return mixed|string
	 */
	public function model()
	{
		return Profile::class;
	}

}