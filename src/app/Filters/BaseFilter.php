<?php

namespace Kaleidoscope\Factotum\Filters;

use Kaleidoscope\Factotum\Repositories\BaseRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Exception;
use Kaleidoscope\Factotum\Skeleton;

/**
 * Class BaseFilter
 * @package Kaleidoscope\Factotum\Filters
 */
abstract class BaseFilter
{
    /**
     * @var array
     */
    protected array $data;

    /**
     * @var array
     */
    protected array $selects;

	/**
	 * @var Skeleton
	 */
	protected Skeleton $skeleton;

    /**
     * @var BaseRepository
     */
    protected BaseRepository $repository;

	/**
	 * @param Skeleton $skeleton
	 */
	public function __construct(Skeleton $skeleton)
	{
		$this->skeleton = $skeleton;
	}

	/**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param BaseRepository $repository
     * @return $this
     */
    public function setRepository(BaseRepository $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * @return BaseRepository
     */
    public function filter(): BaseRepository
    {
        if (method_exists($this, 'filterByDefault')) {
            $this->filterByDefault();
        }

        $this->applySorts();
        $this->applyFilters();

        return $this->repository;
    }

    /**
     * @return bool
     */
    protected function applyFilters(): bool
    {
        if (empty($this->data)) {
            return false;
        }

        foreach ($this->data as $key => $value) {
            $method = 'filterBy' . ucfirst(Str::camel($key));

            if (!method_exists($this, $method)) {
                continue;
            }

            if (!empty($value)) {
                $this->{$method}($value);
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function applySorts(): bool
    {
        $order = Arr::get($this->data, 'order');
        $sortBy = Arr::get($this->data, 'sortBy');

        if (!$order || !$sortBy) {
            return false;
        }

        $sortBy = is_array($sortBy) ? $sortBy : [$sortBy];

        foreach ($sortBy as $sort) {
            $method = 'sortBy' . ucfirst(Str::camel($sort));

            if (!method_exists($this, $method)) {
                continue;
            }

            $this->{$method}($order);
        }

        return true;
    }

    /**
     * @param $limit
     * @throws Exception
     */
    protected function filterByLimit($limit)
    {
        $this->repository->buildCriteria([
            'limit' => $limit
        ]);
    }
}
