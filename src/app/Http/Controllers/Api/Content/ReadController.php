<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentType;

class ReadController extends Controller
{
	public function getList(Request $request)
	{
		$contentTypeId = $request->input('contentTypeId');

		$contents = Content::where('content_type_id', $contentTypeId)->get();

		return response()->json( [ 'result' => 'ok', 'contents' => $contents ]);
	}

	public function getContentsByType($contentTypeID)
	{
		if ($contentTypeID) {
			$contents = Content::where('content_type_id', '=', $contentTypeID)->get();

			$tmp = array();
			if ( count($contents) > 0 ) {
				foreach ( $contents as $content ) {
					$tmp[$content->id] = $content->title;
				}
			}
			return response()->json( [ 'status' => 'ok', 'data' => $tmp ]);
		}

		return response()->json( [ 'status' => 'ko' ]);
	}


	public function getDetail(Request $request, $id)
	{
		$content = Content::find($id);

		if ( $content ) {

			$content_type = ContentType::find( $content->content_type_id );

			$dataContent = DB::table( $content_type->content_type )->where( 'content_id', $content->id )->where( 'content_type_id', $content_type->id)->first();

			return response()->json( [ 'result' => 'ok', 'content' => $content, 'data' => $dataContent ]);
		}

		return $this->_sendJsonError('Campo non trovato.');
	}
}

