<?php

namespace Kaleidoscope\Factotum\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Exception;

use Kaleidoscope\Factotum\Repositories\BaseRepository;
use Kaleidoscope\Factotum\Validators\BaseValidator;

/**
 * Class BaseService
 * @package Kaleidoscope\Factotum\Services
 */
abstract class BaseService
{
	/**
	 * @var BaseRepository
	 */
    protected $repository;

	/**
	 * @var BaseValidator
	 */
    protected $validator;

    /**
     * @var array
     */
    protected $listable = [
        'value' => 'id',
        'text'  => 'name',
    ];

    public function __construct(
        BaseRepository $repository,
		BaseValidator $validator
    )
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

	/**
	 * @param $abstract
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 */
    protected function setRepository($abstract)
    {
        $this->repository = app()->make($abstract);
    }

	/**
	 * @param $id
	 * @param array $data
	 * @return mixed
	 */
    public function single($id, array $data = [])
    {
	    $selects   = Arr::get( $data, 'selects', ['*'] );
	    $relations = Arr::get( $data, 'relations', [] );
	    $appends   = Arr::get( $data, 'appends', [] );

        return $this->repository->findById($id, $selects, $relations, $appends);
    }

	/**
	 * @param array $data
	 * @return array
	 */
    public function collection(array $data = []): array
    {
    	$selects   = Arr::get($data, 'selects', ['*']);
    	$relations = Arr::get($data, 'relations', null);

    	$selects   = ( is_string($selects) ? explode(',', $selects) : $selects );
    	$relations = ( $relations ? explode(',', $relations) : [] );

        return $this->repository->all($selects, $relations)->toArray();
    }

	/**
	 * @param array $data
	 * @return array
	 */
    public function pagination(array $data = []): array
    {
        $limit  = $data['limit']  ?? config('api.pagination.limit');

        return $this->repository->paginate($limit)->toArray();
    }

	/**
	 * @param array $data
	 * @return Model|null
	 * @throws Exception
	 */
    public function create(array $data): ?Model
    {
    	$this->validator->setData($data)
		                ->validate('create');

        $this->repository->startTransaction();

        try {
            $result = $this->repository->create($data);

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
	 * @return Model|null
	 * @throws Exception
	 */
    public function update($id, array $data): ?Model
    {
	    $this->validator->setData($data)
					    ->addParam('id', $id)
					    ->validate('update');

        $this->repository->startTransaction();

        try {
            $result = $this->repository->update($id, $data);

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
	 * @return bool
	 * @throws Exception
	 */
    public function delete($id, array $data = [])
    {
        $this->repository->startTransaction();

        try {
            $result = $this->repository->deleteById($id);

            $this->repository->commitTransaction();

            return $result;
        } catch (Exception $exception) {
            $this->repository->rollBackTransaction();
            throw $exception;
        }
    }


	/**
	 * @param array $ids
	 * @return bool
	 * @throws Exception
	 */
	public function deleteMultiple(array $ids)
	{
		$this->repository->startTransaction();

		try {

			foreach ( $ids as $id ) {
				$result = $this->repository->deleteById($id);
			}

			$this->repository->commitTransaction();

			return $result;
		} catch (Exception $exception) {
			$this->repository->rollBackTransaction();
			throw $exception;
		}
	}

}
