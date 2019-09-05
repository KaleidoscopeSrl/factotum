<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Category;

class UpdateController extends Controller
{


	public function update(Request $request, $id)
	{
		$data = $request->all();
		$this->validator( $request, $data, $id )->validate();

		$category = Category::find($id);
        $category = $this->_save( $request, $category );

        return response()->json( [ 'result' => 'ok', 'category'  => $category->toArray() ] );
	}


}
