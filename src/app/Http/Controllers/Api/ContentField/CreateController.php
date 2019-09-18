<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\ContentField;

class CreateController extends Controller
{

    public function create(Request $request)
    {
        $this->validator( $request->all() )->validate();

        $contentField = new ContentField;
        $contentField = $this->_save( $request, $contentField );

        return response()->json( [ 'result' => 'ok', 'content_field'  => $contentField->toArray() ] );
    }


}
