<?php

namespace Kaleidoscope\Factotum\Transformers\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Trait TransformCollectionTrait
 * @package Kaleidoscope\Factotum\Traits
 */
trait TransformCollectionTrait
{
    /**
     * @param Collection $collection
     * @return array
     */
    public function transformCollection(Collection $collection): array
    {
        $result = [];

        foreach ($collection as $item) {
            $result[] = $this->transform($item);
        }

        return [
            'collection' => $result
        ];
    }

    /**
     * @param LengthAwarePaginator $pagination
     * @return array
     */
    public function transformPagination(LengthAwarePaginator $pagination): array
    {
        if (empty($pagination)) {
            return [
                'data' => []
            ];
        }

        $paginated = $pagination->toArray();

        $result['collection'] = $this->transformCollection($pagination->getCollection())['collection'];
        $result['pagination'] = [
            'page' => $paginated['current_page'],
            'perPage' => $paginated['per_page'],
            'total' => $paginated['total'],
            'totalPages' => $paginated['last_page'],
        ];

        return $result;
    }
}
