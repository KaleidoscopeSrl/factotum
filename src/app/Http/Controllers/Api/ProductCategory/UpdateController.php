<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductCategory;

use Kaleidoscope\Factotum\ProductCategory;
use Kaleidoscope\Factotum\Http\Requests\StoreProductCategory;

class UpdateController extends Controller
{

	public function update(StoreProductCategory $request, $id)
	{
		$data = $request->all();

		$productCategory = ProductCategory::find($id);
		$productCategory->fill($data);
		$productCategory->save();

        return response()->json( [ 'result' => 'ok', 'product_category'  => $productCategory ] );
	}

}
