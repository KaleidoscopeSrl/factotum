<?php

namespace Kaleidoscope\Factotum\Repositories\Traits;

use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Trait HasTransactions
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
}
