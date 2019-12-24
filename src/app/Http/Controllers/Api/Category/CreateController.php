<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\Http\Requests\StoreCategory;

class CreateController extends Controller
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
