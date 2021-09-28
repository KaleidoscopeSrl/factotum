<?php

namespace Kaleidoscope\Factotum\Repositories\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait HasGetters
 * @package Kaleidoscope\Factotum\Repositories\Traits
 */
trait HasGetters
{
    /**
     * @var
     */
    protected $model;

    /**
     * @return array
     */
    public function fillables(): array
    {
        return $this->model->getFillable();
    }

    /**
     * @return array
     */
    public function relations(): array
    {
        return $this->model->getRelations();
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->model->getKey();
    }

    /**
     * @return string
     */
    public function getKeyName(): string
    {
        return $this->model->getKeyName();
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function find($id)
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->findOrFail($id);

        $this->resetModel();

        return $model;
    }

    /**
     * @param $field
     * @param null $value
     * @param array|string[] $columns
     * @return mixed
     * @throws Exception
     */
    public function findByField($field, $value = null, array $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->where($field, '=', $value)->get($columns);

        $this->resetModel();

        return $model;
    }

    /**
     * @param array $where
     * @param array|string[] $columns
     * @return mixed
     * @throws Exception
     */
    public function findWhere(array $where, array $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->get($columns);

        $this->resetModel();

        return $model;
    }

    /**
     * @param $field
     * @param array $values
     * @param array|string[] $columns
     * @return mixed
     * @throws Exception
     */
    public function findWhereIn($field, array $values, array $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->whereIn($field, $values)->get($columns);

        $this->resetModel();

        return $model;
    }

    /**
     * @param $field
     * @param array $values
     * @param array|string[] $columns
     * @return mixed
     * @throws Exception
     */
    public function findWhereNotIn($field, array $values, array $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->whereNotIn($field, $values)->get($columns);

        $this->resetModel();

        return $model;
    }

    /**
     * @param $field
     * @param array $values
     * @param array|string[] $columns
     * @return mixed
     * @throws Exception
     */
    public function findWhereBetween($field, array $values, array $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->whereBetween($field, $values)->get($columns);

        $this->resetModel();

        return $model;
    }

    /**
     * @param $id
     * @param $field
     * @return null
     * @throws Exception
     */
    public function findField($id, $field)
    {
        $model = $this->find($id);

        if (empty($model)) {
            return null;
        }

        return $model->{$field};
    }

    /**
     * @param string $column
     * @param string|null $key
     * @return mixed
     * @throws Exception
     */
    public function lists(string $column, ?string $key = null)
    {
        $this->applyCriteria();

        $result = $this->model->lists($column, $key);

        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * @param string $column
     * @param string|null $key
     * @return mixed
     * @throws Exception
     */
    public function pluck(string $column, ?string $key = null)
    {
        $this->applyCriteria();

        $result = $this->model->pluck($column, $key);

        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * @param $id
     * @param $relation
     * @param $attributes
     * @param bool $detaching
     * @return mixed
     * @throws Exception
     */
    public function sync($id, $relation, $attributes, bool $detaching = true)
    {
        return $this->find($id)->{$relation}()->sync($attributes, $detaching);
    }

    /**
     * @param $id
     * @param $relation
     * @param $attributes
     * @return mixed
     * @throws Exception
     */
    public function syncWithoutDetaching($id, $relation, $attributes)
    {
        return $this->sync($id, $relation, $attributes, false);
    }

    /**
     * @return mixed
     */
    public function cursor()
    {
        $this->applyCriteria();
        $this->applyScope();

        return $this->model->cursor();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function get()
    {
        $this->applyCriteria();
        $this->applyScope();

        if ($this->model instanceof Builder) {
            $results = $this->model->get();
        } else {
            $results = $this->model->all();
        }

        $this->resetModel();
        $this->resetScope();

        return $results;
    }

    /**
     * @param string[] $columns
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function all(array $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();
        $this->resetScope();

        return $results;
    }


    /**
     * @return mixed
     * @throws Exception
     */
    public function count()
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this->model->count();

        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * @param string $field
     * @return mixed
     * @throws Exception
     */
    public function max(string $field)
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this->model->max($field);

        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * @param $field
     * @return mixed
     * @throws Exception
     */
    public function sum($field)
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this->model->sum($field);

        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * @param $field
     * @return mixed
     * @throws Exception
     */
    public function value($field)
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this->model->value($field);

        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function first()
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->first();

        $this->resetModel();

        return $results;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws Exception
     */
    public function firstOrNew(array $attributes = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->firstOrNew($attributes);

        $this->resetModel();

        return $model;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws Exception
     */
    public function firstOrCreate(array $attributes = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model->firstOrCreate($attributes);

        $this->resetModel();

        return $model;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function take($limit): self
    {
        $this->model = $this->model->limit($limit);

        return $this;
    }

    /**
     * @param int|null $limit
     * @return mixed
     * @throws Exception
     */
    public function limit(?int $limit)
    {
        $this->take($limit);

        return $this->get();
    }

    /**
     * @param null $limit
     * @param array|string[] $columns
     * @param string $method
     * @return mixed
     * @throws Exception
     */
    public function paginate($limit = null, array $columns = ['*'], string $method = "paginate")
    {
        $this->applyCriteria();
        $this->applyScope();

        $limit = is_null($limit) ? $this->skeleton->getConfig('repositories.pagination.limit') : $limit;

        $results = $this->model->{$method}($limit, $columns);

        $results->appends(app('request')->query());

        $this->resetModel();

        return $results;
    }

    /**
     * @param null $limit
     * @param array|string[] $columns
     * @return mixed
     * @throws Exception
     */
    public function simplePaginate($limit = null, array $columns = ['*'])
    {
        return $this->paginate($limit, $columns, "simplePaginate");
    }
}
