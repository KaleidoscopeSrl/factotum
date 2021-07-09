<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentField;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreContentField;
use Kaleidoscope\Factotum\Models\ContentField;


class UpdateController extends ApiBaseController
{

    public function update(StoreContentField $request, $id)
    {
		$data = $request->all();
		$contentField = ContentField::find( $id );
		$contentField->fill( $data );
		$contentField->save();

        return response()->json( [ 'result' => 'ok', 'contentField'  => $contentField->toArray() ] );
    }

}
