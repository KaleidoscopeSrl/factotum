<?php

namespace Kaleidoscope\Factotum\Criteria;

use Kaleidoscope\Factotum\Repositories\BaseRepository;
use Kaleidoscope\Factotum\Skeleton;

/**
 * Class DataCriteria
 * @package Kaleidoscope\Factotum\Criteria
 */
class DataCriteria extends BaseCriteria
{
    /**
     * @var array
     */
    private array $data;

	/**
	 * @param Skeleton $skeleton
	 * @param array $data
	 */
	public function __construct(Skeleton $skeleton, array $data)
	{
		parent::__construct($skeleton);

		$this->data = $data;
	}

	/**
     * @param $query
     * @param BaseRepository $repository
     * @return mixed
     */
    public function apply($query, BaseRepository $repository)
    {
        $this->repository = $repository;

        $this->buildData($query, $this->data);

        return $query;
    }
}
