<?php

namespace Kaleidoscope\Factotum\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use Kaleidoscope\Factotum\Repositories\Traits\HasTransactions;


/**
 * Class BaseRepository
 * @package Kaleidoscope\Factotum\Repositories
 */
abstract class BaseRepository implements EloquentRepositoryInterface
{
	use HasTransactions;

	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * BaseRepository constructor.
	 *
	 * @param Model $model
	 */
	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	/**
	 * @param array $columns
	 * @param array $relations
	 * @return Collection
	 */
	public function all(array $columns = ['*'], array $relations = []): Collection
	{
		return $this->model->with($relations)->get($columns);
	}

	/**
	 * @param string[] $columns
	 * @return Model
	 */
	public function first($columns = ['*']): Model
	{
		return $this->model->first( $columns );
	}

	/**
	 * Get all trashed models.
	 *
	 * @return Collection
	 */
	public function allTrashed(): Collection
	{
		return $this->model->onlyTrashed()->get();
	}

	/**
	 * @param int|null $limit
	 * @return mixed
	 */
	public function paginate(?int $limit = null)
	{
		$limit  = is_null($limit) ? config('api.pagination.limit', 15) : $limit;

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
	public function findById( int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
	{
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
		return $this->model->orderBy('id', 'desc')->first();
	}
}