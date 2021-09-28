<?php

namespace Kaleidoscope\Factotum\Transformers;

use Kaleidoscope\Factotum\Skeleton;
use Kaleidoscope\Factotum\Transformers\Traits\TransformCollectionTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseTransformer
 * @package Kaleidoscope\Factotum\Transformers
 */
abstract class BaseTransformer
{
    use TransformCollectionTrait;

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
     * @param $item
     * @return array|mixed
     */
    public function transform($item): array
    {
        if ($item instanceof Model) {
            $transformed = $item->toArray();
        } else {
            $transformed = $item;
        }

        return $transformed;
    }
}
