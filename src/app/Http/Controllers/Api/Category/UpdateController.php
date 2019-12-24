<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\Http\Requests\StoreCategory;

class UpdateController extends Controller
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
