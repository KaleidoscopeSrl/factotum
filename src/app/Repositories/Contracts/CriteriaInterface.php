<?php

namespace Kaleidoscope\Factotum\Repositories\Contracts;

use Kaleidoscope\Factotum\Repositories\Criteria\BaseCriteria;

/**
 * Interface CriteriaInterface
 * @package Kaleidoscope\Factotum\Repositories\Contracts
 */
interface CriteriaInterface {

	/**
	 * @param bool $status
	 * @return $this
	 */
	public function skipCriteria($status = true);

	/**
	 * @return mixed
	 */
	public function getCriteria();

	/**
	 * @param BaseCriteria $criteria
	 * @return mixed
	 */
	public function getByCriteria(BaseCriteria $criteria);

	/**
	 * @param BaseCriteria $criteria
	 * @return mixed
	 */
	public function pushCriteria(BaseCriteria $criteria);

	/**
	 * @return $this
	 */
	public function  applyCriteria();
}