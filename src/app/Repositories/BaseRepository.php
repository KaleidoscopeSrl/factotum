<?php

namespace Kaleidoscope\Factotum\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Closure;
use Exception;
use Illuminate\Support\Collection;

use Kaleidoscope\Factotum\Skeleton;
use Kaleidoscope\Factotum\Criteria\BaseCriteria;
use Kaleidoscope\Factotum\Criteria\DataCriteria;
use Kaleidoscope\Factotum\Repositories\Traits\HasActions;
use Kaleidoscope\Factotum\Repositories\Traits\HasGetters;
use Kaleidoscope\Factotum\Repositories\Traits\HasTransactions;

/**
 * Class BaseRepository
 * @package Kaleidoscope\Factotum\Repositories
 */
abstract class BaseRepository
{
	use HasActions,
		HasGetters,
		HasTransactions;

	/**
	 * @var Skeleton
	 */
	protected Skeleton $skeleton;

	/**
	 * @var
	 */
	protected $model;

	/**
	 * @var Collection
	 */
	protected Collection $criteria;

	/**
	 * @var Closure|null
	 */
	protected ?Closure $scopeQuery = null;

	/**
	 * @var bool
	 */
	protected bool $skipCriteria = false;

	/**
	 * BaseRepository constructor.
	 * @param Skeleton $skeleton
	 * @throws Exception
	 */
	public function __construct(Skeleton $skeleton)
	{
		$this->skeleton = $skeleton;
		$this->criteria = new Collection();
		$this->makeModel();
		$this->boot();
	}

	/**
	 *
	 */
	public function boot()
	{
		//
	}

	/**
	 * @return mixed
	 */
	public function getModel()
	{
		$this->applyCriteria();
		$this->applyScope();

		return $this->model;
	}

	/**
	 * @return $this
	 * @throws Exception
	 */
	public function resetModel(): self
	{
		$this->makeModel();

		return $this;
	}

	/**
	 * @param array $attributes
	 * @return mixed
	 */
	public function makeModelInstance(array $attributes = [])
	{
		$model = $this->model();

		return new $model($attributes);
	}

	/**
	 * @return mixed|object
	 * @throws BindingResolutionException
	 */
	public function makeModel()
	{
		$model = $this->skeleton->makeInstance($this->model());

		return $this->model = $model;
	}

	/**
	 * @return string
	 */
	public abstract function model(): string;

	/**
	 * @return $this
	 */
	public function resetScope(): self
	{
		$this->scopeQuery = null;

		return $this;
	}

	/**
	 * @param Closure $scope
	 * @return $this
	 */
	public function scopeQuery(Closure $scope): self
	{
		$this->scopeQuery = $scope;

		return $this;
	}

	/**
	 * @return $this
	 */
	protected function applyScope(): self
	{
		if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
			$callback = $this->scopeQuery;
			$this->model = $callback($this->model);
		}

		return $this;
	}

	/**
	 * @return Collection
	 */
	public function getCriteria(): Collection
	{
		return $this->criteria;
	}

	/**
	 * @param bool $status
	 * @return $this
	 */
	public function skipCriteria(bool $status = true): self
	{
		$this->skipCriteria = $status;

		return $this;
	}

	/**
	 * @return $this
	 */
	public function resetCriteria(): self
	{
		$this->criteria = new Collection();

		return $this;
	}

	/**
	 * @param $criteria
	 * @return $this
	 * @throws Exception
	 */
	public function pushCriteria($criteria): self
	{
		if (is_string($criteria)) {
			$criteria = new $criteria;
		}
		if (!$criteria instanceof BaseCriteria) {
			throw new Exception("Class " . get_class($criteria) . " must be an instance of BaseApiCriteria");
		}

		$this->criteria->push($criteria);

		return $this;
	}

	/**
	 * @return $this
	 */
	protected function applyCriteria(): self
	{
		if ($this->skipCriteria === true) {
			return $this;
		}

		$criteria = $this->getCriteria();

		if ($criteria) {
			foreach ($criteria as $c) {
				if ($c instanceof BaseCriteria) {
					$this->model = $c->apply($this->model, $this);
				}
			}
		}

		return $this;
	}

	/**
	 * @param $criteria
	 * @return $this
	 */
	public function popCriteria($criteria): self
	{
		$this->criteria = $this->criteria->reject(function ($item) use ($criteria) {
			if (is_object($item) && is_string($criteria)) {
				return get_class($item) === $criteria;
			}

			if (is_string($item) && is_object($criteria)) {
				return $item === get_class($criteria);
			}

			return get_class($item) === get_class($criteria);
		});

		return $this;
	}

	/**
	 * @param array $data
	 * @return $this
	 * @throws Exception
	 */
	public function buildCriteria(array $data): self
	{
		return $this->pushCriteria(new DataCriteria($this->skeleton, $data));
	}
}
