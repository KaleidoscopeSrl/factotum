<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;

class UpdateController extends Controller
{

    public function update(Request $request, $id)
    {
        $this->validator( $request->all(), $id )->validate();

        $oldContentField = ContentField::find( $id );
        $contentField = ContentField::find($id);

        $contentField->old_content_field = $oldContentField->name;
        $contentField = $this->_save( $request, $contentField );

        return response()->json( [ 'result' => 'ok', 'contentField'  => $contentField->toArray() ] );
    }

}
