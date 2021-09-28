<?php

namespace Kaleidoscope\Factotum\Repositories\Traits;

use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Trait HasActions
 * @package Kaleidoscope\Factotum\Repositories\Traits
 */
trait HasTransactions
{
	/**
	 * @return $this
	 * @throws Exception
	 */
	public function startTransaction(): self
	{
		DB::beginTransaction();

		return $this;
	}

	/**
	 * @return $this
	 */
	public function commitTransaction(): self
	{
		DB::commit();

		return $this;
	}

	/**
	 * @return $this
	 * @throws Exception
	 */
	public function rollBackTransaction(): self
	{
		DB::rollBack();

		return $this;
	}

	/**
	 * @return int
	 */
	public function transactionLevel(): int
	{
		return DB::transactionLevel();
	}

	/**
	 * @return $this
	 */
	public function lockForUpdate(): self
	{
		$this->model->lockForUpdate();

		return $this;
	}
}
