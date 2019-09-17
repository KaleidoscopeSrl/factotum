<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Content;

class ReadController extends Controller
{
	public function getList(Request $request)
	{
		$contentTypeId = $request->input('contentTypeId');

		$contents = Content::where('content_type_id', $contentTypeId)->get();

		return response()->json( [ 'result' => 'ok', 'contents' => $contents ]);
	}

	public function indexList($contentTypeId = null)
	{
		$contents = Content::treeChildsObjects( $contentTypeId, 50, $this->currentLanguage );

		return view('factotum::admin.content.list')
					->with('contentTypeId', $contentTypeId)
					->with('contentType', ContentType::find($contentTypeId))
					->with('contents', $contents);
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
}

