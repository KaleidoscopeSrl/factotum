<?php

namespace Kaleidoscope\Factotum\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Container\Container as App;

use Kaleidoscope\Factotum\Models\BaseModel;
use Kaleidoscope\Factotum\Repositories\Contracts\EloquentRepositoryInterface;
use Kaleidoscope\Factotum\Repositories\Criteria\BaseCriteria;
use Kaleidoscope\Factotum\Repositories\Contracts\CriteriaInterface;
use Kaleidoscope\Factotum\Repositories\Traits\HasTransactions;


/**
 * Class BaseRepository
 * @package Kaleidoscope\Factotum\Repositories
 */
abstract class BaseRepository implements EloquentRepositoryInterface, CriteriaInterface
{
	use HasTransactions;

	/**
	 * @var App
	 */
	private $app;

	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * @var Collection
	 */
	protected $criteria;

	/**
	 * @var bool
	 */
	protected $skipCriteria = false;

	/**
	 * BaseRepository constructor.
	 * @param App $app
	 * @param Collection $collection
	 * @throws \Exception
	 */
	public function __construct(App $app, Collection $collection)
	{
		$this->app      = $app;
		$this->criteria = $collection;
		$this->resetScope();
		$this->makeModel();
	}

	/**
	 * Specify Model class name
	 *
	 * @return mixed
	 */
	public abstract function model();

	/**
	 * @return BaseModel|object
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 */
	public function makeModel()
	{
		$model = $this->app->make($this->model());

		if (!$model instanceof BaseModel)
			throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

		return $this->model = $model;
	}

	/**
	 * @param array $columns
	 * @param array $relations
	 * @return Collection
	 */
	public function all(array $columns = ['*'], array $relations = []): Collection
	{
		$this->applyCriteria();

		return $this->model->with($relations)->get($columns);
	}

	/**
	 * @param string[] $columns
	 * @return Model
	 */
	public function first($columns = ['*']): Model
	{
		$this->applyCriteria();

		return $this->model->first($columns);
	}

	/**
	 * Get all trashed models.
	 *
	 * @return Collection
	 */
	public function allTrashed(): Collection
	{
		$this->applyCriteria();

		return $this->model->onlyTrashed()->get();
	}

	/**
	 * @param int|null $limit
	 * @return mixed
	 */
	public function paginate(?int $limit = null)
	{
		$this->applyCriteria();

		$limit = is_null($limit) ? config('api.pagination.limit', 15) : $limit;

		$results = $this->model->paginate($limit);

		$results->appends(app('request')->query());

		return $results;
	}

	/**
	 * @param int|null $limit
	 * @return mixed
	 */
	public function simplePaginate(?int $limit = null)
	{
		$this->applyCriteria();

		$limit = is_null($limit) ? config('api.pagination.limit', 15) : $limit;

		$results = $this->model->simplePaginate($limit);

		$results->appends(app('request')->query());

		return $results;
	}

	/**
	 * Find model by id.
	 *
	 * @param int $modelId
	 * @param array $columns
	 * @param array $relations
	 * @param array $appends
	 * @return Model
	 */
	public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
	{
		$this->applyCriteria();

		return $this->model->select($columns)
			->with($relations)
			->findOrFail($modelId)
			->append($appends);
	}

	/**
	 * Find trashed model by id.
	 *
	 * @param int $modelId
	 * @return Model
	 */
	public function findTrashedById(int $modelId): ?Model
	{
		$this->applyCriteria();

		return $this->model->withTrashed()
			->findOrFail($modelId);
	}

	/**
	 * Find only trashed model by id.
	 *
	 * @param int $id
	 * @return Model
	 */
	public function findOnlyTrashedById(int $id): ?Model
	{
		$this->applyCriteria();

		return $this->model->onlyTrashed()
			->findOrFail($id);
	}

	/**
	 * Create a model.
	 *
	 * @param array $payload
	 * @return Model
	 */
	public function create(array $payload): ?Model
	{
		$model = $this->model->create($payload);

		return $model->fresh();
	}

	/**
	 * Update existing model
	 *
	 * @param int $id
	 * @param array $payload
	 * @return Model|null
	 */
	public function update(int $id, array $payload): ?Model
	{
		$item = $this->model->findOrFail($id);
		$item->update($payload);

		return $item->fresh();
	}

	/**
	 * Delete by id.
	 *
	 * @param int $id
	 * @return bool
	 */
	public function deleteById(int $id): bool
	{
		return $this->model->findOrFail($id)->delete();
	}

	/**
	 * Restore model by id.
	 *
	 * @param int $id
	 * @return bool
	 */
	public function restoreById(int $id): bool
	{
		return $this->model->onlyTrashed()
			->findOrFail($id)
			->restore();
	}

	/**
	 * Permanently delete by id.
	 *
	 * @param int $id
	 * @return bool
	 */
	public function permanentlyDeleteById(int $id): bool
	{
		return $this->model->onlyTrashed()
			->findOrFail($id)
			->forceDelete();
	}

	/**
	 * @return Model
	 */
	public function latest()
	{
		$this->applyCriteria();

		return $this->model->orderBy('id', 'desc')->first();
	}

	/**
	 * @return $this
	 */
	public function resetScope()
	{
		$this->skipCriteria(false);

		return $this;
	}

	/**
	 * @param bool $status
	 * @return $this
	 */
	public function skipCriteria($status = true)
	{
		$this->skipCriteria = $status;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCriteria()
	{
		return $this->criteria;
	}

	/**
	 * @param BaseCriteria $criteria
	 * @return $this|mixed
	 */
	public function getByCriteria(BaseCriteria $criteria)
	{
		$this->model = $criteria->apply($this->model, $this);

		return $this;
	}

	/**
	 * @param BaseCriteria $criteria
	 * @return $this|mixed
	 */
	public function pushCriteria(BaseCriteria $criteria)
	{
		$this->criteria->push($criteria);

		return $this;
	}

	/**
	 * @return $this|BaseRepository
	 */
	public function applyCriteria()
	{
		if ( $this->skipCriteria === true ) {
			return $this;
		}

		foreach ($this->getCriteria() as $criteria) {
			if ($criteria instanceof BaseCriteria) {
				echo $this->model;die;
				$this->model = $criteria->apply($this->model, $this);
			}
		}

		return $this;
	}
}