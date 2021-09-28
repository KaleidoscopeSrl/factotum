<?php

namespace Kaleidoscope\Factotum\Services;

use Kaleidoscope\Factotum\Filters\ProfileFilter;
use Kaleidoscope\Factotum\Repositories\ProfileRepository;
use Kaleidoscope\Factotum\Skeleton;
use Kaleidoscope\Factotum\Transformers\ProfileTransformer;
use Kaleidoscope\Factotum\Validators\ProfileValidator;


/**
 * Class ProfileService
 * @package Kaleidoscope\Factotum\Services
 */
class ProfileService extends BaseService
{


	/**
	 * ProfileService constructor.
	 * @param Skeleton $skeleton
	 */
	public function __construct(
		Skeleton $skeleton
	)
	{
		parent::__construct($skeleton);

		$this->setFilter( ProfileFilter::class );
		$this->setValidator( ProfileValidator::class );
		$this->setRepository( ProfileRepository::class );
		$this->setTransformer( ProfileTransformer::class );
	}


}