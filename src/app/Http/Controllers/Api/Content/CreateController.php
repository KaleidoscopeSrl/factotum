<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentType;

class CreateController extends Controller
{

	public function create( Request $request ){
		$data = $request->all();

		$this->validator( $request, $data )->validate();

		$content = new Content();
		$content->content_type_id = $request->input('content_type_id');
		$this->_save( $request, $content );

		return response()->json( [ 'status' => 'ok', 'data' => $data ]);
	}


}

