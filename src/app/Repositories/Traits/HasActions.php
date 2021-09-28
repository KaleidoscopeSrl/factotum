<?php

namespace Kaleidoscope\Factotum\Repositories\Traits;

use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;

/**
 * Trait HasActions
 * @package Kaleidoscope\Factotum\Repositories\Traits
 */
trait HasActions
{
    /**
     * @var array
     */
    protected array $changes = [];

    /**
     * @return array
     */
    public function getChanges(): array
    {
        return $this->changes;
    }

    /**
     * @return $this
     */
    public function resetChanges(): self
    {
        $this->changes = [];

        return $this;
    }

    /**
     * @param null $attributes
     * @return bool
     */
    public function isDirty($attributes = null): bool
    {
        foreach (Arr::wrap($attributes) as $attribute) {
            if (array_key_exists($attribute, $this->getChanges())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function insert(array $data)
    {
        $result = $this->model->newQuery()->insert($data);

        $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws Exception
     */
    public function create(array $attributes)
    {
        $model = $this->model->newInstance($attributes);
        $model->save();

        $this->resetModel();

        return $model;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function update(array $attributes, $id)
    {
        $this->applyScope();

        $model = $this->model->findOrFail($id);

        $model->fill($attributes);
        $this->changes = $model->getDirty();

        $model->save();

        $this->resetModel();
        $this->resetScope();

        return $model;
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return mixed
     * @throws Exception
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $this->applyScope();

        $model = $this->model->updateOrCreate($attributes, $values);

        $this->resetModel();

        return $model;
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function delete($id)
    {
        $this->applyScope();

        $model = $this->find($id);

        $this->resetModel();

        return $model->delete();
    }



    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function updateAll(array $data)
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this->model->update($data);

        $this->resetModel();
        $this->resetScope();

        return $result;
    }


    /**
     * @return bool|null
     * @throws Exception
     */
    public function deleteAll()
    {
        $this->applyCriteria();
        $this->applyScope();

        $deleted = $this->model->delete();

        $this->resetModel();

        return $deleted;
    }


    /**
     * @return bool|null
     * @throws Exception
     */
    public function forceDeleteAll()
    {
        $this->applyCriteria();
        $this->applyScope();

        $deleted = $this->model->forceDelete();

        $this->resetModel();

        return $deleted;
    }

    /**
     * @param $column
     * @param int $step
     * @return int
     * @throws Exception
     */
    public function increment($column, int $step = 1): int
    {
        $this->applyCriteria();
        $this->applyScope();

        $incremented = $this->model->increment($column, $step);

        $this->resetModel();

        return $incremented;
    }

    /**
     * @param $column
     * @param int $step
     * @return int
     * @throws Exception
     */
    public function decrement($column, int $step = 1): int
    {
        $this->applyCriteria();
        $this->applyScope();

        $decremented = $this->model->decrement($column, $step);

        $this->resetModel();

        return $decremented;
    }

    /**
     * @param array $attributes
     * @param array $relations
     * @return mixed
     * @throws Exception
     */
    public function createWith(array $attributes, array $relations = [])
    {
        $this->startTransaction();

        try {
            $item = $this->create($attributes);
            $this->createRelations($item, $relations);

            $this->commitTransaction();

            return $item;
        } catch (Exception $exception) {
            $this->rollBackTransaction();

            throw $exception;
        }
    }

    /**
     * @param $item
     * @param array $relations
     */
    protected function createRelations($item, array $relations)
    {
        foreach ($relations as $relation) {
            $query = $item->{$relation['name']}();

            if ($query instanceof HasOne || $query instanceof MorphOne) {
                if (isset($relation['attributes']) && is_array($relation['attributes'])) {
                    $relative = $query->updateOrCreate($relation['attributes'], $relation['data']);
                } else {
                    $relative = $query->create($relation['data']);
                }

                if (!empty($relation['relations']) && !empty($relative)) {
                    $this->createRelations($relative, $relation['relations']);
                }

                continue;
            }
            if ($query instanceof BelongsTo) {
                if (isset($relation['attributes']) && is_array($relation['attributes'])) {
                    $relative = $query->updateOrCreate($relation['attributes'], $relation['data']);
                } else {
                    $relative = $query->create($relation['data']);
                }

                $query->associate($relative);

                if (!empty($relation['relations']) && !empty($relative)) {
                    $this->createRelations($relative, $relation['relations']);
                }

                continue;
            }
            if ($query instanceof HasMany || $query instanceof MorphMany) {
                $relatives = $query->createMany($relation['data']);

                if (isset($relation['relations']) && !empty($relation['relations'])) {
                    foreach ($relatives as $index => $relative) {
                        foreach ($relation['relations'] as &$nestedRelation) {
                            if (!isset($relation['data'][$index][$nestedRelation['name']])) {
                                $nestedRelation['data'] = [];
                            } else {
                                $nestedRelation['data'] = $relation['data'][$index][$nestedRelation['name']];
                            }
                        }

                        $this->createRelations($relative, $relation['relations']);
                    }
                }

                continue;
            }
            if ($query instanceof BelongsToMany) {
                $query->attach($relation['data']);
            }
        }
    }

    /**
     * @param array $attributes
     * @param $id
     * @param array $relations
     * @return mixed
     * @throws Exception
     */
    public function updateWith(array $attributes, $id, array $relations = [])
    {
        $this->startTransaction();

        try {
            $item = $this->update($attributes, $id);
            $this->updateRelations($item, $relations);

            $this->commitTransaction();

            return $item;
        } catch (Exception $exception) {
            $this->rollBackTransaction();

            throw $exception;
        }
    }

    /**
     * @param $item
     * @param array $relations
     */
    protected function updateRelations($item, array $relations)
    {
        foreach ($relations as $relation) {
            $query = $item->{$relation['name']}();

            $isCleaned = false;

            if ($query instanceof HasOne || $query instanceof MorphOne) {
                if (isset($relation['clean']) && $relation['clean']) {
                    $query->delete();
                    $isCleaned = true;
                }
                if (isset($relation['data']) && $relation['data']) {
                    if ($isCleaned) {
                        $relative = $query->create($relation['data']);
                    } else {
                        $relative = $item->{$relation['name']};

                        if (empty($relative)) {
                            $relative = $query->create($relation['data']);
                        } else {
                            $relative->update($relation['data']);
                        }
                    }
                    if (!empty($relation['relations']) && !empty($relative)) {
                        $this->updateRelations($relative, $relation['relations']);
                    }
                }
                continue;
            }
            if ($query instanceof HasMany || $query instanceof MorphMany) {
                if (isset($relation['clean']) && $relation['clean']) {
                    $query->delete();
                    $isCleaned = true;
                }
                if (isset($relation['data']) && $relation['data']) {
                    if ($isCleaned) {
                        $relatives = $query->createMany($relation['data']);

                        if (isset($relation['relations']) && !empty($relation['relations'])) {
                            foreach ($relatives as $index => $relative) {
                                foreach ($relation['relations'] as &$nestedRelation) {
                                    if (!isset($relation['data'][$index][$nestedRelation['name']])) {
                                        $nestedRelation['data'] = [];
                                    } else {
                                        $nestedRelation['data'] = $relation['data'][$index][$nestedRelation['name']];
                                    }
                                }

                                $this->createRelations($relative, $relation['relations']);
                            }
                        }
                    } else {
                        $relatives = $item->{$relation['name']};

                        if (!$relatives->count()) {
                            $query->createMany($relation['data']);
                        } else {
                            foreach ($relatives as $index => $relative) {
                                foreach ($relation['data'] as $datum) {
                                    if (
                                        !isset($datum['id']) || empty($datum['id']) ||
                                        $datum['id'] !== $relative->id
                                    ) {
                                        continue;
                                    }

                                    $relative->update($datum);
                                }
                                if (isset($relation['relations']) && !empty($relation['relations'])) {
                                    foreach ($relation['relations'] as &$nestedRelation) {
                                        if (!isset($relation['data'][$index][$nestedRelation['name']])) {
                                            $nestedRelation['data'] = [];
                                        } else {
                                            $nestedRelation['data'] = $relation['data'][$index][$nestedRelation['name']];
                                        }
                                    }

                                    $this->updateRelations($relative, $relation['relations']);
                                }
                            }
                        }
                    }
                }
                continue;
            }
            if ($query instanceof BelongsTo) {
                if (isset($relation['clean']) && $relation['clean']) {
                    $query->delete();
                    $isCleaned = true;
                }
                if (isset($relation['data']) && $relation['data']) {
                    if ($isCleaned) {
                        $relative = $query->create($relation['data']);
                        $query->associate($relative);
                    } else {
                        $relative = $item->{$relation['name']};

                        if (empty($relative)) {
                            $relative = $query->create($relation['data']);
                            $query->associate($relative);
                        } else {
                            $relative->update($relation['data']);
                        }
                    }
                    if (!empty($relation['relations']) && !empty($relative)) {
                        $this->updateRelations($relative, $relation['relations']);
                    }
                }
                continue;
            }
            if ($query instanceof BelongsToMany) {
                if (isset($relation['sync']) && $relation['sync']) {
                    $query->sync($relation['data']);
                    continue;
                }
                if (isset($relation['clean']) && $relation['clean']) {
                    $query->detach();
                }
                if (isset($relation['data']) && $relation['data']) {
                    $query->attach($relation['data']);
                }
            }
        }
    }

    /**
     * @param $id
     * @param array $relations
     * @return mixed
     * @throws Exception
     */
    public function deleteWith($id, array $relations = [])
    {
        $this->startTransaction();

        try {
            $item = $this->find($id);
            $this->deleteRelations($item, $relations);

            $this->delete($id);

            $this->commitTransaction();

            return $item;
        } catch (Exception $exception) {
            $this->rollBackTransaction();

            throw $exception;
        }
    }

    /**
     * @param $item
     * @param array $relations
     */
    protected function deleteRelations($item, array $relations)
    {
        foreach ($relations as $relation) {
            $query = $item->{$relation['name']}();

            if ($query instanceof HasOne || $query instanceof MorphOne) {
                $relative = $query->first();

                if (!empty($relation['relations']) && !empty($relative)) {
                    $this->deleteRelations($relative, $relation['relations']);
                }

                if (!empty($relative)) {
                    $relative->delete();
                }

                continue;
            }
            if ($query instanceof HasMany || $query instanceof MorphMany) {
                $relatives = $query->get();

                foreach ($relatives as $relative) {
                    if (!empty($relation['relations'])) {
                        $this->deleteRelations($relative, $relation['relations']);
                    }

                    $relative->delete();
                }

                continue;
            }
            if ($query instanceof BelongsToMany) {
                $query->detach();
            }
        }
    }
}
