<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreCategory;
use Kaleidoscope\Factotum\Models\Category;

class UpdateController extends ApiBaseController
{

	public function update(StoreCategory $request, $id)
	{
		$data = $request->all();

		$category = Category::find($id);
		$category->fill($data);
		$category->save();

        return response()->json( [ 'result' => 'ok', 'category'  => $category->toArray() ] );
	}

}
