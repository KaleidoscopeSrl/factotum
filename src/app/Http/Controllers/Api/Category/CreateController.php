<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Category;

class CreateController extends Controller
{

    public function create(Request $request)
    {
        $this->validator( $request, $request->all() )->validate();

        $category = new Category;
        $category = $this->_save( $request, $category );

        return response()->json( [ 'result' => 'ok', 'category'  => $category->toArray() ] );
    }


}
