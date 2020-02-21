<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ContentType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Capability;


class ReadController extends Controller
{

	public function getList(Request $request)
	{
		$query = ContentType::capabilityFilter()
							->withCount('content_fields')
							->orderBy('order_no', 'ASC');

		$contentTypes = $query->get();

		return response()->json( [ 'result' => 'ok', 'content_types' => $contentTypes ]);
	}


	public function getDetail(Request $request, $id)
	{
		$contentType = ContentType::capabilityFilter()->find($id);

		if ( $contentType ) {
			return response()->json( [ 'result' => 'ok', 'content_type' => $contentType ]);
		}

		return $this->_sendJsonError( 'Content Type not found', 404 );
	}

}

