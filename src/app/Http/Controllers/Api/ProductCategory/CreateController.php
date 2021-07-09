<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductCategory;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreProductCategory;
use Kaleidoscope\Factotum\Models\ProductCategory;


class CreateController extends ApiBaseController
{

    public function create(StoreProductCategory $request)
    {
		$data = $request->all();

		$productCategory = new ProductCategory;
		$productCategory->fill($data);
		$productCategory->save();

        return response()->json( [ 'result' => 'ok', 'product_category'  => $productCategory->toArray() ] );
    }

}
