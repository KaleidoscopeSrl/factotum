<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreCategory;
use Kaleidoscope\Factotum\Models\Category;

class CreateController extends ApiBaseController
{

    public function create(StoreCategory $request)
    {
		$data = $request->all();

        $category = new Category;
		$category->fill($data);
		$category->save();

        return response()->json( [ 'result' => 'ok', 'category'  => $category->toArray() ] );
    }

}
