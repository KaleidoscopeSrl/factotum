<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreContent;
use Kaleidoscope\Factotum\Models\Content;

class UpdateController extends ApiBaseController
{

	public function update( StoreContent $request, $id )
	{
		$data    = $request->all();
		$content = Content::find($id);

		if ( !isset($data['created_at']) ) {
			$data['created_at'] = date('Y-m-d H:i:s', $content->created_at / 1000 );
		}

		$content->fill( $data );
		$content->save();

		return response()->json( [ 'status' => 'ok', 'data' => $content->toArray() ]);
	}

}
