<?php
namespace Kaleidoscope\Factotum\Repositories\Criteria;

use Kaleidoscope\Factotum\Repositories\BaseRepository;

/**
 * Class BaseCriteria
 * @package Kaleidoscope\Factotum\Repositories\Criteria
 */
abstract class BaseCriteria {

	/**
	 * @param $model
	 * @param BaseRepository $repository
	 * @return mixed
	 */
	public abstract function apply($model, BaseRepository $repository);
}