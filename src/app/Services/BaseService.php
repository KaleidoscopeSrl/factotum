<?php

namespace Kaleidoscope\Factotum\Services;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

use Kaleidoscope\Factotum\Filters\BaseFilter;
use Kaleidoscope\Factotum\Repositories\BaseRepository;
use Kaleidoscope\Factotum\Skeleton;
use Kaleidoscope\Factotum\Transformers\BaseTransformer;
use Kaleidoscope\Factotum\Validators\BaseValidator;


/**
 * Class BaseService
 * @package Kaleidoscope\Factotum\Services
 */
abstract class BaseService
{
	/**
	 * @var BaseFilter
	 */
	protected BaseFilter $filter;

	/**
	 * @var BaseValidator
	 */
	protected BaseValidator $validator;

	/**
	 * @var BaseRepository
	 */
	protected BaseRepository $repository;

	/**
	 * @var BaseTransformer
	 */
	protected BaseTransformer $transformer;

	/**
	 * @var Skeleton
	 */
	protected Skeleton $skeleton;

	/**
	 * @param Skeleton $skeleton
	 */
	public function __construct(Skeleton $skeleton)
	{
		$this->skeleton = $skeleton;
	}

	/**
	 * @param $abstract
	 * @throws BindingResolutionException
	 */
	protected function setFilter($abstract)
	{
		$this->filter = $this->skeleton->makeInstance($abstract);
	}

	/**
	 * @param $abstract
	 * @throws BindingResolutionException
	 */
	protected function setValidator($abstract)
	{
		$this->validator = $this->skeleton->makeInstance($abstract);
	}

	/**
	 * @param $abstract
	 * @throws BindingResolutionException
	 */
	protected function setRepository($abstract)
	{
		$this->repository = $this->skeleton->makeInstance($abstract);
	}

	/**
	 * @param $abstract
	 * @throws BindingResolutionException
	 */
	protected function setTransformer($abstract)
	{
		$this->transformer = $this->skeleton->makeInstance($abstract);
	}

	/**
	 * @param $id
	 * @param array $data
	 * @return array|mixed
	 * @throws Exception
	 * @throws ValidationException
	 */
	public function single($id, array $data = [])
	{
		$this->validator
			->setData($data)
			->addParam('id', $id)
			->validate('single');

		$this->applyFixes($data);

		return $this->transformer->transform($this->repository->find($id));
	}

	/**
	 * @param array $data
	 * @return array[]
	 * @throws Exception
	 * @throws ValidationException
	 */
	public function collection(array $data = []): array
	{
		$this->validator
			->setData($data)
			->validate('collection');

		$this->applyFixes($data);

		return $this->transformer->transformCollection($this->repository->get());
	}

	/**
	 * @param array $data
	 * @return array|array[]
	 * @throws Exception
	 * @throws ValidationException
	 */
	public function pagination(array $data = []): array
	{
		$this->validator
			->setData($data)
			->validate('pagination');

		$this->applyFixes($data);

		$limit = $data['limit'] ?? $this->skeleton->getConfig('repositories.pagination.limit');

		return $this->transformer->transformPagination($this->repository->paginate($limit));
	}

	/**
	 * @param array $data
	 * @return mixed
	 * @throws Exception
	 */
	public function create(array $data)
	{
		$this->validator
			->setData($data)
			->validate('create');

		$this->repository->startTransaction();

		try {
			$result = $this->baseCreate($data);

			$this->repository->commitTransaction();

			return $result;
		} catch (Exception $exception) {
			$this->repository->rollBackTransaction();
			throw $exception;
		}
	}

	/**
	 * @param $id
	 * @param array $data
	 * @return mixed
	 * @throws Exception
	 */
	public function update($id, array $data)
	{
		$this->validator
			->setData($data)
			->addParam('id', $id)
			->validate('update');

		$this->repository->startTransaction();

		try {
			$result = $this->baseUpdate($id, $data);

			$this->repository->commitTransaction();

			return $result;
		} catch (Exception $exception) {
			$this->repository->rollBackTransaction();
			throw $exception;
		}
	}

	/**
	 * @param $id
	 * @param array $data
	 * @return mixed
	 * @throws Exception
	 */
	public function replace($id, array $data)
	{
		$this->validator
			->setData($data)
			->addParam('id', $id)
			->validate('replace');

		$this->repository->startTransaction();

		try {
			$result = $this->baseReplace($id, $data);

			$this->repository->commitTransaction();

			return $result;
		} catch (Exception $exception) {
			$this->repository->rollBackTransaction();
			throw $exception;
		}
	}

	/**
	 * @param $id
	 * @param array $data
	 * @return mixed
	 * @throws Exception
	 * @throws ValidationException
	 */
	public function delete($id)
	{
		$this->validator
			->addParam('id', $id)
			->validate('delete');

		$this->repository->startTransaction();

		try {
			$result = $this->baseDelete($id);

			$this->repository->commitTransaction();

			return $result;
		} catch (Exception $exception) {
			$this->repository->rollBackTransaction();
			throw $exception;
		}
	}


	/**
	 * @param $id
	 * @param array $data
	 * @return mixed
	 * @throws Exception
	 * @throws ValidationException
	 */
	public function deleteMultiple( $field, $values )
	{
		$this->validator
			->addParam($field, $values)
			->validate('deleteMultiple');

		$this->repository->startTransaction();

		try {
			$result = $this->baseDeleteMultiple( $field, $values );

			$this->repository->commitTransaction();

			return $result;
		} catch (Exception $exception) {
			$this->repository->rollBackTransaction();
			throw $exception;
		}
	}


	/**
	 * @param array $data
	 * @return mixed
	 * @throws Exception
	 */
	protected function baseCreate(array $data)
	{
		return $this->repository->create($data);
	}

	/**
	 * @param $id
	 * @param array $data
	 * @return mixed
	 * @throws Exception
	 */
	protected function baseUpdate($id, array $data)
	{
		return $this->repository->update($data, $id);
	}

	/**
	 * @param $id
	 * @param array $data
	 * @return mixed
	 * @throws Exception
	 */
	protected function baseReplace($id, array $data)
	{
		return $this->repository->update($data, $id);
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws Exception
	 */
	protected function baseDelete($id)
	{
		return $this->repository->delete($id);
	}



	/**
	 * @param $field
	 * @param array $values
	 * @return mixed
	 * @throws Exception
	 */
	protected function baseDeleteMultiple($field, $values)
	{
		return $this->repository->findWhereIn( $field, $values )->deleteAll();
	}


	/**
	 * @param array $data
	 * @return $this
	 * @throws Exception
	 */
	protected function applyFixes(array $data): self
	{
		$this->fixData($data);
		$this->fixFilters($data);

		return $this;
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	protected function fixFilters(array $data): self
	{
		$this->repository = $this->filter
			->setData($data)
			->setRepository($this->repository)
			->filter();

		return $this;
	}

	/**
	 * @param array $data
	 * @return $this
	 * @throws Exception
	 */
	protected function fixData(array $data): self
	{
		if (!Arr::get($data, '_data')) {
			return $this;
		}

		$this->repository->buildCriteria($data['_data']);

		return $this;
	}
}
